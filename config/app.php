<?php

declare(strict_types=1);

// Helper function to read environment variables with defaults
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed {
        $value = $_ENV[$key] ?? getenv($key);
        if ($value === false || $value === null) {
            return $default;
        }
        return match (strtolower((string) $value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'empty', '(empty)' => '',
            'null', '(null)' => null,
            default => $value,
        };
    }
}

return [
    'name' => env('APP_NAME', 'NyautWa'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => rtrim(env('APP_URL', 'http://localhost:8000'), '/'),
    'secret' => env('APP_SECRET', 'nyautwa_secret_default_key'),
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'engine' => [
        'url' => rtrim(env('ENGINE_URL', 'http://127.0.0.1:3000'), '/'),
        'secret' => env('ENGINE_SECRET', 'nyautwa_engine_internal_secret_994821'),
    ],
];
