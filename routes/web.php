<?php

declare(strict_types=1);

/** @var \App\Core\Router $router */

$router->get('/', [\App\Controllers\LandingController::class, 'index']);

// Auth routes
$router->get('/login', [\App\Controllers\AuthController::class, 'showLogin']);
$router->post('/login', [\App\Controllers\AuthController::class, 'login']);
$router->get('/register', [\App\Controllers\AuthController::class, 'showRegister']);
$router->post('/register', [\App\Controllers\AuthController::class, 'register']);
$router->post('/logout', [\App\Controllers\AuthController::class, 'logout']);

// App / Dashboard Protected routes
$router->get('/dashboard', [\App\Controllers\DashboardController::class, 'index']);

// Devices
$router->get('/devices', [\App\Controllers\DeviceController::class, 'index']);
$router->get('/devices/connect', [\App\Controllers\DeviceController::class, 'connect']);
$router->post('/devices/create', [\App\Controllers\DeviceController::class, 'create']);
$router->get('/devices/{id}/status', [\App\Controllers\DeviceController::class, 'status']);
$router->post('/devices/{id}/disconnect', [\App\Controllers\DeviceController::class, 'disconnect']);

// Messages / Outbox
$router->get('/messages', [\App\Controllers\MessageController::class, 'index']);
$router->get('/messages/send', [\App\Controllers\MessageController::class, 'create']);
$router->post('/messages/send', [\App\Controllers\MessageController::class, 'send']);

// API Keys & Webhooks
$router->get('/api-keys', [\App\Controllers\ApiKeyController::class, 'index']);
$router->post('/api-keys/create', [\App\Controllers\ApiKeyController::class, 'create']);
$router->post('/api-keys/{id}/revoke', [\App\Controllers\ApiKeyController::class, 'revoke']);
$router->post('/webhook/update', [\App\Controllers\ApiKeyController::class, 'updateWebhook']);
