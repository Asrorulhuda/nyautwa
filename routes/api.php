<?php

declare(strict_types=1);

/** @var \App\Core\Router $router */

// Public REST API v1
$router->post('/api/v1/messages', [\App\Controllers\Api\MessageApiController::class, 'send']);
$router->get('/api/v1/messages/{id}', [\App\Controllers\Api\MessageApiController::class, 'show']);
$router->get('/api/v1/devices', [\App\Controllers\Api\DeviceApiController::class, 'index']);
$router->post('/api/v1/devices/{id}/qr', [\App\Controllers\Api\DeviceApiController::class, 'qr']);

// Internal Callback from Baileys Engine
$router->post('/api/v1/internal/callback', [\App\Controllers\Api\CallbackApiController::class, 'handle']);
