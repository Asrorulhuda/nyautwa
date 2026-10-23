<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Services\ApiKeyService;
use App\Services\DeviceService;
use App\Services\MessageService;

class MessageApiController {
    private ApiKeyService $apiKeys;
    private DeviceService $devices;
    private MessageService $messages;

    public function __construct() {
        $this->apiKeys = new ApiKeyService();
        $this->devices = new DeviceService();
        $this->messages = new MessageService();
    }

    private function authenticate(Request $request): array {
        $token = $request->bearerToken();
        if (!$token) {
            Response::json(['success' => false, 'error' => 'Header Authorization Bearer token wajib disertakan.'], 401);
        }
        $tenant = $this->apiKeys->validateRawKey($token);
        if (!$tenant) {
            Response::json(['success' => false, 'error' => 'API Key tidak valid atau telah dicabut.'], 401);
        }
        return $tenant;
    }

    private function resolveDeviceId(string $tenantId, string $deviceId): string {
        if (!empty($deviceId)) return $deviceId;
        $devices = $this->devices->getDevices($tenantId);
        foreach ($devices as $d) {
            if ($d['status'] === 'connected') return $d['id'];
        }
        if (!empty($devices[0]['id'])) return $devices[0]['id'];
        Response::json(['success' => false, 'error' => 'Tenant belum memiliki perangkat WhatsApp.'], 400);
        return '';
    }

    public function send(Request $request): void {
        $tenant = $this->authenticate($request);
        $data = $request->all();
        $phone = trim((string) ($data['phone'] ?? $data['to'] ?? ''));
        $body = trim((string) ($data['message'] ?? $data['body'] ?? ''));
        if (empty($phone) || empty($body)) {
            Response::json(['success' => false, 'error' => 'Field phone dan message wajib diisi.'], 422);
        }
        $deviceId = $this->resolveDeviceId($tenant['id'], (string) ($data['device_id'] ?? ''));
        $idempotencyKey = $data['idempotency_key'] ?? $request->header('idempotency-key');
        $msg = $this->messages->queueMessage($tenant['id'], $deviceId, $phone, $body, $idempotencyKey);

        Response::json([
            'success' => true,
            'message' => 'Pesan berhasil dijadwalkan ke antrean gateway.',
            'data' => [
                'id' => $msg['id'],
                'message_id' => $msg['id'],
                'device_id' => $msg['device_id'],
                'phone' => $msg['to_from'],
                'status' => $msg['status'],
                'wa_message_id' => $msg['wa_message_id'],
                'queued_at' => $msg['queued_at'],
            ],
        ], 202);
    }

    public function show(Request $request, string $id): void {
        $tenant = $this->authenticate($request);
        $msg = Database::fetchOne(
            "SELECT id, device_id, to_from, type, body, status, wa_message_id, error, queued_at, sent_at FROM messages WHERE id = :id AND tenant_id = :tenant_id",
            ['id' => $id, 'tenant_id' => $tenant['id']]
        );
        if (!$msg) {
            Response::json(['success' => false, 'error' => 'Pesan tidak ditemukan.'], 404);
        }
        Response::json(['success' => true, 'data' => $msg]);
    }
}
