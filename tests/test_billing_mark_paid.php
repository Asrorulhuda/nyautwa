<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Services\{BillingService, PlanService};

echo "=== Test markAsPaid & getPlan ===\n";

$plan = (new PlanService())->getPlan('starter');
assert($plan !== null, 'Plan starter harus ditemukan');
assert($plan['name'] !== '', 'Nama plan tidak boleh kosong');
echo "[PASS] getPlan('starter') sukses: {$plan['name']}\n";

$billing = new BillingService();
$invoices = $billing->getAllInvoices();
if (!empty($invoices)) {
    $firstInv = $invoices[0];
    echo "Mencoba markAsPaid untuk invoice {$firstInv['id']}...\n";
    $ok = $billing->markAsPaid($firstInv['id']);
    assert($ok === true, 'markAsPaid harus berhasil');
    echo "[PASS] markAsPaid berhasil tanpa error 500!\n";
}

echo "=== SEMUA TEST BERHASIL ===\n";
