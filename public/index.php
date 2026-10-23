<?php

declare(strict_types=1);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Start secure session
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400 * 7,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Bootstrap application
require dirname(__DIR__) . '/bootstrap.php';

// Initialize Router and dispatch
$router = new \App\Core\Router();
$request = new \App\Core\Request();

// Register Web & API Routes
require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/api.php';

$router->dispatch($request);
