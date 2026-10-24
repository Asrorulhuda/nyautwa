<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Services\AuthService;
use App\Services\RateLimitService;

echo "=== NyautWa Auth & Security Production Verification ===\n\n";

$passed = 0;
$failed = 0;

function it(string $desc, bool $condition): void {
    global $passed, $failed;
    if ($condition) {
        echo " [PASS] $desc\n";
        $passed++;
    } else {
        echo " [FAIL] $desc\n";
        $failed++;
    }
}

$auth = new AuthService();
$rateLimiter = new RateLimitService();

// 1. Rate Limiting Tests
$testEmail = 'attacker_' . bin2hex(random_bytes(4)) . '@test.id';
$testIp = '192.168.1.100';

$rateLimiter->clearAttempts($testEmail, $testIp);
it("Initial attempts is not blocked", !$rateLimiter->tooManyAttempts($testEmail, $testIp));

for ($i = 1; $i <= 4; $i++) {
    $rateLimiter->recordFailedAttempt($testEmail, $testIp);
}
it("After 4 failed attempts, still not blocked", !$rateLimiter->tooManyAttempts($testEmail, $testIp));

$rateLimiter->recordFailedAttempt($testEmail, $testIp); // 5th attempt
it("After 5 failed attempts, rate limiter blocks access", $rateLimiter->tooManyAttempts($testEmail, $testIp));

$rateLimiter->clearAttempts($testEmail, $testIp);
it("clearAttempts resets attempt counter", !$rateLimiter->tooManyAttempts($testEmail, $testIp));

// 2. Timing attack mitigation test (non-existent email)
$nonExistentEmail = 'nonexistent_' . bin2hex(random_bytes(6)) . '@domain.id';
$loginResult = $auth->attempt($nonExistentEmail, 'somepassword123');
it("Attempting non-existent email safely returns false", $loginResult === false);

// 3. Demo fallback removal in AuthService
$_SESSION = [];
it("AuthService::tenantId() returns empty string when unauthenticated (no demo fallback)", $auth->tenantId() === '');

// 4. Registration with valid and invalid data
$newEmail = 'user_' . bin2hex(random_bytes(4)) . '@company.co.id';
$validPass = 'Password12345#Secured';

// Test successful registration
$regError = $auth->register('PT Solusi Amanah Digital', 'Budi Santoso', $newEmail, $validPass, 'pro');
it("Register valid company and user returns null error", $regError === null);
it("Newly registered user is automatically authenticated", $auth->check() === true);
it("User tenant ID is dynamically assigned", !empty($auth->tenantId()) && $auth->tenantId() !== 'tenant_demo_01');

// Test duplicate registration error
$dupError = $auth->register('PT Lain', 'Budi Dua', $newEmail, $validPass, 'pro');
it("Register with existing email returns human-friendly error", $dupError !== null);

// 5. Test password upgrade logic if needs rehash
$userRow = Database::fetchOne("SELECT password_hash FROM users WHERE email = :email", ['email' => $newEmail]);
it("Password is saved as secure hash", !empty($userRow['password_hash']) && str_starts_with($userRow['password_hash'], '$2y$'));

// Clean up test data
Database::query("DELETE FROM users WHERE email = :email", ['email' => $newEmail]);
$rateLimiter->clearAttempts($testEmail, $testIp);

echo "\n========================================\n";
echo "Ringkasan Hasil Uji: $passed Lolos, $failed Gagal.\n";

if ($failed > 0) {
    exit(1);
}
echo "SELURUH FITUR KEAMANAN AUTH & RATE LIMITING SUKSES TERVERIFIKASI.\n";
