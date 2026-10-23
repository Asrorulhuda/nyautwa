<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;
use App\Services\ApiKeyService;
use App\Services\DeviceService;

class DeviceApiController {
    private ApiKeyService $apiKeys;
    private DeviceService $devices;

    public function __construct() {
        $this->apiKeys = new ApiKeyService();
        $this->devices = new DeviceService();
    }

    private function authenticate(Request $request): ?array {
        $token = $request->bearerToken();
        if (!$token) {
            Response::json(['success' => false, 'error' => 'Header Authorization Bearer token wajib disertakan.'], 401);
        }
        $tenant = $this->apiKeys->validateRawKey($token);
        if (!$tenant) {
            Response::json(['success' => false, 'error' => 'API Key tidak valid.'], 401);
        }
        return $tenant;
    }

    public function index(Request $request): void {
        $tenant = $this->authenticate($request);
        $list = $this->devices->getDevices($tenant['id']);

        Response::json([
            'success' => true,
            'data' => array_map(function ($d) {
                return [
                    'id' => $d['id'],
                    'label' => $d['label'],
                    'phone' => $d['phone'],
                    'status' => $d['status'],
                    'daily_limit' => $d['daily_limit'],
                    'webhook_url' => $d['webhook_url'],
                ];
            }, $list),
        ]);
    }

    public function qr(Request $request, string $id): void {
        $tenant = $this->authenticate($request);
        $device = $this->devices->find($id, $tenant['id']);

        if (!$device) {
            Response::json(['success' => false, 'error' => 'Device tidak ditemukan.'], 404);
        }

        Response::json([
            'success' => true,
            'data' => [
                'device_id' => $device['id'],
                'session_ref' => $device['session_ref'],
                'qr_code' => $device['qr_code'] ?? 'mock_qr_string_sample',
                'status' => $device['status'],
            ],
        ]);
    }
}
