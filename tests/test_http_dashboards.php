<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

// Ensure known test credentials
Database::query("UPDATE users SET password_hash = :p, role = 'client' WHERE email = 'asss@as.com'", [
    'p' => password_hash('password123', PASSWORD_BCRYPT)
]);

echo "=== Menjalankan Test HTTP Session Dashboard Admin vs Client ===\n";

$cookieJarAdmin = tempnam(sys_get_temp_dir(), 'nyaut_admin_');
$cookieJarClient = tempnam(sys_get_temp_dir(), 'nyaut_client_');

function httpReq(string $url, ?array $post = null, ?string $cookieJar = null): array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if ($cookieJar) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    }
    if ($post !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $code, 'body' => (string) $body];
}

function doLogin(string $email, string $password, string $cookieJar): array {
    $get = httpReq('http://127.0.0.1:8080/login', null, $cookieJar);
    preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $get['body'], $m);
    $csrf = $m[1] ?? '';
    return httpReq('http://127.0.0.1:8080/login', [
        '_csrf_token' => $csrf,
        'email' => $email,
        'password' => $password,
    ], $cookieJar);
}

// 1. Login as Admin
$loginAdmin = doLogin('admin@nyautwa.test', 'password123', $cookieJarAdmin);
assert($loginAdmin['code'] === 200, "Admin login must succeed");

$dashAdmin = httpReq('http://127.0.0.1:8080/dashboard', null, $cookieJarAdmin);
assert($dashAdmin['code'] === 200, "Admin dashboard must return 200");
assert(str_contains($dashAdmin['body'], 'Dashboard Platform SaaS'), "Admin dashboard must have 'Dashboard Platform SaaS'");
assert(str_contains($dashAdmin['body'], 'Total Klien SaaS'), "Admin dashboard must have 'Total Klien SaaS'");
assert(str_contains($dashAdmin['body'], 'Estimasi MRR SaaS'), "Admin dashboard must have 'Estimasi MRR SaaS'");
assert(str_contains($dashAdmin['body'], 'Kelola Klien'), "Admin sidebar must have 'Kelola Klien'");
echo "[PASS] Admin Dashboard HTTP rendered with SaaS Platform controls & metrics.\n";

// 2. Login as Client (asss@as.com)
$loginClient = doLogin('asss@as.com', 'password123', $cookieJarClient);
assert($loginClient['code'] === 200, "Client login must succeed");

$dashClient = httpReq('http://127.0.0.1:8080/dashboard', null, $cookieJarClient);
assert($dashClient['code'] === 200, "Client dashboard must return 200");
assert(str_contains($dashClient['body'], 'Workspace WhatsApp'), "Client dashboard must have 'Workspace WhatsApp'");
assert(str_contains($dashClient['body'], 'Kuota Pesan Hari Ini'), "Client dashboard must have 'Kuota Pesan Hari Ini'");
assert(str_contains($dashClient['body'], 'Integrasi Cepat REST API'), "Client dashboard must have 'Integrasi Cepat REST API'");

// Critical check: Client MUST NOT see Admin SaaS controls in sidebar or dashboard!
assert(!str_contains($dashClient['body'], 'Dashboard Platform SaaS'), "Client dashboard must NOT have 'Dashboard Platform SaaS'");
assert(!str_contains($dashClient['body'], 'Admin SaaS'), "Client sidebar must NOT have 'Admin SaaS'");
assert(!str_contains($dashClient['body'], 'Kelola Klien'), "Client sidebar must NOT have 'Kelola Klien'");
assert(!str_contains($dashClient['body'], 'Config Landing'), "Client sidebar must NOT have 'Config Landing'");
echo "[PASS] Client Dashboard HTTP rendered with tenant workspace metrics, and strictly WITHOUT Admin SaaS menu.\n";

@unlink($cookieJarAdmin);
@unlink($cookieJarClient);

echo "\nSEMUA TEST HTTP DASHBOARD ADMIN VS CLIENT BERHASIL 100%!\n";
