<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ChatService {
    public function __construct(
        private EngineService $engine = new EngineService()
    ) {}

    public function getConversations(string $tenantId, ?string $deviceId = null): array {
        $devSql = !empty($deviceId) ? "AND m.device_id = :did" : "";
        $devSub = !empty($deviceId) ? "AND device_id = :did_sub" : "";
        $params = ['tid' => $tenantId, 'tid2' => $tenantId, 'tid3' => $tenantId, 'tidu' => $tenantId, 'tids' => $tenantId];
        if (!empty($deviceId)) { $params['did'] = $deviceId; $params['did_sub'] = $deviceId; }

        $sql = "SELECT m.to_from, m.device_id, m.body, m.direction, m.type, m.created_at, m.status,
                       c.name AS contact_name, d.label AS device_label,
                       COALESCE(st.autoreply_paused, 0) AS autoreply_paused,
                       COALESCE(st.needs_human, 0) AS needs_human,
                       COALESCE(unr.unread_count, 0) AS unread_count
                FROM messages m
                INNER JOIN (
                    SELECT to_from, MAX(created_at) AS max_time FROM messages WHERE tenant_id = :tid {$devSub} GROUP BY to_from
                ) latest ON m.to_from = latest.to_from AND m.created_at = latest.max_time
                LEFT JOIN (
                    SELECT to_from, COUNT(*) AS unread_count FROM messages WHERE tenant_id = :tidu AND direction = 'inbound' AND (is_read = 0 OR is_read IS NULL) GROUP BY to_from
                ) unr ON unr.to_from = m.to_from
                LEFT JOIN crm_chat_states st ON st.tenant_id = :tids AND st.phone = m.to_from
                LEFT JOIN contacts c ON c.tenant_id = :tid2 AND (c.phone = m.to_from OR m.to_from LIKE CONCAT('%', c.phone, '%'))
                LEFT JOIN devices d ON d.id = m.device_id
                WHERE m.tenant_id = :tid3 {$devSql} ORDER BY m.created_at DESC LIMIT 100";
        return Database::fetchAll($sql, $params);
    }

    public function getContactByPhone(string $tenantId, string $phone): ?array {
        $clean = preg_replace('/@[a-z0-9.]+$/i', '', trim($phone));
        $std = str_starts_with($clean, '08') ? ('628' . substr($clean, 2)) : (str_starts_with($clean, '8') ? ('628' . substr($clean, 1)) : $clean);
        $loc = str_starts_with($std, '628') ? ('08' . substr($std, 3)) : $std;
        $sql = "SELECT c.*, t.name AS tag_name, t.color AS tag_color, COALESCE(st.autoreply_paused, 0) AS autoreply_paused, COALESCE(st.needs_human, 0) AS needs_human FROM contacts c LEFT JOIN tags t ON t.id = c.tag_id LEFT JOIN crm_chat_states st ON st.tenant_id = c.tenant_id AND st.phone = c.phone WHERE c.tenant_id = :tid AND (c.phone = :p1 OR c.phone = :p2 OR c.phone = :p3 OR c.phone = :p4) LIMIT 1";
        return Database::fetchOne($sql, ['tid' => $tenantId, 'p1' => $phone, 'p2' => $clean, 'p3' => $std, 'p4' => $loc]);
    }

    public function getMessages(string $tenantId, string $toFrom, int $limit = 100): array {
        $clean = preg_replace('/[^0-9]/', '', $toFrom);
        $withPlus = '+' . $clean;
        Database::query("UPDATE messages SET is_read = 1 WHERE tenant_id = :tid AND (to_from = :c1 OR to_from = :c2 OR to_from = :c3) AND (is_read = 0 OR is_read IS NULL)", ['tid' => $tenantId, 'c1' => $toFrom, 'c2' => $clean, 'c3' => $withPlus]);
        $sql = "SELECT * FROM (SELECT m.*, d.label AS device_label, c.name AS contact_name FROM messages m LEFT JOIN devices d ON d.id = m.device_id LEFT JOIN contacts c ON c.tenant_id = m.tenant_id AND (c.phone = m.to_from OR m.to_from LIKE CONCAT('%', c.phone, '%')) WHERE m.tenant_id = :tid AND (m.to_from = :c1 OR m.to_from = :c2 OR m.to_from = :c3) ORDER BY m.created_at DESC LIMIT " . max(1, min(200, (int)$limit)) . ") s ORDER BY s.created_at ASC";
        return Database::fetchAll($sql, ['tid' => $tenantId, 'c1' => $toFrom, 'c2' => $clean, 'c3' => $withPlus]);
    }

    public function toggleAutoreply(string $tenantId, string $phone, bool $active): array {
        $paused = $active ? 0 : 1;
        Database::query("REPLACE INTO crm_chat_states (tenant_id, phone, autoreply_paused, needs_human, updated_at) VALUES (:tid, :p, :pz, :nh, CURRENT_TIMESTAMP)", ['tid' => $tenantId, 'p' => $phone, 'pz' => $paused, 'nh' => $paused]);
        return ['success' => true, 'autoreply_paused' => $paused];
    }

    public function sendReply(string $tenantId, string $deviceId, string $toFrom, string $message, string $type = 'text', ?string $mediaUrl = null, ?string $filename = null): array {
        $dev = Database::fetchOne("SELECT * FROM devices WHERE id = :did AND tenant_id = :tid", ['did' => $deviceId, 'tid' => $tenantId]);
        if (!$dev || $dev['status'] !== 'connected') return ['success' => false, 'error' => 'Perangkat WhatsApp pengirim offline / tidak ditemukan.'];
        $target = trim($toFrom);
        if (!str_ends_with($target, '@g.us') && !str_ends_with($target, '@lid')) {
            $num = preg_replace('/[^0-9]/', '', $target);
            $target = str_starts_with($num, '08') ? ('628' . substr($num, 2)) : (str_starts_with($num, '8') ? ('628' . substr($num, 1)) : $num);
        }
        $msgId = 'msg_chat_' . bin2hex(random_bytes(8));
        Database::query("INSERT INTO messages (id, tenant_id, device_id, direction, to_from, type, body, media_ref, status, is_read, created_at) VALUES (:id, :tid, :did, 'outbound', :to, :type, :body, :media, 'queued', 1, CURRENT_TIMESTAMP)", ['id' => $msgId, 'tid' => $tenantId, 'did' => $deviceId, 'to' => $target, 'type' => $type, 'body' => $message, 'media' => $mediaUrl]);
        $payload = ['type' => $type, 'message' => $message, 'url' => $mediaUrl, 'media_url' => $mediaUrl, 'filename' => $filename];
        $targetSend = $target;
        if (!str_ends_with($target, '@g.us') && !str_ends_with($target, '@lid')) {
            $rowLid = Database::fetchOne("SELECT lid FROM whatsapp_lids WHERE tenant_id = :tid AND phone = :p AND lid LIKE '%@lid' ORDER BY updated_at DESC LIMIT 1", ['tid' => $tenantId, 'p' => $target]);
            if ($rowLid && !empty($rowLid['lid'])) $targetSend = $rowLid['lid'];
        }
        $res = $this->engine->sendMessage($dev['session_ref'], $targetSend, $payload);
        $status = ($res && !empty($res['success'])) ? 'sent' : 'failed';
        Database::query("UPDATE messages SET status = :st, error = :err, sent_at = CURRENT_TIMESTAMP WHERE id = :id", ['st' => $status, 'err' => ($status === 'sent') ? null : ($res['error'] ?? 'Gagal kirim'), 'id' => $msgId]);
        if ($status === 'sent') (new QuotaService())->recordUsage($tenantId, 1, 0);
        return ['success' => $status === 'sent', 'message_id' => $msgId, 'status' => $status, 'error' => ($status === 'sent') ? null : ($res['error'] ?? 'Gagal kirim')];
    }
}
