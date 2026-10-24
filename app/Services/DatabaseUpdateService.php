<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class DatabaseUpdateService {
    public static function flagPath(): string {
        return dirname(__DIR__, 2) . '/storage/db_update_pending.flag';
    }

    public static function isPending(): bool {
        return file_exists(self::flagPath());
    }

    public static function markPending(?string $reason = null): void {
        $dir = dirname(self::flagPath());
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        @file_put_contents(self::flagPath(), json_encode([
            'time' => date('Y-m-d H:i:s'),
            'reason' => $reason ?: 'Pembaruan skema database terdeteksi dari repositori.',
        ]));
    }

    public static function clearPending(): void {
        if (self::isPending()) @unlink(self::flagPath());
    }

    public static function runUpdate(): array {
        $db = Database::getInstance()->getConnection();
        $schemaFile = dirname(__DIR__, 2) . '/database/schema.sql';
        $seedsFile = dirname(__DIR__, 2) . '/database/seeds.sql';

        $executeSql = function(string $sql) use ($db): int {
            $stmts = array_filter(array_map('trim', explode(';', $sql)));
            $count = 0;
            foreach ($stmts as $stmt) {
                if (!empty($stmt)) {
                    try {
                        $db->exec($stmt);
                        $count++;
                    } catch (\PDOException $e) {
                        if (!str_contains(strtolower($e->getMessage()), 'duplicate column')) {
                            error_log("DB Update Notice: " . $e->getMessage());
                        }
                    }
                }
            }
            return $count;
        };

        $totalExecuted = 0;
        if (file_exists($schemaFile)) {
            $totalExecuted += $executeSql(file_get_contents($schemaFile));
        }
        if (file_exists($seedsFile)) {
            $totalExecuted += $executeSql(file_get_contents($seedsFile));
        }

        self::clearPending();

        Database::query(
            "REPLACE INTO settings (id, tenant_id, `key`, `value`, updated_at) VALUES ('set_db_version', 'system', 'db_updated_at', :val, CURRENT_TIMESTAMP)",
            ['val' => date('Y-m-d H:i:s')]
        );

        return [
            'success' => true,
            'statements_executed' => $totalExecuted,
            'updated_at' => date('Y-m-d H:i:s'),
            'message' => 'Seluruh skema database MySQL berhasil diperbarui ke versi terbaru.',
        ];
    }
}
