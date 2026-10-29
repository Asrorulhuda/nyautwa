<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\ChatService;
use App\Services\ContactService;
use App\Services\DeviceService;
use App\Services\QuotaService;

class ChatController {
    public function __construct(
        private AuthService $auth = new AuthService(),
        private ChatService $chat = new ChatService(),
        private DeviceService $devices = new DeviceService(),
        private ContactService $contacts = new ContactService()
    ) {}

    private function requireAuth(): string {
        if (!$this->auth->check()) { Response::redirect('/login'); return ''; }
        return $this->auth->tenantId();
    }

    public function index(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if (!(new \App\Services\SubscriptionService())->canAccess($tenantId, 'crm')) {
            Response::withFlash('error', 'Fitur Live Chat CRM terkunci pada paket Anda. Silakan upgrade paket.', '/onboarding/plan');
            return;
        }
        $selDev = (string) ($request->input('device') ?? '');
        $selContact = (string) ($request->input('contact') ?? '');
        $convs = $this->chat->getConversations($tenantId, $selDev ?: null);
        $actContact = $selContact ?: (!empty($convs) ? $convs[0]['to_from'] : '');
        View::render('chat/index', [
            'title' => 'Live Chat & CRM Pelanggan', 'devices' => $this->devices->getDevices($tenantId),
            'selectedDevice' => $selDev, 'conversations' => $convs, 'contacts' => $this->contacts->getContacts($tenantId),
            'activeContact' => $actContact, 'activeContactData' => !empty($actContact) ? $this->chat->getContactByPhone($tenantId, $actContact) : null,
            'activeMessages' => !empty($actContact) ? $this->chat->getMessages($tenantId, $actContact) : [],
        ], 'app');
    }

    public function apiConversations(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        $list = $this->chat->getConversations($tenantId, (string) ($request->input('device') ?: null));
        Response::json(['success' => true, 'conversations' => $list]);
    }

    public function apiMessages(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        $c = trim((string) ($request->input('contact') ?? ''));
        Response::json(['success' => true, 'contact' => $c, 'messages' => !empty($c) ? $this->chat->getMessages($tenantId, $c) : []]);
    }

    private function uploadFile(): ?array {
        if (empty($_FILES['media']['tmp_name']) || $_FILES['media']['error'] !== UPLOAD_ERR_OK) return null;
        $name = $_FILES['media']['name'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp','pdf','doc','docx','xls','xlsx','zip','txt'], true)) return null;
        $dir = dirname(__DIR__, 2) . '/public/uploads/chat';
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $fn = bin2hex(random_bytes(8)) . '.' . $ext;
        if (!move_uploaded_file($_FILES['media']['tmp_name'], $dir . '/' . $fn)) return null;
        return ['type' => in_array($ext, ['jpg','jpeg','png','webp'], true) ? 'image' : 'document', 'url' => '/uploads/chat/' . $fn, 'name' => $name];
    }

    public function apiSend(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) { Response::json(['success' => false, 'error' => 'Sesi tidak sah.'], 403); return; }
        $did = trim((string) ($request->input('device_id') ?? ''));
        $to = trim((string) ($request->input('to') ?? ''));
        $msg = trim((string) ($request->input('message') ?? ''));
        $up = $this->uploadFile();
        if (empty($did) || empty($to) || (empty($msg) && empty($up))) { Response::json(['success' => false, 'error' => 'Perangkat, nomor tujuan, dan pesan/file wajib diisi.'], 422); return; }
        if (!(new QuotaService())->checkQuota($tenantId)['allowed']) { Response::json(['success' => false, 'error' => 'Kuota pesan bulan ini sudah habis.'], 402); return; }
        $res = $this->chat->sendReply($tenantId, $did, $to, $msg ?: ($up['name'] ?? 'Lampiran'), $up['type'] ?? 'text', $up['url'] ?? null, $up['name'] ?? null);
        Response::json($res, $res['success'] ? 200 : 400);
    }

    public function apiToggleAutoreply(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) { Response::json(['success' => false, 'error' => 'Sesi tidak sah.'], 403); return; }
        $phone = trim((string) ($request->input('phone') ?? ''));
        $active = (bool) ($request->input('active') ?? false);
        Response::json($this->chat->toggleAutoreply($tenantId, $phone, $active));
    }
}
