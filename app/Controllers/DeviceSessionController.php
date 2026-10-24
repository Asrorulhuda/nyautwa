<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
use App\Services\DeviceService;

class DeviceSessionController {
    private AuthService $auth;
    private DeviceService $devices;

    public function __construct() {
        $this->auth = new AuthService();
        $this->devices = new DeviceService();
    }

    private function getTenantId(): string {
        if (!$this->auth->check()) {
            Response::json(['error' => 'Akses tidak sah'], 401);
            return '';
        }
        return $this->auth->tenantId();
    }

    public function qr(Request $request, string $id): void {
        $tenantId = $this->getTenantId();
        if (!$tenantId) return;
        $device = $this->devices->find($id, $tenantId);
        if (!$device) {
            Response::json(['success' => false, 'error' => 'Perangkat tidak ditemukan'], 404);
            return;
        }
        if ($device['status'] === 'connected') {
            Response::json(['success' => true, 'connected' => true, 'phone' => $device['phone']]);
            return;
        }
        if (!empty($device['qr_code']) && $device['status'] === 'qr_ready') {
            Response::json(['success' => true, 'status' => $device['status'], 'qr' => $device['qr_code']]);
            return;
        }
        $res = $this->devices->getLiveQr($id, $tenantId);
        Response::json($res);
    }

    public function pairingCode(Request $request, string $id): void {
        $tenantId = $this->getTenantId();
        if (!$tenantId) return;
        $phone = trim((string) $request->input('phone', ''));
        if (empty($phone)) {
            Response::json(['success' => false, 'error' => 'Nomor WhatsApp wajib diisi'], 400);
            return;
        }
        $res = $this->devices->requestPairingCode($id, $tenantId, $phone);
        Response::json($res);
    }

    public function poll(Request $request, string $id): void {
        $tenantId = $this->getTenantId();
        if (!$tenantId) return;
        $device = $this->devices->find($id, $tenantId);
        if (!$device) {
            Response::json(['error' => 'Perangkat tidak ditemukan'], 404);
            return;
        }
        Response::json([
            'status' => $device['status'],
            'phone' => $device['phone'],
            'connected' => $device['status'] === 'connected',
        ]);
    }
}
