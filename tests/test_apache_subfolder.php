<?php

declare(strict_types=1);

$baseUrl = 'http://localhost/nyautwa';
$cookieFile = __DIR__ . '/test_cookie.txt';
if (file_exists($cookieFile)) {
    unlink($cookieFile);
}

// 1. GET /login
$ch = curl_init($baseUrl . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($code !== 200) {
    echo "FAIL: GET /login returned HTTP $code\n";
    exit(1);
}
echo "PASS: GET /login returned HTTP 200\n";

preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $html, $matches);
$token = $matches[1] ?? null;
if (!$token) {
    echo "FAIL: CSRF token not found in login page\n";
    exit(1);
}
echo "PASS: CSRF token retrieved: " . substr($token, 0, 10) . "...\n";

// 2. POST /login
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_csrf_token' => $token,
    'email' => 'admin@nyautwa.test',
    'password' => 'password123'
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$postCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "POST /login returned HTTP $postCode\n";
if ($postCode === 302) {
    preg_match('/Location:\s*([^\r\n]+)/i', $response, $loc);
    $location = $loc[1] ?? '';
    echo "PASS: Redirected to $location\n";
} else {
    echo "FAIL: Expected 302 redirect, got $postCode\n";
    exit(1);
}

// 3. GET /dashboard
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/dashboard');
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$dashboardHtml = curl_exec($ch);
$dashCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($dashCode === 200 && str_contains($dashboardHtml, 'Dashboard Platform SaaS')) {
    echo "PASS: GET /dashboard returned HTTP 200 with admin dashboard content!\n";
} else {
    echo "FAIL: GET /dashboard returned HTTP $dashCode\n";
    exit(1);
}

// 4. GET /devices
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/devices');
$devicesHtml = curl_exec($ch);
$devCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($devCode === 200 && str_contains($devicesHtml, 'Koneksi WhatsApp')) {
    echo "PASS: GET /devices returned HTTP 200!\n";
} else {
    echo "FAIL: GET /devices returned HTTP $devCode\n";
    echo $devicesHtml . "\n";
    exit(1);
}

// 5. GET /messages
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/messages');
$messagesHtml = curl_exec($ch);
$msgCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($msgCode === 200 && str_contains($messagesHtml, 'Riwayat Pesan (Outbox)')) {
    echo "PASS: GET /messages returned HTTP 200!\n";
} else {
    echo "FAIL: GET /messages returned HTTP $msgCode\n";
    exit(1);
}

// 6. GET /api-keys
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api-keys');
$apiHtml = curl_exec($ch);
$apiCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($apiCode === 200 && str_contains($apiHtml, 'API Keys')) {
    echo "PASS: GET /api-keys returned HTTP 200!\n";
} else {
    echo "FAIL: GET /api-keys returned HTTP $apiCode\n";
    exit(1);
}

// 7. API POST /api/v1/messages
$apiCh = curl_init($baseUrl . '/api/v1/messages');
curl_setopt($apiCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($apiCh, CURLOPT_POST, true);
curl_setopt($apiCh, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer nyaut_live_948f2178ad99e120',
    'Content-Type: application/json'
]);
curl_setopt($apiCh, CURLOPT_POSTFIELDS, json_encode([
    'phone' => '081234567890',
    'message' => 'Tes pesan via Apache Laragon localhost/nyautwa'
]));
$apiMsgRes = curl_exec($apiCh);
$apiMsgCode = curl_getinfo($apiCh, CURLINFO_HTTP_CODE);
$apiMsgData = json_decode($apiMsgRes, true);

if ($apiMsgCode === 202 && ($apiMsgData['status'] ?? '') === 'queued') {
    echo "PASS: POST /api/v1/messages returned HTTP 202 Accepted (Message ID: " . ($apiMsgData['id'] ?? '') . ")!\n";
} else {
    echo "FAIL: POST /api/v1/messages returned HTTP $apiMsgCode: $apiMsgRes\n";
    exit(1);
}
curl_close($apiCh);

curl_close($ch);
if (file_exists($cookieFile)) {
    unlink($cookieFile);
}

echo "\nALL APACHE SUBFOLDER (http://localhost/nyautwa) TESTS PASSED SUCCESSFULLY!\n";
