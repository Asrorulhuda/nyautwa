<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class AutoReplyService {
    public function getAll(string $tenantId): array {
        return Database::fetchAll(
            "SELECT a.*, d.label as device_label FROM autoreplies a LEFT JOIN devices d ON a.device_id = d.id WHERE a.tenant_id = :tenant_id ORDER BY a.created_at DESC",
            ['tenant_id' => $tenantId]
        );
    }

    public function find(string $id, string $tenantId): ?array {
        return Database::fetchOne(
            "SELECT * FROM autoreplies WHERE id = :id AND tenant_id = :tenant_id",
            ['id' => $id, 'tenant_id' => $tenantId]
        );
    }

    public function create(string $tenantId, array $data): bool {
        $id = 'rep_' . bin2hex(random_bytes(6));
        $opts = !empty($data['options']) ? (is_string($data['options']) ? $data['options'] : json_encode($data['options'])) : null;
        return Database::execute(
            "INSERT INTO autoreplies (id, tenant_id, device_id, keyword, match_type, type, response, media_url, options, delay_seconds, status) VALUES (:id, :tenant_id, :device_id, :keyword, :match_type, :type, :response, :media_url, :options, :delay_seconds, 'active')",
            [
                'id' => $id, 'tenant_id' => $tenantId, 'device_id' => !empty($data['device_id']) ? $data['device_id'] : null,
                'keyword' => trim($data['keyword']), 'match_type' => $data['match_type'] ?? 'contain',
                'type' => $data['type'] ?? 'text', 'response' => trim($data['response']),
                'media_url' => $data['media_url'] ?? null, 'options' => $opts,
                'delay_seconds' => (int) ($data['delay_seconds'] ?? 1),
            ]
        );
    }

    public function update(string $id, string $tenantId, array $data): bool {
        $opts = !empty($data['options']) ? (is_string($data['options']) ? $data['options'] : json_encode($data['options'])) : null;
        $mediaSql = array_key_exists('media_url', $data) ? ", media_url = :media_url" : "";
        $params = [
            'id' => $id, 'tenant_id' => $tenantId, 'device_id' => !empty($data['device_id']) ? $data['device_id'] : null,
            'keyword' => trim((string) ($data['keyword'] ?? '')), 'match_type' => $data['match_type'] ?? 'contain',
            'type' => $data['type'] ?? 'text', 'response' => trim((string) ($data['response'] ?? '')),
            'options' => $opts, 'delay_seconds' => (int) ($data['delay_seconds'] ?? 1),
        ];
        if (array_key_exists('media_url', $data)) $params['media_url'] = $data['media_url'];
        return Database::execute(
            "UPDATE autoreplies SET device_id = :device_id, keyword = :keyword, match_type = :match_type, type = :type, response = :response, options = :options, delay_seconds = :delay_seconds {$mediaSql} WHERE id = :id AND tenant_id = :tenant_id",
            $params
        );
    }

    public function delete(string $id, string $tenantId): bool {
        return Database::execute("DELETE FROM autoreplies WHERE id = :id AND tenant_id = :tenant_id", ['id' => $id, 'tenant_id' => $tenantId]);
    }

    public function deleteBulk(array $ids, string $tenantId): int {
        if (empty($ids)) return 0;
        $cleanIds = array_values(array_filter($ids, 'is_string'));
        if (empty($cleanIds)) return 0;
        $in = implode(',', array_fill(0, count($cleanIds), '?'));
        return Database::execute("DELETE FROM autoreplies WHERE tenant_id = ? AND id IN ({$in})", array_merge([$tenantId], $cleanIds));
    }

    public function deleteAll(string $tenantId, ?string $deviceId = null): int {
        if (!empty($deviceId)) {
            return Database::execute("DELETE FROM autoreplies WHERE tenant_id = :tid AND device_id = :did", ['tid' => $tenantId, 'did' => $deviceId]);
        }
        return Database::execute("DELETE FROM autoreplies WHERE tenant_id = :tid", ['tid' => $tenantId]);
    }

    public function toggle(string $id, string $tenantId): bool {
        $item = Database::fetchOne("SELECT status FROM autoreplies WHERE id = :id AND tenant_id = :tenant_id", ['id' => $id, 'tenant_id' => $tenantId]);
        if (!$item) return false;
        $next = $item['status'] === 'active' ? 'inactive' : 'active';
        return Database::execute("UPDATE autoreplies SET status = :status WHERE id = :id", ['status' => $next, 'id' => $id]);
    }
}
