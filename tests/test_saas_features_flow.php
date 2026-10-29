<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Services\{LandingSettingsService, PlanService, SubscriptionService, BillingService, PaymentMethodService, ClientService};

echo "=== Memulai Test Verifikasi Alur Modular SaaS NyautWa ===\n";

// 1. Settings & Template Reminder
$settings = (new LandingSettingsService())->getAll();
assert(!empty($settings['reminder_wa_template']), 'reminder_wa_template harus tersedia');
echo "[PASS] 1. LandingSettingsService & Reminder Template OK\n";

// 2. Plans & Modular Features
$planService = new PlanService();
$plans = $planService->getAvailablePlans();
assert(isset($plans['trial'], $plans['starter'], $plans['business'], $plans['reseller']), '4 paket harus tersedia');
foreach ($plans as $k => $p) {
    assert(isset($p['duration_days']), "duration_days pada paket {$k} harus ada");
    assert(isset($p['modules']), "modules pada paket {$k} harus ada");
    assert(is_array($p['modules']), "modules pada paket {$k} harus array");
}
echo "[PASS] 2. PlanService Modular Features & Durasi Hari OK\n";

// 3. Subscription Service & Hak Akses Modul
$subService = new SubscriptionService();
$adminAccess = $subService->canAccess('tenant_demo_01', 'crm');
assert($adminAccess === true, 'Admin tenant harus memiliki akses ke crm');
$subInfo = $subService->getTenantSubscription('tenant_demo_01');
assert(isset($subInfo['status'], $subInfo['plan_name']) && array_key_exists('days_left', $subInfo), 'Subscription info harus lengkap');
echo "[PASS] 3. SubscriptionService & Access Guard OK (Status: {$subInfo['status']}, Sisa Hari: " . ($subInfo['days_left'] ?? 'unlimited') . ")\n";

// 4. Payment Methods & Billing Invoices
$pmService = new PaymentMethodService();
$methods = $pmService->getAll();
assert(is_array($methods), 'Payment methods harus array');
$billService = new BillingService();
$invoices = $billService->getAllInvoices();
assert(is_array($invoices), 'Invoices harus array');
echo "[PASS] 4. PaymentMethodService & BillingService OK (Total Invoices: " . count($invoices) . ", Total Payment Methods: " . count($methods) . ")\n";

// 5. ClientService
$clientService = new ClientService();
$clients = $clientService->getAll();
assert(is_array($clients), 'Clients list harus array');
echo "[PASS] 5. ClientService OK (Total Klien: " . count($clients) . ")\n";

echo "=== SEMUA PENGUJIAN MODULAR SAAS BERHASIL 100% ===\n";
