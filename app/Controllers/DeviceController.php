<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\DeviceService;

class DeviceController {
    private AuthService $auth;
    private DeviceService $devices;

    public function __construct() {
        $this->auth = new AuthService();
        $this->devices = new DeviceService();
    }

    private function requireAuth(): string {
        if (!$this->auth->check()) Response::redirect('/login');
        return $this->auth->tenantId();
    }

    public function index(Request $request): void {
        $tenantId = $this->requireAuth();
        View::render('devices/index', ['title' => 'Koneksi Perangkat WhatsApp', 'devices' => $this->devices->getDevices($tenantId)], 'app');
    }

    public function connect(Request $request): void {
        $tenantId = $this->requireAuth();
        $deviceId = $request->input('id');
        $device = $deviceId ? $this->devices->find($deviceId, $tenantId) : null;
        if (!$device) {
            $all = $this->devices->getDevices($tenantId);
            $device = $all[0] ?? $this->devices->createDevice($tenantId, 'Nomor Utama', '6281234567890');
        }
        View::render('devices/connect', ['title' => 'Scan QR Perangkat WhatsApp', 'device' => $device], 'app');
    }

    public function create(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$request->validateCsrf()) Response::withFlash('error', 'Sesi Anda telah kedaluwarsa.', '/devices');

        $label = trim((string) $request->input('label', 'WhatsApp Node'));
        $rawPhone = preg_replace('/[^0-9]/', '', (string) $request->input('phone', ''));
        $phone = str_starts_with($rawPhone, '0') ? ('62' . substr($rawPhone, 1)) : $rawPhone;
        $webhook = trim((string) $request->input('webhook_url', ''));
        $dailyLimit = (int) $request->input('daily_limit', 1000);

        if (empty($label) || empty($phone)) {
            Response::withFlash('error', 'Nama label dan nomor WhatsApp wajib diisi.', '/devices');
        }
        $device = $this->devices->createDevice($tenantId, $label, $phone, $webhook ?: null, $dailyLimit);
        Response::withFlash('success', "Perangkat '{$label}' ({$phone}) berhasil dibuat.", "/devices/connect?id={$device['id']}");
    }

    public function status(Request $request, string $id): void {
        if (!$this->auth->check()) Response::json(['error' => 'Unauthorized'], 401);
        $device = $this->devices->find($id, $this->auth->tenantId());
        if (!$device) Response::json(['error' => 'Device not found'], 404);
        Response::json(['status' => $device['status'], 'phone' => $device['phone'], 'qr_code' => $device['qr_code'], 'session_ref' => $device['session_ref']]);
    }

    public function disconnect(Request $request, string $id): void {
        $tenantId = $this->requireAuth();
        if ($request->validateCsrf()) {
            $this->devices->disconnect($id, $tenantId);
            Response::withFlash('success', 'Perangkat berhasil diputuskan.', '/devices');
        }
        Response::redirect('/devices');
    }

    public function delete(Request $request, string $id = ''): void {
        $tenantId = $this->requireAuth();
        $devId = !empty($id) ? $id : (string) $request->input('id', '');
        if ($request->validateCsrf() && !empty($devId)) {
            $this->devices->deleteDevice($devId, $tenantId);
            Response::withFlash('success', 'Perangkat berhasil dihapus dari sistem.', '/devices');
        }
        Response::redirect('/devices');
    }
}
