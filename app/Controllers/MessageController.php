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
        View::render('messages/send', [
            'title' => 'Kirim Pesan WhatsApp Uji',
            'devices' => $this->devices->getDevices($this->auth->tenantId()),
        ], 'app');
    }

    public function send(Request $request): void {
        if (!$this->auth->check()) Response::redirect('/login');
        if (!$request->validateCsrf()) Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa.', '/messages/send');

        $tenantId = $this->auth->tenantId();
        $devId = (string) $request->input('device_id', '');
        $phone = trim((string) $request->input('phone', ''));
        $type = (string) $request->input('type', 'text');
        $body = trim((string) $request->input('body', ''));
        $extra = $this->buildExtraPayload($request, $type, $body);

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

    private function buildExtraPayload(Request $req, string $type, string &$body): array {
        if ($type === 'image') return ['url' => trim((string)$req->input('media_url', '')), 'caption' => $body];
        if ($type === 'document') {
            return ['url' => trim((string)$req->input('doc_url', '')), 'filename' => trim((string)$req->input('filename', 'dokumen.pdf')), 'caption' => $body];
        }
        if ($type === 'poll') {
            $q = trim((string)$req->input('poll_question', $body));
            $body = $q;
            $opts = array_values(array_filter(array_map('trim', explode("\n", (string)$req->input('poll_options', '')))));
            return ['question' => $q, 'options' => count($opts) >= 2 ? $opts : ['Pilihan 1', 'Pilihan 2']];
        }
        if ($type === 'button') {
            $raw = array_values(array_filter(array_map('trim', explode("\n", (string)$req->input('buttons_list', '')))));
            return ['buttons' => count($raw) > 0 ? $raw : ['Pilihan Ya', 'Pilihan Tidak'], 'footer' => (string)$req->input('footer_text', 'NyautWa Gateway')];
        }
        return [];
    }
}
