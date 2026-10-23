<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

echo "=== Membersihkan Data Dummy & Membuat 1 Akun Admin Baru ===\n";

$tablesToTruncate = [
    'webhook_deliveries',
    'message_events',
    'messages',
    'api_keys',
    'devices',
    'subscriptions',
    'invoices',
    'usage_counters',
    'users',
    'tenants',
];

foreach ($tablesToTruncate as $tbl) {
    try {
        Database::query("DELETE FROM $tbl");
        echo "Table '$tbl' dibersihkan.\n";
    } catch (\Throwable $e) {
        echo "Lewati '$tbl': " . $e->getMessage() . "\n";
    }
}

// Buat 1 Tenant Platform Admin
$tenantId = 'tenant_hq_master';
Database::query(
    "INSERT INTO tenants (id, name, plan_id, status, created_at, updated_at) VALUES (:id, :name, 'reseller', 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
    ['id' => $tenantId, 'name' => 'NyautWa Platform HQ']
);

// Buat 1 Akun Admin Baru
$adminEmail = 'admin@nyautwa.test';
$adminPass = 'password123';
$adminName = 'Super Administrator';
$userId = 'usr_admin_' . bin2hex(random_bytes(6));

Database::query(
    "INSERT INTO users (id, tenant_id, name, email, password_hash, role, created_at, updated_at) VALUES (:id, :tid, :name, :email, :pass, 'admin', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
    [
        'id' => $userId,
        'tid' => $tenantId,
        'name' => $adminName,
        'email' => $adminEmail,
        'pass' => password_hash($adminPass, PASSWORD_BCRYPT),
    ]
);

echo "\nSukses: Seluruh data dummy telah dihapus!\n";
echo "1 Akun Admin Baru Berhasil Dibuat:\n";
echo "- Nama     : $adminName\n";
echo "- Email    : $adminEmail\n";
echo "- Password : $adminPass\n";
echo "- Role     : admin\n";
echo "- Tenant   : NyautWa Platform HQ\n";
