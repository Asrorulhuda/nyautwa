<?php

declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $file = $baseDir . str_replace('\\', '/', substr($class, $len)) . '.php';
    if (file_exists($file)) require_once $file;
});

$envFile = __DIR__ . '/.env';
if (file_exists($envFile) && is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k);
        $v = trim($v, " \t\"'");
        $_ENV[$k] = $v;
        $_SERVER[$k] = $v;
        putenv("{$k}={$v}");
    }
}

$config = require __DIR__ . '/config/app.php';
date_default_timezone_set($config['timezone'] ?? 'Asia/Jakarta');

$isProd = ($config['env'] ?? 'production') === 'production';
ini_set('display_errors', $isProd ? '0' : '1');
ini_set('log_errors', '1');

if (!function_exists('e')) {
    function e(mixed $val): string { return \App\Core\View::e($val); }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string { return \App\Core\Request::csrfField(); }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string { return \App\Core\Request::csrfToken(); }
}

if (!function_exists('old')) {
    function old(string $key, mixed $default = ''): mixed {
        return $_SESSION['old_inputs'][$key] ?? $default;
    }
}

if (!function_exists('url')) {
    function url(string $path = '/'): string {
        static $base = null;
        if ($base === null) {
            $base = (new \App\Core\Request())->getBasePath();
        }
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('is_active')) {
    function is_active(string $path): bool {
        $current = (new \App\Core\Request())->getPath();
        return ($path === '/' && $current === '/') || ($path !== '/' && str_starts_with($current, $path));
    }
}
