<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Services\AuthService;
use App\Services\AdminDashboardService;
use App\Services\ClientDashboardService;
use App\Services\ClientService;

echo "=== Menjalankan Test Dashboard Terpisah (Admin vs Client) ===\n";

// 1. Test Admin Dashboard Service
$adminService = new AdminDashboardService();
$adminMetrics = $adminService->getMetrics();
assert(isset($adminMetrics['total_clients']), "Admin metrics must have total_clients");
assert(isset($adminMetrics['estimated_mrr']), "Admin metrics must have estimated_mrr");
assert(isset($adminMetrics['engine_status']), "Admin metrics must have engine_status");
echo "[PASS] AdminDashboardService menghasilkan metrik platform global (Total Klien: {$adminMetrics['total_clients']}, MRR: Rp " . number_format($adminMetrics['estimated_mrr'], 0, ',', '.') . ")\n";

// 2. Test Client Dashboard Service
$clientUser = Database::fetchOne("SELECT * FROM users WHERE role = 'client' LIMIT 1");
assert(!empty($clientUser), "Must have at least one client user");
$clientService = new ClientDashboardService();
$clientMetrics = $clientService->getMetrics($clientUser['tenant_id']);
assert(isset($clientMetrics['daily_limit']), "Client metrics must have daily_limit");
assert(isset($clientMetrics['remaining_quota']), "Client metrics must have remaining_quota");
assert(isset($clientMetrics['quota_percentage']), "Client metrics must have quota_percentage");
echo "[PASS] ClientDashboardService menghasilkan metrik workspace spesifik tenant (Batas: {$clientMetrics['daily_limit']}, Sisa: {$clientMetrics['remaining_quota']})\n";

// 3. Test Role distinction in AuthService
$auth = new AuthService();
// Test login as admin
$_SESSION = [];
$auth->attempt('admin@nyautwa.test', 'password123');
assert($auth->isAdmin() === true, "admin@nyautwa.test must be admin");
assert($auth->role() === 'admin', "admin role must be 'admin'");
echo "[PASS] AuthService::isAdmin() benar untuk akun admin\n";

// Test login as client
$_SESSION = [];
$auth->attempt($clientUser['email'], 'password123');
assert($auth->isAdmin() === false, "Client user must NOT be admin");
assert($auth->role() === 'client', "Client user role must be 'client'");
echo "[PASS] AuthService::isAdmin() bernilai false untuk akun klien\n";

// 4. Test ClientService create sets role to client
$clientManager = new ClientService();
$newTenantId = $clientManager->create([
    'name' => 'Test Toko Elektronik',
    'plan_id' => 'starter',
    'owner_name' => 'Budi Santoso',
    'email' => 'budi_' . time() . '@test.com',
    'password' => 'password123',
]);
$newUser = Database::fetchOne("SELECT role FROM users WHERE tenant_id = :tid", ['tid' => $newTenantId]);
assert($newUser['role'] === 'client', "Newly created client owner must have role 'client'");
echo "[PASS] Pembuatan client baru melalui ClientService otomatis ber-role 'client'\n";

// Clean up test tenant
Database::query("DELETE FROM users WHERE tenant_id = :tid", ['tid' => $newTenantId]);
Database::query("DELETE FROM tenants WHERE id = :tid", ['tid' => $newTenantId]);

echo "\nSEMUA TEST DASHBOARD ADMIN & CLIENT BERHASIL 100%!\n";
