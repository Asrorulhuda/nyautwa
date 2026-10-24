<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class MessageService {
    private EngineService $engine;

    public function __construct() {
        $this->engine = new EngineService();
    }

    public function getMessages(string $tenantId, ?string $status = null, ?string $query = null, int $limit = 50): array {
        $sql = "SELECT m.*, d.label as device_label FROM messages m LEFT JOIN devices d ON m.device_id = d.id WHERE m.tenant_id = :tenant_id";
        $params = ['tenant_id' => $tenantId];
        if ($status && $status !== 'all') {
            $sql .= " AND m.status = :status";
            $params['status'] = $status;
        }
        if ($query) {
            $sql .= " AND (m.to_from LIKE :q OR m.body LIKE :q OR m.id LIKE :q)";
            $params['q'] = '%' . $query . '%';
        }
        $sql .= " ORDER BY m.created_at DESC LIMIT " . (int) $limit;
        return Database::fetchAll($sql, $params);
    }

    public function queueMessage(string $tenantId, string $deviceId, string $to, string $body, string $type = 'text', array $extra = [], ?string $key = null): array {
        $id = 'msg_' . bin2hex(random_bytes(6));
        $normalizedPhone = $this->normalizePhone($to);
        $cleanPhone = ltrim($normalizedPhone, '+');
        $parsedBody = $this->parseSpintax($body);
        $dev = Database::fetchOne("SELECT session_ref, status FROM devices WHERE id = :id AND tenant_id = :tid", ['id' => $deviceId, 'tid' => $tenantId]);

        Database::query(
            "INSERT INTO messages (id, tenant_id, device_id, direction, to_from, type, body, status, idempotency_key, queued_at) 
             VALUES (:id, :tenant_id, :device_id, 'outbound', :to, :type, :body, 'queued', :key, CURRENT_TIMESTAMP)",
            ['id' => $id, 'tenant_id' => $tenantId, 'device_id' => $deviceId, 'to' => $normalizedPhone, 'type' => $type, 'body' => $parsedBody, 'key' => $key]
        );
        Database::query("INSERT INTO message_events (id, message_id, status) VALUES (:id, :mid, 'queued')", ['id' => 'evt_' . bin2hex(random_bytes(8)), 'mid' => $id]);

        $payload = array_merge(['message' => $parsedBody, 'type' => $type], $extra);
        $res = $this->engine->sendMessage($dev['session_ref'] ?? 'dev_primary_01', $cleanPhone, $payload);

        if (!empty($res['success'])) {
            $waId = $res['wa_message_id'] ?? ('wamid_' . bin2hex(random_bytes(8)));
            Database::query("UPDATE messages SET status = 'sent', wa_message_id = :wid, sent_at = CURRENT_TIMESTAMP WHERE id = :id", ['wid' => $waId, 'id' => $id]);
            Database::query("INSERT INTO message_events (id, message_id, status) VALUES (:id, :mid, 'sent')", ['id' => 'evt_' . bin2hex(random_bytes(8)), 'mid' => $id]);
        } else {
            Database::query("UPDATE messages SET status = 'failed' WHERE id = :id", ['id' => $id]);
            Database::query("INSERT INTO message_events (id, message_id, status) VALUES (:id, :mid, 'failed')", ['id' => 'evt_' . bin2hex(random_bytes(8)), 'mid' => $id]);
        }

        $msg = Database::fetchOne("SELECT * FROM messages WHERE id = :id", ['id' => $id]);
        $msg['engine_response'] = $res;
        return $msg;
    }

    public function deleteMessage(string $id, string $tenantId): bool {
        Database::query("DELETE FROM message_events WHERE message_id = :id", ['id' => $id]);
        return Database::execute("DELETE FROM messages WHERE id = :id AND tenant_id = :tid", ['id' => $id, 'tid' => $tenantId]);
    }

    public function deleteBulkMessages(array $ids, string $tenantId): int {
        $valid = array_values(array_filter(array_map('strval', $ids)));
        if (empty($valid)) return 0;
        $in = implode(',', array_fill(0, count($valid), '?'));
        Database::query("DELETE FROM message_events WHERE message_id IN ($in)", $valid);
        return Database::query("DELETE FROM messages WHERE id IN ($in) AND tenant_id = ?", array_merge($valid, [$tenantId]))->rowCount();
    }

    public function normalizePhone(string $phone): string {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '08')) return '+62' . substr($clean, 1);
        if (str_starts_with($clean, '628')) return '+' . $clean;
        if (str_starts_with($clean, '8')) return '+62' . $clean;
        return '+' . $clean;
    }

    public function parseSpintax(string $text): string {
        return (string) preg_replace_callback('/\{([^{}]+)\}/', fn($m) => explode('|', $m[1])[array_rand(explode('|', $m[1]))], $text);
    }
}
