<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\DatabaseUpdateService;

echo "=== Menjalankan Pembaruan Skema Database NyautWa (update_db.php) ===\n";

try {
    $res = DatabaseUpdateService::runUpdate();
    echo "[OK] Status: " . ($res['success'] ? 'SUKSES' : 'GAGAL') . "\n";
    echo "[OK] Pernyataan SQL Dieksekusi: " . $res['statements_executed'] . "\n";
    echo "[OK] Waktu Selesai: " . $res['updated_at'] . "\n";
    echo "[OK] Pesan: " . $res['message'] . "\n";
    echo "=== Pembaruan Database Selesai Secara Paripurna ===\n";
    exit(0);
} catch (\Throwable $e) {
    echo "[ERROR] Terjadi kendala saat update database: " . $e->getMessage() . "\n";
    exit(1);
}
