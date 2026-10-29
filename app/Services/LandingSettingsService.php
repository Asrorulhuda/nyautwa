<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class LandingSettingsService {
    public function getAll(): array {
        $defaults = $this->getDefaults();
        try {
            $rows = Database::fetchAll("SELECT `key`, `value` FROM settings");
            foreach ($rows as $row) {
                if (isset($row['key']) && isset($row['value'])) {
                    $defaults[$row['key']] = $row['value'];
                }
            }
        } catch (\Throwable $e) {
            // Fallback to defaults if table query fails
        }
        return $defaults;
    }

    public function set(string $key, string $value, string $category = 'landing'): void {
        $exists = Database::fetchOne("SELECT `key` FROM settings WHERE `key` = :key", ['key' => $key]);
        if ($exists) {
            Database::query(
                "UPDATE settings SET `value` = :val, `updated_at` = CURRENT_TIMESTAMP WHERE `key` = :key",
                ['key' => $key, 'val' => $value]
            );
        } else {
            $id = 'set_' . bin2hex(random_bytes(8));
            Database::query(
                "INSERT INTO settings (id, tenant_id, `key`, `value`, `updated_at`) VALUES (:id, 'system', :key, :val, CURRENT_TIMESTAMP)",
                ['id' => $id, 'key' => $key, 'val' => $value]
            );
        }
    }

    public function updateBatch(array $data, string $category = 'landing'): void {
        foreach ($data as $k => $v) {
            if (is_string($v) || is_numeric($v)) {
                $this->set((string)$k, (string)$v, $category);
            }
        }
    }

    public function getDefaults(): array {
        $path = dirname(__DIR__, 2) . '/config/default_settings.php';
        return file_exists($path) ? (require $path) : [];
    }
}
