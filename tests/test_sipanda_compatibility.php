<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Core\Request;
use App\Controllers\Api\MessageApiController;

echo "=== Test Kompatibilitas Payload Gateway Sipanda2 ===\n";

$tenant = Database::fetchOne("SELECT id FROM tenants LIMIT 1");
$tenantId = $tenant['id'] ?? 'tenant_hq_master';

// Pastikan ada device aktif
$dev = Database::fetchOne("SELECT id FROM devices WHERE tenant_id = :tid AND status = 'connected' LIMIT 1", ['tid' => $tenantId]);
if (!$dev) {
    Database::query("INSERT INTO devices (id, tenant_id, label, status, session_ref, daily_limit) VALUES ('dev_sipanda_test', :tid, 'Sipanda Device', 'connected', 'sess_sipanda', 1000)", ['tid' => $tenantId]);
}

$rawKey = 'sipanda_test_secret_key';
$hash = hash('sha256', $rawKey);
Database::query("REPLACE INTO api_keys (id, tenant_id, name, key_hash, prefix, created_at) VALUES ('key_sip_test', :tid, 'Sipanda', :kh, 'nw_live', CURRENT_TIMESTAMP)", [
    'tid' => $tenantId,
    'kh' => $hash,
]);

\App\Core\Response::$preventExit = true;

// 1. Uji Pengiriman Teks Biasa (Sipanda default)
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['HTTP_ACCEPT'] = 'application/json';
unset($_SERVER['HTTP_AUTHORIZATION']);
$_POST = [
    'api_key' => $rawKey,
    'sender'  => '628123456789',
    'number'  => '08987654321',
    'message' => 'Tes notifikasi pembayaran SPP Sipanda'
];
$_GET = [];


ob_start();
$req = new Request();
$ctrl = new MessageApiController();
$ctrl->send($req);
$out1 = ob_get_clean();
$json1 = json_decode($out1, true);

assert($json1 !== null, "Output 1 harus berupa JSON");
assert(isset($json1['status']) && $json1['status'] === 'queued', "Status pesan harus queued");
assert(isset($json1['success']) && $json1['success'] === true, "Harus mengembalikan success: true");
echo "[PASS] 1. Pengiriman teks ala Sipanda (api_key, sender, number, message) berhasil!\n";

// 2. Uji Pengiriman Media/Gambar MBG (Sipanda media)
$_POST = [
    'api_key'    => $rawKey,
    'sender'     => '628123456789',
    'number'     => '08987654321',
    'media_type' => 'image',
    'caption'    => 'Foto Ompreng MBG Diterima',
    'url'        => 'https://example.com/uploads/ompreng.jpg'
];

ob_start();
$req2 = new Request();
$ctrl->send($req2);
$out2 = ob_get_clean();
$json2 = json_decode($out2, true);

assert($json2 !== null, "Output 2 harus berupa JSON");
assert(isset($json2['status']) && $json2['status'] === 'queued', "Status media harus queued");
echo "[PASS] 2. Pengiriman media ala Sipanda (caption, url, media_type) berhasil!\n";

// Bersihkan test key
Database::query("DELETE FROM api_keys WHERE id = 'key_sip_test'");

echo "\nSELURUH UJI KOMPATIBILITAS SIPANDA2 LOLOS 100%!\n";
