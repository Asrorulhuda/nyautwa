<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\DeviceService;
use App\Services\MessageService;

class MessageController {
    private AuthService $auth;
    private MessageService $messages;
    private DeviceService $devices;

    public function __construct() {
        $this->auth = new AuthService();
        $this->messages = new MessageService();
        $this->devices = new DeviceService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $tenantId = $this->auth->tenantId();
        $status = $request->input('status', 'all');
        $query = $request->input('q');

        $list = $this->messages->getMessages($tenantId, $status, $query);

        View::render('messages/index', [
            'title' => 'Riwayat Pengiriman Pesan (Outbox)',
            'messages' => $list,
            'currentStatus' => $status,
            'searchQuery' => $query,
        ], 'app');
    }

    public function create(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $tenantId = $this->auth->tenantId();
        $devices = $this->devices->getDevices($tenantId);

        View::render('messages/send', [
            'title' => 'Kirim Pesan WhatsApp Uji',
            'devices' => $devices,
        ], 'app');
    }

    public function send(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa.', '/messages/send');
        }

        $tenantId = $this->auth->tenantId();
        $deviceId = (string) $request->input('device_id', '');
        $phone = trim((string) $request->input('phone', ''));
        $body = trim((string) $request->input('body', ''));

        if (empty($deviceId) || empty($phone) || empty($body)) {
            Response::withFlash('error', 'Perangkat, nomor tujuan, dan pesan wajib diisi.', '/messages/send', $request->all());
        }

        $msg = $this->messages->queueMessage($tenantId, $deviceId, $phone, $body);

        Response::withFlash('success', "Pesan berhasil dimasukkan ke antrean gateway (ID: {$msg['id']}). Status: Terkirim.", '/messages');
    }
}
