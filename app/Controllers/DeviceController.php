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

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $tenantId = $this->auth->tenantId();
        $allDevices = $this->devices->getDevices($tenantId);

        View::render('devices/index', [
            'title' => 'Koneksi Perangkat WhatsApp',
            'devices' => $allDevices,
        ], 'app');
    }

    public function connect(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $tenantId = $this->auth->tenantId();
        $deviceId = $request->input('id');
        $device = null;

        if ($deviceId) {
            $device = $this->devices->find($deviceId, $tenantId);
        }

        if (!$device) {
            $all = $this->devices->getDevices($tenantId);
            $device = $all[0] ?? $this->devices->createDevice($tenantId, 'Nomor CS Default');
        }

        View::render('devices/connect', [
            'title' => 'Scan QR Perangkat WhatsApp',
            'device' => $device,
        ], 'app');
    }

    public function create(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi Anda telah kedaluwarsa.', '/devices');
        }

        $tenantId = $this->auth->tenantId();
        $label = trim((string) $request->input('label', 'WhatsApp Node Baru'));
        $webhook = trim((string) $request->input('webhook_url', ''));
        $dailyLimit = (int) $request->input('daily_limit', 1000);

        if (empty($label)) {
            Response::withFlash('error', 'Nama/Label perangkat wajib diisi.', '/devices');
        }

        $device = $this->devices->createDevice($tenantId, $label, $webhook ?: null, $dailyLimit);
        Response::withFlash('success', "Perangkat '{$label}' berhasil dibuat. Silakan scan kode QR untuk menghubungkan.", "/devices/connect?id={$device['id']}");
    }

    public function status(Request $request, string $id): void {
        if (!$this->auth->check()) {
            Response::json(['error' => 'Unauthorized'], 401);
        }

        $tenantId = $this->auth->tenantId();
        $device = $this->devices->find($id, $tenantId);

        if (!$device) {
            Response::json(['error' => 'Device not found'], 404);
        }

        Response::json([
            'status' => $device['status'],
            'phone' => $device['phone'],
            'qr_code' => $device['qr_code'],
            'session_ref' => $device['session_ref'],
        ]);
    }

    public function disconnect(Request $request, string $id): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        if ($request->validateCsrf()) {
            $tenantId = $this->auth->tenantId();
            $this->devices->disconnect($id, $tenantId);
            Response::withFlash('success', 'Perangkat WhatsApp berhasil diputuskan dari sesi gateway.', '/devices');
        }

        Response::redirect('/devices');
    }
}
