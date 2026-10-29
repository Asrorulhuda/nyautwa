<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Services\EngineService;

class InternalCallbackController {
    public function handle(Request $request): void {
        $secret = $request->header('x-engine-secret') ?? ($_SERVER['HTTP_X_ENGINE_SECRET'] ?? '');
        $expected = (string) env('ENGINE_SECRET', '');
        if (empty($expected)) {
            error_log('[Security] ENGINE_SECRET tidak dikonfigurasi di .env — akses engine-callback ditolak.');
            Response::json(['error' => 'Konfigurasi server tidak lengkap'], 500);
            return;
        }
        if (!hash_equals($expected, (string) $secret)) {
            Response::json(['error' => 'Akses ditolak'], 403);
            return;
        }

        $event = (string) $request->input('event');
        $data = (array) $request->input('data', []);
        $sessionRef = (string) ($data['session_ref'] ?? '');

        if ($event === 'connection.connected') {
            Database::query("UPDATE devices SET status = 'connected', phone = :phone, qr_code = NULL, updated_at = CURRENT_TIMESTAMP WHERE session_ref = :ref", ['phone' => $data['phone'] ?? null, 'ref' => $sessionRef]);
        } elseif ($event === 'connection.disconnected') {
            Database::query("UPDATE devices SET status = 'disconnected', qr_code = NULL, updated_at = CURRENT_TIMESTAMP WHERE session_ref = :ref", ['ref' => $sessionRef]);
        } elseif ($event === 'connection.qr') {
            Database::query("UPDATE devices SET qr_code = :qr, status = 'pending_qr', updated_at = CURRENT_TIMESTAMP WHERE session_ref = :ref", ['qr' => $data['qr'] ?? null, 'ref' => $sessionRef]);
        } elseif ($event === 'messages.incoming') {
            $this->handleIncomingMessage($sessionRef, $data);
        }

        Response::json(['success' => true]);
    }

    private function resolveSender(string $tenantId, string $sender, ?string $raw): string {
        if (!empty($raw) && str_ends_with($raw, '@lid') && !str_ends_with($sender, '@lid')) {
            Database::query("REPLACE INTO whatsapp_lids (tenant_id, phone, lid, updated_at) VALUES (:tid, :p, :lid, CURRENT_TIMESTAMP)", ['tid' => $tenantId, 'p' => $sender, 'lid' => $raw]);
            return $sender;
        }
        if (str_ends_with($sender, '@lid')) {
            $row = Database::fetchOne("SELECT phone FROM whatsapp_lids WHERE tenant_id = :tid AND (lid = :s1 OR lid = :s2) LIMIT 1", ['tid' => $tenantId, 's1' => $sender, 's2' => explode('@', $sender)[0]]);
            if ($row && !empty($row['phone'])) return $row['phone'];
        }
        return $sender;
    }

    private function handleIncomingMessage(string $sessionRef, array $data): void {
        $dev = Database::fetchOne("SELECT * FROM devices WHERE session_ref = :ref", ['ref' => $sessionRef]);
        if (!$dev) return;
        $rawSender = (string) ($data['raw_sender'] ?? '');
        $sender = $this->resolveSender($dev['tenant_id'], (string) ($data['sender'] ?? ''), $rawSender);
        $text = trim((string) ($data['text'] ?? ''));
        if (empty($sender) || empty($text)) return;

        try {
            Database::query("INSERT INTO messages (id, tenant_id, device_id, direction, to_from, type, body, status, is_read, created_at) VALUES (:id, :tid, :did, 'inbound', :sender, 'text', :body, 'delivered', 0, CURRENT_TIMESTAMP)", ['id' => 'msg_in_' . bin2hex(random_bytes(6)), 'tid' => $dev['tenant_id'], 'did' => $dev['id'], 'sender' => $sender, 'body' => $text]);
        } catch (\Throwable $e) { error_log("[LogPesan] Inbound: " . $e->getMessage()); }

        $isSeller = in_array(strtolower($text), ['cs', 'seller', 'admin', 'bantuan', 'bicara seller', 'bicara dengan seller', 'ingin bicara dengan seller'], true);
        if ($isSeller) {
            Database::query("REPLACE INTO crm_chat_states (tenant_id, phone, autoreply_paused, needs_human, updated_at) VALUES (:tid, :p, 1, 1, CURRENT_TIMESTAMP)", ['tid' => $dev['tenant_id'], 'p' => $sender]);
        }

        $state = Database::fetchOne("SELECT autoreply_paused FROM crm_chat_states WHERE tenant_id = :tid AND phone = :p", ['tid' => $dev['tenant_id'], 'p' => $sender]);
        if ($state && (int)$state['autoreply_paused'] === 1 && !$isSeller) return;

        $reply = Database::fetchOne("SELECT * FROM autoreplies WHERE tenant_id = :tid AND status = 'active' AND (device_id IS NULL OR device_id = :did) AND ((match_type = 'exact' AND LOWER(keyword) = LOWER(:t1)) OR (match_type = 'contain' AND LOWER(:t2) LIKE LOWER(CONCAT('%', keyword, '%')))) ORDER BY (device_id IS NOT NULL) DESC, created_at DESC LIMIT 1", ['tid' => $dev['tenant_id'], 'did' => $dev['id'], 't1' => $text, 't2' => $text]);
        if (!$reply) return;

        $payload = ['type' => $reply['type'] ?? 'text', 'message' => $reply['response'], 'url' => $reply['media_url'] ?? null];
        if (!empty($reply['options']) && is_array($opts = json_decode((string)$reply['options'], true))) { $payload['options'] = $opts; $payload['buttons'] = $opts; }
        $targetSend = (!empty($rawSender) && (str_ends_with($rawSender, '@lid') || str_ends_with($rawSender, '@g.us'))) ? $rawSender : $sender;
        $res = (new EngineService())->sendMessage($sessionRef, $targetSend, $payload);
        $wamid = $res['wa_message_id'] ?? ($res['data']['wa_message_id'] ?? null);
        try {
            Database::query("INSERT INTO messages (id, tenant_id, device_id, direction, to_from, type, body, media_ref, status, wa_message_id, is_read, created_at) VALUES (:id, :tid, :did, 'outbound', :to, :type, :body, :media, 'sent', :wamid, 1, CURRENT_TIMESTAMP)", ['id' => 'msg_rep_' . bin2hex(random_bytes(6)), 'tid' => $dev['tenant_id'], 'did' => $dev['id'], 'to' => $sender, 'type' => $reply['type'] ?? 'text', 'body' => $reply['response'], 'media' => $reply['media_url'] ?? null, 'wamid' => $wamid]);
        } catch (\Throwable $e) { error_log("[LogPesan] Outbound: " . $e->getMessage()); }
    }
}
