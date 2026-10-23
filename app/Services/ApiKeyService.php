<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ApiKeyService {
    public function getKeys(string $tenantId): array {
        return Database::fetchAll(
            "SELECT id, name, prefix, last_used_at, revoked_at, created_at FROM api_keys WHERE tenant_id = :tenant_id ORDER BY created_at DESC",
            ['tenant_id' => $tenantId]
        );
    }

    public function createKey(string $tenantId, string $name): array {
        $id = 'key_' . bin2hex(random_bytes(6));
        $secret = bin2hex(random_bytes(16));
        $rawKey = 'nyaut_live_' . $secret;
        $prefix = substr($rawKey, 0, 15) . '...';
        $keyHash = hash('sha256', $rawKey);

        Database::query(
            "INSERT INTO api_keys (id, tenant_id, name, key_hash, prefix, created_at) VALUES (:id, :tenant_id, :name, :key_hash, :prefix, CURRENT_TIMESTAMP)",
            [
                'id' => $id,
                'tenant_id' => $tenantId,
                'name' => $name,
                'key_hash' => $keyHash,
                'prefix' => $prefix,
            ]
        );

        return [
            'id' => $id,
            'name' => $name,
            'raw_key' => $rawKey,
            'prefix' => $prefix,
        ];
    }

    public function revokeKey(string $keyId, string $tenantId): bool {
        return Database::execute(
            "UPDATE api_keys SET revoked_at = CURRENT_TIMESTAMP WHERE id = :id AND tenant_id = :tenant_id",
            ['id' => $keyId, 'tenant_id' => $tenantId]
        );
    }

    public function validateRawKey(string $rawKey): ?array {
        $hash = hash('sha256', $rawKey);
        $key = Database::fetchOne(
            "SELECT * FROM api_keys WHERE key_hash = :hash AND revoked_at IS NULL",
            ['hash' => $hash]
        );

        if ($key) {
            Database::query("UPDATE api_keys SET last_used_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $key['id']]);
            return Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $key['tenant_id']]);
        }

        return null;
    }

    public function updateWebhook(string $tenantId, string $webhookUrl): void {
        Database::query(
            "UPDATE devices SET webhook_url = :url WHERE tenant_id = :tenant_id",
            ['url' => $webhookUrl, 'tenant_id' => $tenantId]
        );
    }
}
