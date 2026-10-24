<?php

declare(strict_types=1);

// PSR-4 Autoloader for App namespace
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

$config = require __DIR__ . '/config/app.php';
date_default_timezone_set($config['timezone'] ?? 'Asia/Jakarta');

$isProd = ($config['env'] ?? 'production') === 'production';
ini_set('display_errors', $isProd ? '0' : '1');
ini_set('log_errors', '1');

// Global View & Escape Helpers
if (!function_exists('e')) {
    function e(mixed $val): string {
        return \App\Core\View::e($val);
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string {
        return \App\Core\Request::csrfField();
    }
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
            $req = new \App\Core\Request();
            $base = $req->getBasePath();
        }
        $normalizedPath = '/' . ltrim($path, '/');
        return $base . $normalizedPath;
    }
}

if (!function_exists('is_active')) {
    function is_active(string $path): bool {
        $req = new \App\Core\Request();
        $current = $req->getPath();
        if ($path === '/' && $current === '/') return true;
        return $path !== '/' && str_starts_with($current, $path);
    }
}
