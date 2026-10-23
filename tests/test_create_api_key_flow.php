<?php

declare(strict_types=1);

echo "=== Menjalankan Test Alur Pembuatan API Key (UI & Controller) ===\n";

$cookieJar = tempnam(sys_get_temp_dir(), 'nyaut_apikey_');

function req(string $url, ?array $post = null, ?string $jar = null): array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    if ($jar) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $jar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $jar);
    }
    if ($post !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $location = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);
    return ['code' => $code, 'body' => (string) $body, 'location' => $location];
}

// 1. Login
$loginPage = req('http://127.0.0.1:8080/login', null, $cookieJar);
preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $loginPage['body'], $m);
$csrf = $m[1] ?? '';

$loginRes = req('http://127.0.0.1:8080/login', [
    '_csrf_token' => $csrf,
    'email' => 'admin@nyautwa.test',
    'password' => 'password123',
], $cookieJar);
assert($loginRes['code'] === 302, "Login must redirect");
echo "[PASS] 1. Login berhasil sebagai admin.\n";

// 2. GET /api-keys
$keysPage = req('http://127.0.0.1:8080/api-keys', null, $cookieJar);
assert($keysPage['code'] === 200, "GET /api-keys must return 200");
preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $keysPage['body'], $m2);
$csrfApi = $m2[1] ?? '';
assert(!empty($csrfApi), "Must extract CSRF token from /api-keys");
echo "[PASS] 2. Halaman /api-keys berhasil dimuat dan CSRF token tervalidasi.\n";

// 3. POST /api-keys/create
$createRes = req('http://127.0.0.1:8080/api-keys/create', [
    '_csrf_token' => $csrfApi,
    'name' => 'Production Gateway Key',
], $cookieJar);
assert($createRes['code'] === 302, "POST /api-keys/create must redirect with 302, got {$createRes['code']}");
echo "[PASS] 3. POST /api-keys/create memproses form dan me-redirect dengan status 302.\n";

// 4. Follow redirect back to /api-keys
$afterCreate = req('http://127.0.0.1:8080/api-keys', null, $cookieJar);
assert($afterCreate['code'] === 200, "GET /api-keys after creation must return 200");
$body = $afterCreate['body'];

assert(str_contains($body, 'Production Gateway Key'), "Page must list newly created API Key name");
assert(str_contains($body, 'modal-new-key'), "Page must display one-time disclosure modal (modal-new-key)");
assert(str_contains($body, 'nyaut_live_'), "Page must disclose the generated raw secret token nyaut_live_...");
echo "[PASS] 4. API Key berhasil tersimpan, ditampilkan di tabel, dan modal rahasia muncul dengan token nyaut_live_...\n";

// 5. Also test POST /api-keys route alias
preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $body, $m3);
$createAlias = req('http://127.0.0.1:8080/api-keys', [
    '_csrf_token' => $m3[1] ?? $csrfApi,
    'name' => 'Staging Mobile Key',
], $cookieJar);
assert($createAlias['code'] === 302, "POST /api-keys alias must also work seamlessly");
echo "[PASS] 5. Route alias POST /api-keys juga berfungsi 100% tanpa error 404.\n";

@unlink($cookieJar);

echo "\nSELURUH TEST PEMBUATAN API KEY BERHASIL 100%!\n";
