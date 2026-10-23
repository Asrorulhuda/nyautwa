<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

$baseUrl = 'http://localhost/nyautwa';
$cookieFile = tempnam(sys_get_temp_dir(), 'nyaut_cookie_test_');

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

echo "=== Testing Landing Page & New Admin Features ===\n";

// 1. Landing Page (Public)
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/');
curl_setopt($ch, CURLOPT_HTTPGET, true);
$landingHtml = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
assert($code === 200, "Landing page returned $code");
assert(str_contains($landingHtml, 'WhatsApp Gateway API'), "Landing page contains hero badge");
assert(str_contains($landingHtml, 'Server Node Jakarta 01'), "Landing page contains node preview");
echo "PASS: Landing Page loaded successfully (HTTP 200)\n";

// 2. Fetch CSRF Token & Login
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
$loginHtml = curl_exec($ch);
preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $loginHtml, $csrfMatches);
$csrfToken = $csrfMatches[1] ?? '';
assert(!empty($csrfToken), "CSRF token extracted");

curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_csrf_token' => $csrfToken,
    'email' => 'admin@nyautwa.test',
    'password' => 'password123',
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_HEADER, true);
$postLoginRes = curl_exec($ch);
$loginCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
assert($loginCode === 302, "Login returned 302 redirect");
echo "PASS: Authenticated as admin (HTTP 302)\n";

// 3. Test Dashboard Bento Grid layout
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/dashboard');
$dashHtml = curl_exec($ch);
$dashCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
assert($dashCode === 200, "Dashboard returned 200");
assert(str_contains($dashHtml, 'Tren Pengiriman Pesan'), "Dashboard contains chart bento block");
assert(str_contains($dashHtml, 'Status Sesi WhatsApp'), "Dashboard contains devices bento block");
assert(str_contains($dashHtml, 'Kesehatan Webhook'), "Dashboard contains webhook bento block");
assert(str_contains($dashHtml, 'sidebar-backdrop'), "Dashboard has responsive mobile drawer backdrop");
echo "PASS: Dashboard Bento Grid rendered cleanly\n";

// 4. Test Clients Management Page
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/clients');
$clientsHtml = curl_exec($ch);
$clientsCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
assert($clientsCode === 200, "Clients page returned 200");
assert(str_contains($clientsHtml, 'Kelola Klien & Tenant'), "Clients page contains title");
assert(str_contains($clientsHtml, 'Tambah Klien Baru'), "Clients page has add button");
echo "PASS: Clients Management Page loaded (HTTP 200)\n";

// 5. Test Landing Config Page
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/settings/landing');
$configHtml = curl_exec($ch);
$configCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
assert($configCode === 200, "Landing config returned 200");
assert(str_contains($configHtml, 'Konfigurasi Landing Page'), "Landing config has title");
assert(str_contains($configHtml, 'hero_title'), "Landing config has hero_title input");
echo "PASS: Landing Page Config CMS loaded (HTTP 200)\n";

// 6. Test updating landing config via POST
preg_match('/name="_csrf_token"\s+value="([^"]+)"/', $configHtml, $csrfConfigMatches);
$csrfConfig = $csrfConfigMatches[1] ?? '';

curl_setopt($ch, CURLOPT_URL, $baseUrl . '/settings/landing');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    '_csrf_token' => $csrfConfig,
    'current_tab' => 'hero',
    'hero_badge' => 'TEST_HERO_BADGE_UPDATE',
    'hero_title' => 'Gateway Tercepat se-Indonesia',
]));
$updateRes = curl_exec($ch);
$updateCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
assert($updateCode === 302, "Landing settings updated and redirected");

// 7. Verify update reflection on public landing page
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/');
$publicUpdated = curl_exec($ch);
assert(str_contains($publicUpdated, 'TEST_HERO_BADGE_UPDATE'), "Updated hero badge visible on public landing page!");
assert(str_contains($publicUpdated, 'Gateway Tercepat se-Indonesia'), "Updated hero title visible on public landing page!");
echo "PASS: Dynamic Landing CMS updates reflect 100% on public landing page!\n";

// Restore clean defaults
$service = new \App\Services\LandingSettingsService();
$service->set('hero_badge', 'WhatsApp Gateway API');
$service->set('hero_title', 'Integrasikan WhatsApp ke sistem Anda.');
echo "PASS: Defaults restored cleanly.\n";

curl_close($ch);
@unlink($cookieFile);
@unlink(__DIR__ . '/debug_clients.php');
echo "\nALL NEW ADMIN & BENTO GRID FEATURES PASSED 100%!\n";
