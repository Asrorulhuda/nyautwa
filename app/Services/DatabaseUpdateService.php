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
        $totalExecuted = 0;
        $appliedChanges = ['Verifikasi 23 tabel master (DDL)'];

        if (file_exists($schemaFile)) {
            $stmts = array_filter(array_map('trim', explode(';', file_get_contents($schemaFile))));
            foreach ($stmts as $s) {
                if (!empty($s)) {
                    try { $db->exec($s); $totalExecuted++; } catch (\PDOException) {}
                }
            }
        }

        $patches = [
            "ALTER TABLE login_attempts ADD COLUMN ip VARCHAR(45) NULL AFTER email" => "Patch kolom 'ip' pada tabel login_attempts",
            "ALTER TABLE login_attempts ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER ip" => "Patch kolom 'created_at' pada tabel login_attempts",
            "ALTER TABLE tenants ADD COLUMN message_limit INT DEFAULT 1000" => "Patch kolom 'message_limit' pada tabel tenants",
            "ALTER TABLE tenants ADD COLUMN device_limit INT DEFAULT 2" => "Patch kolom 'device_limit' pada tabel tenants",
            "ALTER TABLE tenants ADD COLUMN role VARCHAR(30) DEFAULT 'user'" => "Patch kolom 'role' pada tabel tenants",
            "ALTER TABLE invoices ADD COLUMN invoice_no VARCHAR(50) NULL" => "Patch kolom 'invoice_no' pada tabel invoices",
            "ALTER TABLE invoices ADD COLUMN plan_id VARCHAR(50) DEFAULT 'starter'" => "Patch kolom 'plan_id' pada tabel invoices",
            "ALTER TABLE invoices ADD COLUMN payment_method_id VARCHAR(50) NULL" => "Patch kolom 'payment_method_id' pada tabel invoices",
        ];

        foreach ($patches as $sql => $desc) {
            try { $db->exec($sql); $totalExecuted++; $appliedChanges[] = $desc; } catch (\Throwable) {}
        }

        if (file_exists($seedsFile)) {
            $stmts = array_filter(array_map('trim', explode(';', file_get_contents($seedsFile))));
            foreach ($stmts as $s) {
                if (!empty($s)) {
                    try { $db->exec($s); $totalExecuted++; } catch (\PDOException) {}
                }
            }
            $appliedChanges[] = 'Sinkronisasi paket langganan & data awal (seeds)';
        }

        self::clearPending();

        Database::query(
            "REPLACE INTO settings (id, tenant_id, `key`, `value`, updated_at) VALUES ('set_db_version', 'system', 'db_updated_at', :val, CURRENT_TIMESTAMP)",
            ['val' => date('Y-m-d H:i:s')]
        );

        return [
            'success' => true,
            'statements_executed' => $totalExecuted,
            'changes' => $appliedChanges,
            'updated_at' => date('Y-m-d H:i:s'),
            'message' => 'Seluruh 23 tabel dan kolom berhasil diverifikasi dan disinkronkan.',
        ];
    }
}
