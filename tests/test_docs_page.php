<?php

declare(strict_types=1);

echo "=== Menjalankan Test Halaman Dokumentasi API (/docs) ===\n";

$cookieJar = tempnam(sys_get_temp_dir(), 'nyaut_docs_');

function httpGet(string $url, ?string $jar = null): array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    if ($jar) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $jar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $jar);
    }
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $code, 'body' => (string) $body];
}

// 1. Unauthenticated /docs should redirect to /login
$unauth = httpGet('http://127.0.0.1:8080/docs');
assert(in_array($unauth['code'], [302, 301]), "Unauthenticated /docs must redirect");
echo "[PASS] 1. Akses tanpa login ke /docs diarahkan ke /login.\n";

// 2. Login as admin
$loginGet = httpGet('http://127.0.0.1:8080/login', $cookieJar);
preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $loginGet['body'], $m);
$csrf = $m[1] ?? '';

$ch = curl_init('http://127.0.0.1:8080/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_csrf_token' => $csrf,
    'email' => 'admin@nyautwa.test',
    'password' => 'password123',
]));
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_exec($ch);
curl_close($ch);

// 3. Authenticated /docs
$authDocs = httpGet('http://127.0.0.1:8080/docs', $cookieJar);
assert($authDocs['code'] === 200, "Authenticated /docs must return HTTP 200");
$html = $authDocs['body'];

assert(str_contains($html, 'Dokumentasi REST API Publik (v1)'), "Must have main title");
assert(str_contains($html, '1. Autentikasi & Header Permintaan'), "Must have Section 1");
assert(str_contains($html, '2. Ringkasan Endpoint REST API (v1)'), "Must have Section 2");
assert(str_contains($html, '3. Mengirim Pesan WhatsApp'), "Must have Section 3");
assert(str_contains($html, '4. Manajemen Perangkat & Utilitas'), "Must have Section 4");
assert(str_contains($html, '5. Spesifikasi Webhook Masuk & Tanda Terima'), "Must have Section 5");
assert(str_contains($html, '6. Format Error & Kode Status HTTP'), "Must have Section 6");
assert(str_contains($html, 'X-Signature: sha256='), "Must have HMAC-SHA256 signature spec");
assert(str_contains($html, 'quota_exceeded'), "Must have quota error code spec");
assert(str_contains($html, 'Dokumentasi API'), "Sidebar must have Dokumentasi API link");

echo "[PASS] 2. Halaman /docs dimuat dengan status HTTP 200 dan memuat seluruh seksi spesifikasi API.\n";
echo "[PASS] 3. Menu sidebar Developer menampilkan pintasan aktif 'Dokumentasi API'.\n";

@unlink($cookieJar);

echo "\nSELURUH TEST HALAMAN DOKUMENTASI API LOLOS 100%!\n";
