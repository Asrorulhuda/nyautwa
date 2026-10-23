<?php

declare(strict_types=1);

/** @var \App\Core\Router $router */

// Public REST API v1 (Sesuai 03-api-spec.md)
$router->get('/api/v1/devices', [\App\Controllers\Api\DeviceApiController::class, 'index']);
$router->post('/api/v1/devices', [\App\Controllers\Api\DeviceApiController::class, 'create']);
$router->get('/api/v1/devices/{id}/qr', [\App\Controllers\Api\DeviceApiController::class, 'qr']);
$router->post('/api/v1/devices/{id}/qr', [\App\Controllers\Api\DeviceApiController::class, 'qr']);
$router->post('/api/v1/devices/{id}/logout', [\App\Controllers\Api\DeviceApiController::class, 'logout']);

$router->post('/api/v1/messages', [\App\Controllers\Api\MessageApiController::class, 'send']);
$router->post('/api/v1/messages/bulk', [\App\Controllers\Api\MessageApiController::class, 'bulk']);
$router->get('/api/v1/messages/{id}', [\App\Controllers\Api\MessageApiController::class, 'show']);
$router->get('/api/v1/messages', [\App\Controllers\Api\MessageApiController::class, 'index']);

$router->post('/api/v1/numbers/check', [\App\Controllers\Api\UtilityApiController::class, 'checkNumber']);
$router->get('/api/v1/usage', [\App\Controllers\Api\UtilityApiController::class, 'usage']);

// Internal Callback from Baileys Engine
$router->post('/api/v1/internal/callback', [\App\Controllers\Api\CallbackApiController::class, 'handle']);
