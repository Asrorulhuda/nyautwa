<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\BillingService;
use App\Core\Database;

echo "=== NyautWa BillingService & Automated Invoice Test ===\n\n";

$billing = new BillingService();

// 1. Get payment methods
$methods = $billing->getPaymentMethods();
assert(count($methods) >= 3, "Harus ada minimal 3 metode pembayaran default");
echo " [PASS] getPaymentMethods returns " . count($methods) . " payment methods\n";

// 2. Create automated invoice
$testTenantId = 'tenant_bill_' . bin2hex(random_bytes(4));
try {
    $invoice = $billing->createInvoice($testTenantId, 150000, 'pro', 'bca_transfer', 'paid', 'Uji coba penagihan otomatis');
} catch (\Throwable $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    exit(1);
}
if (empty($invoice['id'])) {
    echo "ERROR: invoice is empty: " . json_encode($invoice) . "\n";
    exit(1);
}
assert(str_starts_with($invoice['invoice_no'], 'INV/'), "Format nomor invoice harus INV/YYYYMMDD/...");
assert((int)$invoice['amount'] === 150000, "Nominal invoice cocok");
echo " [PASS] createInvoice generated invoice: " . $invoice['invoice_no'] . "\n";

// 3. Fetch invoice
$fetched = $billing->getInvoice($invoice['id']);
assert($fetched !== null, "Invoice harus dapat diambil kembali");
assert($fetched['payment_method_id'] === 'bca_transfer', "Metode pembayaran cocok");
echo " [PASS] getInvoice retrieved invoice successfully\n";

// Clean up
Database::query("DELETE FROM invoices WHERE id = :id", ['id' => $invoice['id']]);

echo "\nSELURUH PENGUJIAN BILLINGSERVICE LOLOS 100%.\n";
