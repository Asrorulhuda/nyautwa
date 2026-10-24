<?php
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

/* ---------- Load .env (di luar document root) ---------- */
(function (): void {
    $file = BASE_PATH . '/.env';
    if (!is_readable($file)) return;
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v, " \t\"'");
    }
})();

function env(string $key, ?string $default = null): ?string
{
    return $_ENV[$key] ?? $default;
}

/* ---------- Error handling: tampilkan generik, simpan detail di log ---------- */
$isProd = env('APP_ENV', 'production') === 'production';
error_reporting(E_ALL);
ini_set('display_errors', $isProd ? '0' : '1');
ini_set('log_errors', '1');
ini_set('error_log', BASE_PATH . '/storage/logs/php-error.log');

set_exception_handler(function (Throwable $e): void {
    error_log((string) $e);
    http_response_code(500);
    echo 'Terjadi kesalahan. Silakan coba lagi nanti.';
});

/* ---------- Paksa HTTPS di production ---------- */
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
if ($isProd && !$https && PHP_SAPI !== 'cli') {
    $host = env('APP_HOST', '');
    if ($host !== '') {
        header('Location: https://' . $host . $_SERVER['REQUEST_URI'], true, 301);
    }
    exit;
}

/* ---------- Security headers ---------- */
header_remove('X-Powered-By');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
header("Content-Security-Policy: default-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'none'; form-action 'self'");
if ($https) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

/* ---------- Session aman ---------- */
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'secure'   => $https,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

// Logout otomatis setelah 30 menit tidak aktif
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

require BASE_PATH . '/includes/db.php';
require BASE_PATH . '/includes/security.php';
