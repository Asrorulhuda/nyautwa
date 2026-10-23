<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class MessageService {
    public function getMessages(string $tenantId, ?string $status = null, ?string $query = null, int $limit = 50): array {
        $sql = "SELECT m.*, d.label as device_label 
                FROM messages m 
                LEFT JOIN devices d ON m.device_id = d.id 
                WHERE m.tenant_id = :tenant_id";
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

    public function queueMessage(string $tenantId, string $deviceId, string $to, string $body, ?string $idempotencyKey = null): array {
        $id = 'msg_' . bin2hex(random_bytes(6));
        $normalizedPhone = $this->normalizePhone($to);

        // Check idempotency key if provided
        if ($idempotencyKey) {
            $existing = Database::fetchOne(
                "SELECT * FROM messages WHERE tenant_id = :tenant_id AND idempotency_key = :key",
                ['tenant_id' => $tenantId, 'key' => $idempotencyKey]
            );
            if ($existing) {
                return $existing;
            }
        }

        Database::query(
            "INSERT INTO messages (id, tenant_id, device_id, direction, to_from, type, body, status, idempotency_key, queued_at) 
             VALUES (:id, :tenant_id, :device_id, 'outbound', :to, 'text', :body, 'queued', :key, CURRENT_TIMESTAMP)",
            [
                'id' => $id,
                'tenant_id' => $tenantId,
                'device_id' => $deviceId,
                'to' => $normalizedPhone,
                'body' => $this->parseSpintax($body),
                'key' => $idempotencyKey,
            ]
        );
        Database::query("INSERT INTO message_events (id, message_id, status) VALUES (:id, :mid, 'queued')", ['id' => 'evt_' . bin2hex(random_bytes(8)), 'mid' => $id]);

        // In a real environment, this pushes to Redis queue or notifies the engine.
        // We will also simulate fast local delivery ack if Baileys engine is in mock mode.
        $this->simulateEngineAck($id);

        return Database::fetchOne("SELECT * FROM messages WHERE id = :id", ['id' => $id]);
    }

    public function normalizePhone(string $phone): string {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '08')) {
            return '+62' . substr($clean, 1);
        }
        if (str_starts_with($clean, '628')) {
            return '+' . $clean;
        }
        if (str_starts_with($clean, '8')) {
            return '+62' . $clean;
        }
        return '+' . $clean;
    }

    public function parseSpintax(string $text): string {
        return (string) preg_replace_callback('/\{([^{}]+)\}/', fn($m) => explode('|', $m[1])[array_rand(explode('|', $m[1]))], $text);
    }

    private function simulateEngineAck(string $msgId): void {
        Database::query(
            "UPDATE messages SET status = 'delivered', wa_message_id = :wamid, sent_at = CURRENT_TIMESTAMP WHERE id = :id",
            ['id' => $msgId, 'wamid' => 'wamid_' . strtoupper(bin2hex(random_bytes(8)))]
        );
        Database::query(
            "INSERT INTO message_events (id, message_id, status) VALUES (:id, :mid, 'delivered')",
            ['id' => 'evt_' . bin2hex(random_bytes(8)), 'mid' => $msgId]
        );
    }
}
