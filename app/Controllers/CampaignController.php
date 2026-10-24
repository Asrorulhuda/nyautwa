<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\CampaignService;
use App\Services\DeviceService;
use App\Services\ContactService;

class CampaignController {
    private AuthService $auth;
    private CampaignService $service;
    private DeviceService $devices;
    private ContactService $contacts;

    public function __construct() {
        $this->auth = new AuthService();
        $this->service = new CampaignService();
        $this->devices = new DeviceService();
        $this->contacts = new ContactService();
    }

    private function requireAuth(): string {
        if (!$this->auth->check()) {
            Response::redirect('/login');
            return '';
        }
        return $this->auth->tenantId();
    }

    public function index(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        View::render('campaigns/index', [
            'title' => 'Broadcast Massal (Campaign Blast)',
            'campaigns' => $this->service->getCampaigns($tenantId),
            'devices' => $this->devices->getDevices($tenantId),
            'tags' => $this->contacts->getTags($tenantId),
        ], 'app');
    }

    public function create(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi kedaluwarsa.', '/campaigns');
            return;
        }

        $name = trim((string) $request->input('name', ''));
        $deviceId = (string) $request->input('device_id', '');
        $message = trim((string) $request->input('message', ''));
        $rawReceivers = trim((string) $request->input('receivers', ''));
        $tagId = $request->input('tag_id');

        $recipients = array_filter(array_map('trim', explode("\n", $rawReceivers)));
        if (!empty($tagId)) {
            $tagContacts = $this->contacts->getContacts($tenantId, (string) $tagId);
            foreach ($tagContacts as $c) {
                $recipients[] = $c['phone'];
            }
        }
        $recipients = array_unique($recipients);

        if (empty($name) || empty($deviceId) || empty($message) || empty($recipients)) {
            Response::withFlash('error', 'Semua bidang wajib diisi termasuk minimal 1 nomor penerima.', '/campaigns');
            return;
        }

        $this->service->createCampaign($tenantId, [
            'name' => $name,
            'device_id' => $deviceId,
            'message' => $message,
            'type' => $request->input('type', 'text'),
            'media_url' => $request->input('media_url') ?: null,
            'delay_min' => (int) $request->input('delay_min', 5),
            'delay_max' => (int) $request->input('delay_max', 15),
        ], $recipients);

        Response::withFlash('success', 'Kampanye blast berhasil dibuat dan siap dikirim.', '/campaigns');
    }

    public function start(Request $request, string $id): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        $result = $this->service->executeBlast($id, $tenantId);
        if ($result['success']) {
            Response::withFlash('success', "Berhasil mengirim {$result['sent']} pesan. Sisa antrean: {$result['remaining']}", '/campaigns');
        } else {
            Response::withFlash('error', $result['error'] ?? 'Gagal menjalankan blast', '/campaigns');
        }
    }
}
