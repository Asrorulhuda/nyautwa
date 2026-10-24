<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

echo "=== NyautWa Features & Billing Migration Verification ===\n\n";

$features = Database::fetchAll("SELECT * FROM features");
assert(count($features) >= 10, "Fitur awal aplikasi harus minimal 10 fitur");

$methods = Database::fetchAll("SELECT * FROM payment_methods");
echo "Jumlah metode pembayaran: " . count($methods) . "\n";
assert(count($methods) >= 3, "Metode pembayaran harus minimal 3");

$tenantsCols = array_column(Database::fetchAll("PRAGMA table_info(tenants)"), 'name');
assert(in_array('message_limit', $tenantsCols), "Kolom message_limit harus ada di tenants");
assert(in_array('device_limit', $tenantsCols), "Kolom device_limit harus ada di tenants");
assert(in_array('subscription_ends_at', $tenantsCols), "Kolom subscription_ends_at harus ada di tenants");

echo "[PASS] Seluruh skema fitur dan penagihan berhasil diverifikasi.\n";
