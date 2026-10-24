<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\ClientService;
use App\Services\FeatureService;
use App\Services\BillingService;
use App\Core\Database;

echo "=== NyautWa Client Management & Deletion Test ===\n\n";

$clients = new ClientService();
$featureService = new FeatureService();
$billingService = new BillingService();

// 1. Create client with screenshot fields
$data = [
    'username' => 'client_test_' . bin2hex(random_bytes(3)),
    'email' => 'client_' . bin2hex(random_bytes(3)) . '@testbiz.id',
    'password' => 'Password123#Kuat',
    'message_limit' => 25000,
    'device_limit' => 10,
    'status' => 'active',
    'subscription_ends_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
    'role' => 'user',
    'plan_id' => 'pro',
    'features' => ['wa_connection', 'send_text', 'webhooks', 'api_keys'],
    'payment_method_id' => 'bca_transfer',
];

$tenantId = $clients->create($data);
assert(!empty($tenantId), "Tenant ID harus terisi setelah pembuatan");
echo " [PASS] create client with full parameters: $tenantId\n";

// Verify tenant fields
$t = $clients->getById($tenantId);
assert((int)$t['message_limit'] === 25000, "Message limit harus 25000");
assert((int)$t['device_limit'] === 10, "Device limit harus 10");
echo " [PASS] tenant limits properly saved\n";

// Verify features synced
$tenantFeatures = $featureService->getTenantFeatures($tenantId);
assert(count($tenantFeatures) === 4, "Fitur tenant harus 4 buah");
assert(in_array('wa_connection', $tenantFeatures), "Koneksi WhatsApp harus aktif");
echo " [PASS] tenant features successfully synced\n";

// Verify automatic invoice
$invoices = $billingService->getInvoicesForTenant($tenantId);
assert(count($invoices) >= 1, "Nota pembayaran otomatis harus ada");
assert(str_starts_with($invoices[0]['invoice_no'], 'INV/'), "Format nomor nota harus INV/...");
echo " [PASS] automated invoice generated: " . $invoices[0]['invoice_no'] . "\n";

// 2. Test Delete Client (Cascades tenant, features, users, invoices)
$deleted = $clients->delete($tenantId);
assert($deleted === true, "Delete client harus mengembalikan true");

$tAfter = $clients->getById($tenantId);
assert($tAfter === null, "Tenant harus sudah tidak ditemukan di database");

$featuresAfter = $featureService->getTenantFeatures($tenantId);
assert(empty($featuresAfter), "Fitur tenant harus terhapus bersih");

$invoicesAfter = $billingService->getInvoicesForTenant($tenantId);
assert(empty($invoicesAfter), "Invoice tenant harus terhapus bersih");

echo " [PASS] delete client cascades and cleans up all related records\n";

echo "\nSELURUH PENGUJIAN CLIENT MANAGEMENT & DELETE LOLOS 100%.\n";
