<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;
use App\Services\ApiKeyService;
use App\Services\DeviceService;
use App\Services\QuotaService;

class DeviceApiController {
    private ApiKeyService $apiKeys;
    private DeviceService $devices;
    private QuotaService $quota;

    public function __construct() {
        $this->apiKeys = new ApiKeyService();
        $this->devices = new DeviceService();
        $this->quota = new QuotaService();
    }

    private function authenticate(Request $request): array {
        $token = $request->bearerToken();
        if (!$token) {
            Response::apiError('unauthorized', 'Header Authorization Bearer token wajib disertakan.', 401);
        }
        $tenant = $this->apiKeys->validateRawKey($token);
        if (!$tenant) {
            Response::apiError('invalid_api_key', 'API Key tidak valid atau telah dicabut.', 401);
        }
        $this->quota->recordUsage($tenant['id'], 0, 1);
        return $tenant;
    }

    private function rateLimitHeaders(string $tenantId): array {
        $rl = $this->quota->getRateLimitInfo($tenantId);
        return [
            'X-RateLimit-Limit' => (string) $rl['limit'],
            'X-RateLimit-Remaining' => (string) $rl['remaining'],
            'X-RateLimit-Reset' => (string) $rl['reset'],
        ];
    }

    public function index(Request $request): void {
        $tenant = $this->authenticate($request);
        $list = $this->devices->getDevices($tenant['id']);
        Response::json(['data' => $list], 200, $this->rateLimitHeaders($tenant['id']));
    }

    public function create(Request $request): void {
        $tenant = $this->authenticate($request);
        $data = $request->all();
        $label = trim((string) ($data['label'] ?? 'Device ' . (count($this->devices->getDevices($tenant['id'])) + 1)));
        $whUrl = !empty($data['webhook_url']) ? trim((string) $data['webhook_url']) : null;

        $device = $this->devices->createDevice($tenant['id'], $label, $whUrl);
        if (!$device) {
            Response::apiError('device_limit_reached', 'Batas kuota perangkat untuk paket Anda telah tercapai.', 402, $this->rateLimitHeaders($tenant['id']));
        }
        Response::json(['data' => $device], 201, $this->rateLimitHeaders($tenant['id']));
    }

    public function qr(Request $request, string $id): void {
        $tenant = $this->authenticate($request);
        $device = $this->devices->find($id, $tenant['id']);
        if (!$device) {
            Response::apiError('device_not_found', 'Device tidak ditemukan.', 404, $this->rateLimitHeaders($tenant['id']));
        }
        Response::json([
            'device_id' => $device['id'],
            'status' => $device['status'],
            'qr' => $device['qr_code'] ?? 'mock_qr_raw_string',
        ], 200, $this->rateLimitHeaders($tenant['id']));
    }

    public function logout(Request $request, string $id): void {
        $tenant = $this->authenticate($request);
        $device = $this->devices->find($id, $tenant['id']);
        if (!$device) {
            Response::apiError('device_not_found', 'Device tidak ditemukan.', 404, $this->rateLimitHeaders($tenant['id']));
        }
        $this->devices->disconnect($id, $tenant['id']);
        Response::json(['message' => 'Sesi perangkat berhasil diputuskan.'], 200, $this->rateLimitHeaders($tenant['id']));
    }
}
