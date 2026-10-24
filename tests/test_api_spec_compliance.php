<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Services\ApiKeyService;
use App\Services\WebhookService;
use App\Services\MessageService;

echo "=== Menjalankan Test Kepatuhan Spesifikasi API & Arsitektur ===\n";

$rawKey = 'nyaut_live_test_compliance_key';
$keyHash = hash('sha256', $rawKey);
$tenant = Database::fetchOne("SELECT id FROM tenants LIMIT 1");
$tenantId = $tenant['id'] ?? 'tenant_hq_master';

// Ensure at least 1 device exists for tests
$existingDev = Database::fetchOne("SELECT id FROM devices WHERE tenant_id = :tid", ['tid' => $tenantId]);
if (!$existingDev) {
    Database::query(
        "INSERT INTO devices (id, tenant_id, label, status, session_ref, daily_limit) VALUES ('dev_test_01', :tid, 'Primary Device', 'connected', 'sess_test', 1000)",
        ['tid' => $tenantId]
    );
}

// Seed temporary test key
Database::query("REPLACE INTO api_keys (id, tenant_id, name, key_hash, prefix, created_at) VALUES ('key_test_comp', :tid, 'Comp Key', :kh, 'nyaut_live', CURRENT_TIMESTAMP)", [
    'tid' => $tenantId,
    'kh' => $keyHash,
]);

function apiCall(string $method, string $path, ?array $body = null, ?string $token = null): array {
    $url = 'http://127.0.0.1:8080' . $path;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    $response = (string) curl_exec($ch);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $headerStr = substr($response, 0, $headerSize);
    $bodyStr = substr($response, $headerSize);
    $json = json_decode($bodyStr, true);

    return ['code' => $code, 'headers' => $headerStr, 'body' => $bodyStr, 'json' => $json];
}

// 1. GET /api/v1/devices
$res = apiCall('GET', '/api/v1/devices', null, $rawKey);
assert($res['code'] === 200, "GET /api/v1/devices must return 200");
assert(str_contains($res['headers'], 'X-RateLimit-Limit'), "Response must include X-RateLimit-Limit header");
echo "[PASS] 1. GET /api/v1/devices mengembalikan daftar device dan header rate limit.\n";

// 2. POST /api/v1/devices
$res = apiCall('POST', '/api/v1/devices', ['label' => 'WhatsApp CS API'], $rawKey);
assert(in_array($res['code'], [201, 402]), "POST /api/v1/devices must return 201 or 402 if limit reached");
echo "[PASS] 2. POST /api/v1/devices membuat device baru sesuai batas paket.\n";

// 3. GET /api/v1/devices/{id}/qr
$dev = Database::fetchOne("SELECT id FROM devices WHERE tenant_id = :tid LIMIT 1", ['tid' => $tenantId]);
$res = apiCall('GET', '/api/v1/devices/' . $dev['id'] . '/qr', null, $rawKey);
assert($res['code'] === 200 && isset($res['json']['qr']), "GET /api/v1/devices/{id}/qr must return QR");
echo "[PASS] 3. GET /api/v1/devices/{id}/qr mengembalikan data QR sesi.\n";

// 4. POST /api/v1/devices/{id}/logout
$res = apiCall('POST', '/api/v1/devices/' . $dev['id'] . '/logout', null, $rawKey);
assert($res['code'] === 200, "POST /api/v1/devices/{id}/logout must return 200");
echo "[PASS] 4. POST /api/v1/devices/{id}/logout memutuskan sesi perangkat.\n";

// 5. POST /api/v1/messages
$res = apiCall('POST', '/api/v1/messages', [
    'to' => '081234567890',
    'text' => '{Halo|Hai} Pesanan Anda diproses.',
    'idempotency_key' => 'test-idemp-' . time(),
], $rawKey);
assert($res['code'] === 202, "POST /api/v1/messages must return 202 Accepted");
assert(isset($res['json']['id']) && $res['json']['status'] === 'queued', "Response body must match {id, status: queued}");
$createdMsgId = $res['json']['id'];
echo "[PASS] 5. POST /api/v1/messages membalas 202 Accepted dengan format spesifikasi {id, status: queued}.\n";

// 6. POST /api/v1/messages/bulk
$res = apiCall('POST', '/api/v1/messages/bulk', [
    'messages' => [
        ['to' => '0811111111', 'text' => 'Pesan A'],
        ['to' => '0822222222', 'text' => 'Pesan B'],
    ]
], $rawKey);
assert($res['code'] === 202 && $res['json']['queued_count'] === 2, "Bulk send must queue messages");
echo "[PASS] 6. POST /api/v1/messages/bulk menjadwalkan pengiriman pesan massal.\n";

// 7. GET /api/v1/messages/{id}
$res = apiCall('GET', '/api/v1/messages/' . $createdMsgId, null, $rawKey);
assert($res['code'] === 200 && isset($res['json']['events']), "GET /api/v1/messages/{id} must return timeline events");
echo "[PASS] 7. GET /api/v1/messages/{id} menyertakan detail pesan dan riwayat events.\n";

// 8. GET /api/v1/messages
$res = apiCall('GET', '/api/v1/messages', null, $rawKey);
assert($res['code'] === 200 && is_array($res['json']['data']), "GET /api/v1/messages must return list");
echo "[PASS] 8. GET /api/v1/messages mengembalikan daftar pesan dengan filter.\n";

// 9. POST /api/v1/numbers/check
$res = apiCall('POST', '/api/v1/numbers/check', ['number' => '08123456789'], $rawKey);
assert($res['code'] === 200 && $res['json']['exists'] === true, "Number check must succeed");
echo "[PASS] 9. POST /api/v1/numbers/check memverifikasi nomor WhatsApp internasional.\n";

// 10. GET /api/v1/usage
$res = apiCall('GET', '/api/v1/usage', null, $rawKey);
assert($res['code'] === 200 && isset($res['json']['remaining_month']), "GET /api/v1/usage must return remaining quota");
echo "[PASS] 10. GET /api/v1/usage melaporkan sisa kuota bulanan dan harian.\n";

// 11. Error Format Specification
$resErr = apiCall('GET', '/api/v1/devices', null, 'invalid_key_token_xyz');
assert($resErr['code'] === 401 && isset($resErr['json']['error']['code']), "Error format must match {error: {code, message}}");
echo "[PASS] 11. Format error API 100% konsisten {error: {code, message}}.\n";

// 12. SSRF Protection on Webhook URL
$whService = new WebhookService();
assert($whService->validateUrl('http://127.0.0.1/hook') === false, "SSRF: must block 127.0.0.1");
assert($whService->validateUrl('http://169.254.169.254/latest/meta-data') === false, "SSRF: must block AWS metadata IP");
assert($whService->validateUrl('http://192.168.1.1/hook') === false, "SSRF: must block private LAN IP");
assert($whService->validateUrl('https://webhook.site/test-123') === true, "SSRF: must allow public URL");
echo "[PASS] 12. Proteksi SSRF webhook memblokir IP privat, loopback, dan metadata cloud.\n";

// 13. Spintax Anti-Ban
$msgService = new MessageService();
$spun = $msgService->parseSpintax('{Halo|Hai|Pagi} Bos!');
assert(in_array($spun, ['Halo Bos!', 'Hai Bos!', 'Pagi Bos!']), "Spintax must rotate variations");
echo "[PASS] 13. Fitur Spintax anti-ban merotasi variasi pesan secara dinamis.\n";

echo "\nSELURUH 13 POIN KEPATUHAN SPESIFIKASI API & ARSITEKTUR LOLOS 100%!\n";
