<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class AutoReplyService {
    public function getAll(string $tenantId): array {
        return Database::fetchAll(
            "SELECT * FROM autoreplies WHERE tenant_id = :tenant_id ORDER BY created_at DESC",
            ['tenant_id' => $tenantId]
        );
    }

    public function create(string $tenantId, array $data): bool {
        $id = 'rep_' . bin2hex(random_bytes(6));
        return Database::execute(
            "INSERT INTO autoreplies (id, tenant_id, keyword, match_type, type, response, media_url, delay_seconds, status) 
             VALUES (:id, :tenant_id, :keyword, :match_type, :type, :response, :media_url, :delay_seconds, 'active')",
            [
                'id' => $id,
                'tenant_id' => $tenantId,
                'keyword' => trim($data['keyword']),
                'match_type' => $data['match_type'] ?? 'contain',
                'type' => $data['type'] ?? 'text',
                'response' => trim($data['response']),
                'media_url' => $data['media_url'] ?? null,
                'delay_seconds' => (int) ($data['delay_seconds'] ?? 1),
            ]
        );
    }

    public function delete(string $id, string $tenantId): bool {
        return Database::execute(
            "DELETE FROM autoreplies WHERE id = :id AND tenant_id = :tenant_id",
            ['id' => $id, 'tenant_id' => $tenantId]
        );
    }

    public function toggle(string $id, string $tenantId): bool {
        $item = Database::fetchOne(
            "SELECT status FROM autoreplies WHERE id = :id AND tenant_id = :tenant_id",
            ['id' => $id, 'tenant_id' => $tenantId]
        );
        if (!$item) return false;
        $next = $item['status'] === 'active' ? 'inactive' : 'active';
        return Database::execute(
            "UPDATE autoreplies SET status = :status WHERE id = :id",
            ['status' => $next, 'id' => $id]
        );
    }
}
