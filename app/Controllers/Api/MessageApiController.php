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

    private function authenticate(Request $request): ?array {
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

    public function send(Request $request): void {
        $tenant = $this->authenticate($request);
        $data = $request->all();

        $phone = trim((string) ($data['phone'] ?? $data['to'] ?? ''));
        $body = trim((string) ($data['message'] ?? $data['body'] ?? ''));
        $deviceId = (string) ($data['device_id'] ?? '');
        $idempotencyKey = $data['idempotency_key'] ?? $request->header('idempotency-key');

        if (empty($phone) || empty($body)) {
            Response::json([
                'success' => false,
                'error' => 'Field phone dan message wajib diisi.',
            ], 422);
        }

        // If deviceId not specified, pick the primary active device for this tenant
        if (empty($deviceId)) {
            $devices = $this->devices->getDevices($tenant['id']);
            $activeDevice = null;
            foreach ($devices as $d) {
                if ($d['status'] === 'connected') {
                    $activeDevice = $d;
                    break;
                }
            }
            if (!$activeDevice) {
                $activeDevice = $devices[0] ?? null;
            }
            if (!$activeDevice) {
                Response::json([
                    'success' => false,
                    'error' => 'Tenant belum memiliki perangkat WhatsApp yang terdaftar.',
                ], 400);
            }
            $deviceId = $activeDevice['id'];
        }

        $message = $this->messages->queueMessage($tenant['id'], $deviceId, $phone, $body, $idempotencyKey);

        Response::json([
            'success' => true,
            'message' => 'Pesan berhasil dijadwalkan ke antrean gateway.',
            'data' => [
                'id' => $message['id'],
                'device_id' => $message['device_id'],
                'recipient' => $message['to_from'],
                'status' => $message['status'],
                'wa_message_id' => $message['wa_message_id'],
                'queued_at' => $message['queued_at'],
                'estimated_delivery' => '3s',
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
            Response::json(['success' => false, 'error' => 'Pesan dengan ID tersebut tidak ditemukan.'], 404);
        }

        Response::json([
            'success' => true,
            'data' => $msg,
        ]);
    }
}
