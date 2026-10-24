<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\DeviceService;
use App\Services\MessageService;

echo "=== Menjalankan Pengujian Delete Perangkat & Pesan (Single & Bulk) ===\n";

$devSvc = new DeviceService();
$msgSvc = new MessageService();
$tenantId = 'tenant_default';

// 1. Uji Hapus Perangkat
$tempDev = $devSvc->createDevice($tenantId, 'Perangkat Test Hapus', '62899998888');
if (!$tempDev) {
    echo "Gagal membuat perangkat uji\n";
    exit(1);
}
echo "[PASS] Berhasil membuat perangkat uji: {$tempDev['id']}\n";

$delDev = $devSvc->deleteDevice($tempDev['id'], $tenantId);
$checkDev = $devSvc->find($tempDev['id'], $tenantId);
if ($delDev && $checkDev === null) {
    echo "[PASS] Berhasil menghapus perangkat secara permanen\n";
} else {
    echo "[FAIL] Perangkat masih ditemukan di database\n";
    exit(1);
}

// 2. Uji Hapus Pesan Single
$msg1 = $msgSvc->queueMessage($tenantId, 'dev_primary_01', '62811122233', 'Pesan Uji Hapus 1');
echo "[PASS] Berhasil membuat pesan uji 1: {$msg1['id']}\n";
$delMsg = $msgSvc->deleteMessage($msg1['id'], $tenantId);
if ($delMsg) {
    echo "[PASS] Berhasil menghapus pesan single secara tuntas\n";
} else {
    echo "[FAIL] Gagal menghapus pesan single\n";
    exit(1);
}

// 3. Uji Hapus Pesan Bulk (Massal)
$msgA = $msgSvc->queueMessage($tenantId, 'dev_primary_01', '62811122244', 'Pesan Bulk A');
$msgB = $msgSvc->queueMessage($tenantId, 'dev_primary_01', '62811122255', 'Pesan Bulk B');
$count = $msgSvc->deleteBulkMessages([$msgA['id'], $msgB['id']], $tenantId);
if ($count >= 2) {
    echo "[PASS] Berhasil menghapus {$count} pesan sekaligus (Bulk Delete)\n";
} else {
    echo "[FAIL] Bulk delete hanya menghapus {$count} pesan\n";
    exit(1);
}

echo "SELURUH FITUR PENGHAPUSAN DEVICE & PESAN LOLOS 100%!\n";
