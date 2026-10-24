<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\ApiKeyService;
use App\Services\AuthService;
use App\Services\DeviceService;

class ApiKeyController {
    private AuthService $auth;
    private ApiKeyService $apiKeys;
    private DeviceService $devices;

    public function __construct() {
        $this->auth = new AuthService();
        $this->apiKeys = new ApiKeyService();
        $this->devices = new DeviceService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $tenantId = $this->auth->tenantId();
        $keys = $this->apiKeys->getKeys($tenantId);
        $devices = $this->devices->getDevices($tenantId);
        $primaryWebhook = $devices[0]['webhook_url'] ?? 'https://api.bisnisanda.com/webhook/whatsapp';

        View::render('api-keys/index', [
            'title' => 'API Keys & Webhooks Management',
            'keys' => $keys,
            'primaryWebhook' => $primaryWebhook,
            'newKey' => $_SESSION['just_created_key'] ?? null,
            'newRawKey' => $_SESSION['just_created_key']['raw_key'] ?? null,
        ], 'app');

        unset($_SESSION['just_created_key']);
    }

    public function create(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa.', '/api-keys');
        }

        $tenantId = $this->auth->tenantId();
        $name = trim((string) $request->input('name', 'Backend Integration'));

        if (empty($name)) {
            Response::withFlash('error', 'Nama API Key wajib diisi.', '/api-keys');
        }

        $created = $this->apiKeys->createKey($tenantId, $name);
        $_SESSION['just_created_key'] = $created;

        Response::withFlash('success', "API Key '{$name}' berhasil dibuat! Segera salin kunci rahasia Anda sekarang.", '/api-keys');
    }

    public function revoke(Request $request, string $id = ''): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }
        $keyId = !empty($id) ? $id : (string) $request->input('id', '');
        if ($request->validateCsrf() && !empty($keyId)) {
            $this->apiKeys->revokeKey($keyId, $this->auth->tenantId());
            Response::withFlash('success', 'API Key telah dicabut dan tidak dapat digunakan lagi.', '/api-keys');
        }
        Response::redirect('/api-keys');
    }

    public function updateWebhook(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa.', '/api-keys');
        }

        $tenantId = $this->auth->tenantId();
        $url = trim((string) $request->input('webhook_url', ''));

        $this->apiKeys->updateWebhook($tenantId, $url);
        Response::withFlash('success', 'URL Webhook berhasil diperbarui ke seluruh perangkat aktif.', '/api-keys');
    }
}
