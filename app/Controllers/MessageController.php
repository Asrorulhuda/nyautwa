<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\Concerns\InteractsWithMessagePayload;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\DeviceService;
use App\Services\MessageService;
use App\Services\QuotaService;

class MessageController {
    use InteractsWithMessagePayload;

    private AuthService $auth;
    private MessageService $messages;
    private DeviceService $devices;

    public function __construct() {
        $this->auth = new AuthService();
        $this->messages = new MessageService();
        $this->devices = new DeviceService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) Response::redirect('/login');
        $tenantId = $this->auth->tenantId();
        $status = $request->input('status', 'all');
        $query = $request->input('q');
        View::render('messages/index', [
            'title' => 'Riwayat Pengiriman Pesan (Outbox)',
            'messages' => $this->messages->getMessages($tenantId, $status, $query),
            'currentStatus' => $status,
            'searchQuery' => $query,
        ], 'app');
    }

    public function create(Request $request): void {
        if (!$this->auth->check()) Response::redirect('/login');
        $tenantId = $this->auth->tenantId();
        if (!(new \App\Services\SubscriptionService())->canAccess($tenantId, 'send_message')) {
            Response::withFlash('error', 'Fitur Kirim Pesan terkunci pada paket Anda. Silakan upgrade paket.', '/onboarding/plan');
            return;
        }
        View::render('messages/send', ['title' => 'Kirim Pesan WhatsApp Uji', 'devices' => $this->devices->getDevices($tenantId)], 'app');
    }

    public function send(Request $request): void {
        if (!$this->auth->check()) Response::redirect('/login');
        if (!$request->validateCsrf()) Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa.', '/messages/send');

        $tenantId = $this->auth->tenantId();
        if (!(new QuotaService())->checkQuota($tenantId)['allowed']) {
            Response::withFlash('error', 'Kuota pesan bulan ini sudah habis. Silakan upgrade paket untuk melanjutkan pengiriman.', '/messages/send');
        }
        $devId = (string) $request->input('device_id', '');
        $phone = trim((string) $request->input('phone', ''));
        $type = (string) $request->input('type', 'text');
        $body = trim((string) $request->input('body', ''));
        $extra = $this->buildExtraPayload($request, $type, $body);
        unset($extra['is_system']);

        if (empty($devId) || empty($phone) || (empty($body) && empty($extra['url']) && empty($extra['question']))) {
            Response::withFlash('error', 'Perangkat, nomor tujuan, dan pesan wajib diisi.', '/messages/send', $request->all());
        }

        $msg = $this->messages->queueMessage($tenantId, $devId, $phone, $body, $type, $extra);
        if (($msg['status'] ?? '') === 'sent') {
            Response::withFlash('success', "Pesan ({$type}) berhasil dikirim langsung ke WhatsApp {$phone}!", '/messages');
        } else {
            $err = $msg['engine_response']['error'] ?? 'Perangkat belum terhubung atau Baileys offline.';
            Response::withFlash('error', "Gagal transmisi pesan: {$err}", '/messages/send', $request->all());
        }
    }

    public function delete(Request $request, string $id = ''): void {
        if (!$this->auth->check()) Response::redirect('/login');
        $msgId = !empty($id) ? $id : (string) $request->input('id', '');
        if ($request->validateCsrf() && !empty($msgId)) {
            $this->messages->deleteMessage($msgId, $this->auth->tenantId());
            Response::withFlash('success', 'Pesan berhasil dihapus dari riwayat.', '/messages');
        }
        Response::redirect('/messages');
    }

    public function deleteBulk(Request $request): void {
        if (!$this->auth->check()) Response::redirect('/login');
        if ($request->validateCsrf()) {
            $rawIds = (array) $request->input('ids', []);
            $count = $this->messages->deleteBulkMessages($rawIds, $this->auth->tenantId());
            Response::withFlash('success', "Sebanyak {$count} riwayat pesan berhasil dihapus.", '/messages');
        }
        Response::redirect('/messages');
    }
}
