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

// Devices & Baileys Session
$router->get('/devices', [\App\Controllers\DeviceController::class, 'index']);
$router->post('/devices', [\App\Controllers\DeviceController::class, 'create']);
$router->get('/devices/connect', [\App\Controllers\DeviceController::class, 'connect']);
$router->post('/devices/create', [\App\Controllers\DeviceController::class, 'create']);
$router->get('/devices/{id}/status', [\App\Controllers\DeviceController::class, 'status']);
$router->post('/devices/disconnect/{id}', [\App\Controllers\DeviceController::class, 'disconnect']);
$router->post('/devices/{id}/disconnect', [\App\Controllers\DeviceController::class, 'disconnect']);
$router->post('/devices/delete', [\App\Controllers\DeviceController::class, 'delete']);
$router->post('/devices/delete/{id}', [\App\Controllers\DeviceController::class, 'delete']);
$router->post('/devices/{id}/delete', [\App\Controllers\DeviceController::class, 'delete']);
$router->get('/devices/live-qr/{id}', [\App\Controllers\DeviceSessionController::class, 'qr']);
$router->post('/devices/live-qr/{id}', [\App\Controllers\DeviceSessionController::class, 'qr']);
$router->post('/devices/pairing-code/{id}', [\App\Controllers\DeviceSessionController::class, 'pairingCode']);
$router->get('/devices/poll/{id}', [\App\Controllers\DeviceSessionController::class, 'poll']);

// Auto-Reply WhatsApp
$router->get('/autoreplies', [\App\Controllers\AutoReplyController::class, 'index']);
$router->post('/autoreplies', [\App\Controllers\AutoReplyController::class, 'create']);
$router->post('/autoreplies/delete/{id}', [\App\Controllers\AutoReplyController::class, 'delete']);
$router->get('/autoreplies/toggle/{id}', [\App\Controllers\AutoReplyController::class, 'toggle']);

// Phonebook (Contacts & Tags)
$router->get('/contacts', [\App\Controllers\ContactController::class, 'index']);
$router->post('/contacts', [\App\Controllers\ContactController::class, 'create']);
$router->post('/contacts/sync', [\App\Controllers\ContactController::class, 'sync']);
$router->post('/contacts/tags', [\App\Controllers\ContactController::class, 'createTag']);
$router->post('/contacts/delete/{id}', [\App\Controllers\ContactController::class, 'delete']);

// Broadcast Massal (Campaign Blast)
$router->get('/campaigns', [\App\Controllers\CampaignController::class, 'index']);
$router->post('/campaigns', [\App\Controllers\CampaignController::class, 'create']);
$router->get('/campaigns/start/{id}', [\App\Controllers\CampaignController::class, 'start']);

// Messages / Outbox
$router->get('/messages', [\App\Controllers\MessageController::class, 'index']);
$router->get('/messages/send', [\App\Controllers\MessageController::class, 'create']);
$router->post('/messages/send', [\App\Controllers\MessageController::class, 'send']);
$router->post('/messages/delete', [\App\Controllers\MessageController::class, 'delete']);
$router->post('/messages/delete/{id}', [\App\Controllers\MessageController::class, 'delete']);
$router->post('/messages/bulk-delete', [\App\Controllers\MessageController::class, 'deleteBulk']);

// API Keys & Webhooks
$router->get('/api-keys', [\App\Controllers\ApiKeyController::class, 'index']);
$router->post('/api-keys/create', [\App\Controllers\ApiKeyController::class, 'create']);
$router->post('/api-keys/delete', [\App\Controllers\ApiKeyController::class, 'revoke']);
$router->post('/api-keys/delete/{id}', [\App\Controllers\ApiKeyController::class, 'revoke']);
$router->post('/api-keys/{id}/revoke', [\App\Controllers\ApiKeyController::class, 'revoke']);
$router->post('/webhook/update', [\App\Controllers\ApiKeyController::class, 'updateWebhook']);

// SaaS Client Management, Features, Invoices
$router->get('/clients', [\App\Controllers\ClientController::class, 'index']);
$router->post('/clients/create', [\App\Controllers\ClientController::class, 'create']);
$router->post('/clients/{id}', [\App\Controllers\ClientController::class, 'update']);
$router->post('/clients/{id}/toggle', [\App\Controllers\ClientController::class, 'toggle']);
$router->post('/clients/{id}/delete', [\App\Controllers\ClientController::class, 'delete']);
$router->post('/features/create', [\App\Controllers\FeatureController::class, 'create']);
$router->get('/invoices/{id}', [\App\Controllers\InvoiceController::class, 'show']);

// Admin Landing Page & Docs
$router->get('/settings/landing', [\App\Controllers\LandingConfigController::class, 'index']);
$router->post('/settings/landing', [\App\Controllers\LandingConfigController::class, 'update']);
$router->get('/docs', [\App\Controllers\DocsController::class, 'index']);

// Internal Engine Callback & GitHub Webhook Deploy
$router->post('/api/v1/internal/callback', [\App\Controllers\Api\InternalCallbackController::class, 'handle']);
$router->post('/api/v1/internal/deploy', [\App\Controllers\Api\DeployController::class, 'handle']);


