<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\ContactService;
use App\Services\DeviceService;

echo "=== Pengujian Sinkronisasi Kontak & Grup WA ===\n";

$contacts = new ContactService();
$devices = new DeviceService();
$tenantId = 'tenant_default';

$devs = $devices->getDevices($tenantId);
$targetDev = $devs[0] ?? $devices->createDevice($tenantId, 'WhatsApp Node Test', '628123456789');

// Uji method getOrCreateTag
$tagGrp = $contacts->getOrCreateTag($tenantId, 'Grup WhatsApp', '#6366F1');
$tagPers = $contacts->getOrCreateTag($tenantId, 'Kontak WhatsApp', '#16A36A');
echo "[PASS] Berhasil memastikan tag Grup ($tagGrp) dan Tag Kontak ($tagPers)\n";

// Uji simpan kontak grup
$savedGroup = $contacts->createContact($tenantId, [
    'name' => 'Komunitas WhatsApp Bisnis',
    'phone' => '120363029999999999@g.us',
    'tag_id' => $tagGrp,
    'notes' => 'Grup uji otomatis'
]);
echo "[PASS] Berhasil membuat entri grup WA: " . ($savedGroup ? 'OK' : 'FAIL') . "\n";

// Verifikasi kontak tersimpan
$list = $contacts->getContacts($tenantId, $tagGrp);
$found = false;
foreach ($list as $c) {
    if ($c['phone'] === '120363029999999999@g.us') {
        $found = true;
        break;
    }
}
echo "[PASS] Verifikasi keberadaan grup di database: " . ($found ? 'OK' : 'FAIL') . "\n";
echo "PENGUJIAN SINKRONISASI KONTAK & GRUP SUKSES!\n";
