<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

if (!headers_sent()) {
    header_remove('X-Powered-By');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

$router = new \App\Core\Router();
$request = new \App\Core\Request();

require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/api.php';

try {
    $router->dispatch($request);
} catch (\Throwable $e) {
    http_response_code(500);
    error_log("NyautWa Server Error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
    $debug = env('APP_DEBUG', false);
    if ($debug) {
        echo "<div style='font-family:sans-serif;padding:24px;background:#fff1f0;border:1px solid #ffa39e;border-radius:8px;max-width:800px;margin:40px auto;'>";
        echo "<h2 style='color:#cf1322;margin-top:0;'>Terjadi Kesalahan Sistem (500)</h2>";
        echo "<p><strong>Pesan:</strong> " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8') . " (Baris " . $e->getLine() . ")</p>";
        echo "<pre style='background:#17211F;color:#EAF7F0;padding:12px;border-radius:4px;overflow:auto;font-size:12px;'>" . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . "</pre>";
        echo "</div>";
    } else {
        echo "<div style='font-family:sans-serif;text-align:center;padding:60px 20px;'>";
        echo "<h1 style='color:#17211F;font-size:48px;margin-bottom:8px;'>500</h1>";
        echo "<h2 style='color:#17211F;margin-top:0;'>Terjadi Gangguan pada Server</h2>";
        echo "<p style='color:#697570;'>Mohon periksa pengaturan database MySQL pada file <code>.env</code> Anda.</p>";
        echo "<p style='color:#8c9b94;font-size:13px;'>Aktifkan <code>APP_DEBUG=true</code> pada file .env untuk melihat rincian error teknis.</p>";
        echo "<a href='/' style='display:inline-block;margin-top:16px;padding:10px 20px;background:#16A36A;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;'>Kembali ke Beranda</a>";
        echo "</div>";
    }
}
