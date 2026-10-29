<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\NotificationService;

$service = new NotificationService();

$fakeInvoice = [
    'tenant_id' => 'tenant_demo_01',
    'invoice_no' => 'INV/TEST/001',
    'plan_id' => 'business',
    'amount' => 349000,
    'tenant' => ['name' => 'PT Tes Berkah'],
    'owner' => ['name' => 'Fikri', 'phone' => '08123456789'],
    'payment_method' => ['name' => 'BCA Transfer'],
];

try {
    $res = $service->notifyAdminPaymentProof($fakeInvoice, '/uploads/proofs/test.png');
    echo "NOTIFY ADMIN RESULT: " . ($res ? 'TRUE' : 'FALSE') . "\n";
    echo "SUCCESS: Method berjalan lancar tanpa error!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}
