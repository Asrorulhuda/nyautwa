<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Controllers\AuthController;
use App\Core\Request;
use App\Core\Response;
use App\Core\Csrf;
use App\Core\Database;
use App\Services\RateLimitService;

Response::$preventExit = true;

echo "=== NyautWa AuthController Form Validation Test ===\n\n";

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

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new AuthController();
$rateLimiter = new RateLimitService();
$csrfToken = Csrf::token();

// 1. Test short password rejection (< 12 chars)
$_SESSION['flash_error'] = null;
$_SESSION['flash_success'] = null;
$_POST = [
    '_csrf_token' => $csrfToken,
    'company' => 'PT Aman Sekali',
    'name' => 'Fauzi',
    'email' => 'fauzi@aman.id',
    'password' => 'pendek123',
    'password_confirmation' => 'pendek123',
    'plan' => 'starter',
];
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

$controller->register(new Request());
it("Password < 12 characters is rejected", str_contains((string)($_SESSION['flash_error'] ?? ''), 'minimal 12'));
it("Old input retained email and company", ($_SESSION['old_inputs']['company'] ?? '') === 'PT Aman Sekali');
it("Old input excludes sensitive password", !isset($_SESSION['old_inputs']['password']));

// 2. Test password confirmation mismatch rejection
$_SESSION['flash_error'] = null;
$_POST['password'] = 'PasswordKuat1234!';
$_POST['password_confirmation'] = 'PasswordBeda1234!';
$controller->register(new Request());
it("Mismatched password confirmation is rejected", str_contains((string)($_SESSION['flash_error'] ?? ''), 'Konfirmasi kata sandi tidak cocok'));

// 3. Test invalid email rejection
$_SESSION['flash_error'] = null;
$_POST['email'] = 'bukan-email-valid';
$_POST['password_confirmation'] = 'PasswordKuat1234!';
$controller->register(new Request());
it("Invalid email format is rejected", str_contains((string)($_SESSION['flash_error'] ?? ''), 'alamat email tidak valid'));

// 4. Test valid registration
$_SESSION['flash_error'] = null;
$_SESSION['flash_success'] = null;
$uniqueEmail = 'valid_' . bin2hex(random_bytes(4)) . '@company.id';
$_POST['email'] = $uniqueEmail;
$_POST['password'] = 'PasswordKuat1234!';
$_POST['password_confirmation'] = 'PasswordKuat1234!';
$controller->register(new Request());
it("Valid registration succeeds", str_contains((string)($_SESSION['flash_success'] ?? ''), 'Pendaftaran akun berhasil'));

// 5. Test Login Validations & Rate Limiting
$_SESSION['flash_error'] = null;
$_SESSION['flash_success'] = null;
$testLoginEmail = 'wrong_' . bin2hex(random_bytes(4)) . '@test.id';
$rateLimiter->clearAttempts($testLoginEmail, '127.0.0.1');

$_POST = [
    '_csrf_token' => $csrfToken,
    'email' => $testLoginEmail,
    'password' => 'WrongPassword123!',
];
$controller->login(new Request());
it("Failed login shows generic error", str_contains((string)($_SESSION['flash_error'] ?? ''), 'tidak cocok'));

// Fail 4 more times to reach 5
for ($i = 0; $i < 4; $i++) {
    $controller->login(new Request());
}
// 6th attempt should be blocked by rate limit
$_SESSION['flash_error'] = null;
$controller->login(new Request());
it("Rate limiter blocks 6th attempt", str_contains((string)($_SESSION['flash_error'] ?? ''), 'Terlalu banyak percobaan'));

// Test successful login
$rateLimiter->clearAttempts($uniqueEmail, '127.0.0.1');
$_SESSION['flash_error'] = null;
$_SESSION['flash_success'] = null;
$_POST = [
    '_csrf_token' => $csrfToken,
    'email' => $uniqueEmail,
    'password' => 'PasswordKuat1234!',
];
$controller->login(new Request());
it("Correct credentials logs in successfully", str_contains((string)($_SESSION['flash_success'] ?? ''), 'Selamat datang kembali'));

// Clean up
Database::query("DELETE FROM users WHERE email = :email", ['email' => $uniqueEmail]);
$rateLimiter->clearAttempts($testLoginEmail, '127.0.0.1');

echo "\n========================================\n";
echo "Ringkasan: $passed Lolos, $failed Gagal.\n";

if ($failed > 0) exit(1);
