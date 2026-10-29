<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Database, Request, Response, View};
use App\Services\{ApiKeyService, AuthService, DeviceService, SubscriptionService};

class ApiKeyController {
    public function __construct(
        private AuthService $auth = new AuthService(),
        private ApiKeyService $apiKeys = new ApiKeyService(),
        private DeviceService $devices = new DeviceService(),
        private SubscriptionService $subs = new SubscriptionService()
    ) {}

    private function requireAuth(): string {
        if (!$this->auth->check()) { Response::redirect('/login'); return ''; }
        return $this->auth->tenantId();
    }

    public function index(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$this->subs->canAccess($tenantId, 'api_keys')) {
            Response::withFlash('error', 'Fitur REST API & Webhook terkunci pada paket Anda. Silakan upgrade paket.', '/onboarding/plan');
            return;
        }

        $keys = $this->apiKeys->getKeys($tenantId);
        $devices = $this->devices->getDevices($tenantId);
        $webhookUrl = (string) ($devices[0]['webhook_url'] ?? '');
        $webhookSecret = (string) ($devices[0]['webhook_secret'] ?? '');

        $apiCallsToday = (int) (Database::fetchOne("SELECT COUNT(*) AS c FROM messages WHERE tenant_id = :tid AND DATE(created_at) = CURDATE()", ['tid' => $tenantId])['c'] ?? 0);
        $apiCallsTotal = (int) (Database::fetchOne("SELECT COUNT(*) AS c FROM messages WHERE tenant_id = :tid", ['tid' => $tenantId])['c'] ?? 0);

        View::render('api-keys/index', [
            'title' => 'API Keys & Webhooks Management',
            'keys' => $keys,
            'webhookUrl' => $webhookUrl,
            'webhookSecret' => $webhookSecret,
            'apiCallsToday' => $apiCallsToday,
            'apiCallsTotal' => $apiCallsTotal,
            'newKey' => $_SESSION['just_created_key'] ?? null,
            'newRawKey' => $_SESSION['just_created_key']['raw_key'] ?? null,
        ], 'app');

        unset($_SESSION['just_created_key']);
    }

    public function create(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$request->validateCsrf()) Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa.', '/api-keys');

        $name = trim((string) $request->input('name', ''));
        if (empty($name)) Response::withFlash('error', 'Nama identifier API Key wajib diisi.', '/api-keys');

        $created = $this->apiKeys->createKey($tenantId, $name);
        $_SESSION['just_created_key'] = $created;
        Response::withFlash('success', "API Key '{$name}' berhasil dibuat. Simpan kunci rahasia sekarang.", '/api-keys');
    }

    public function revoke(Request $request, string $id = ''): void {
        $tenantId = $this->requireAuth();
        $keyId = !empty($id) ? $id : (string) $request->input('id', '');
        if ($request->validateCsrf() && !empty($keyId)) {
            $this->apiKeys->revokeKey($keyId, $tenantId);
            Response::withFlash('success', 'API Key telah dicabut dan tidak dapat digunakan lagi.', '/api-keys');
        }
        Response::redirect('/api-keys');
    }

    public function updateWebhook(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$request->validateCsrf()) Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa.', '/api-keys');

        $url = trim((string) $request->input('webhook_url', ''));
        $this->apiKeys->updateWebhook($tenantId, $url);
        Response::withFlash('success', 'URL Webhook berhasil diperbarui untuk perangkat Anda.', '/api-keys');
    }
}
