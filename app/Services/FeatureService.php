<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class FeatureService {
    public function getAll(): array {
        return Database::fetchAll("SELECT * FROM features ORDER BY created_at ASC");
    }

    public function create(string $name, ?string $code = null, string $category = 'custom'): string {
        $cleanName = trim($name);
        $cleanCode = $code ? strtolower(trim($code)) : strtolower(preg_replace('/[^a-z0-9_]+/i', '_', $cleanName));
        $cleanCode = trim($cleanCode, '_');

        Database::query(
            "INSERT IGNORE INTO features (code, name, category, created_at) VALUES (:code, :name, :category, CURRENT_TIMESTAMP)",
            ['code' => $cleanCode, 'name' => $cleanName, 'category' => $category]
        );
        return $cleanCode;
    }

    public function syncTenantFeatures(string $tenantId, array $featureCodes): void {
        Database::query("DELETE FROM tenant_features WHERE tenant_id = :tid", ['tid' => $tenantId]);
        foreach ($featureCodes as $code) {
            $code = trim((string)$code);
            if (!empty($code)) {
                Database::query(
                    "INSERT IGNORE INTO tenant_features (tenant_id, feature_code, enabled) VALUES (:tid, :code, 1)",
                    ['tid' => $tenantId, 'code' => $code]
                );
            }
        }
    }

    public function getTenantFeatures(string $tenantId): array {
        $rows = Database::fetchAll(
            "SELECT feature_code FROM tenant_features WHERE tenant_id = :tid AND enabled = 1",
            ['tid' => $tenantId]
        );
        return array_column($rows, 'feature_code');
    }
}
