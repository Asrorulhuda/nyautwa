<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\AutoReplyService;
use App\Services\DeviceService;

class AutoReplyController {
    use \App\Controllers\Concerns\HandlesAutoReplyMutations;

    public function __construct(
        private AuthService $auth = new AuthService(),
        private AutoReplyService $service = new AutoReplyService(),
        private DeviceService $devices = new DeviceService()
    ) {}

    private function requireAuth(): string {
        if (!$this->auth->check()) { Response::redirect('/login'); return ''; }
        return $this->auth->tenantId();
    }

    public function index(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if (!(new \App\Services\SubscriptionService())->canAccess($tenantId, 'autoreply')) {
            Response::withFlash('error', 'Fitur Balas Otomatis terkunci pada paket Anda. Silakan upgrade paket.', '/onboarding/plan');
            return;
        }
        View::render('autoreplies/index', [
            'title' => 'Balas Otomatis (Auto-Reply)',
            'replies' => $this->service->getAll($tenantId),
            'devices' => $this->devices->getDevices($tenantId),
        ], 'app');
    }

    public function delete(Request $request, ?string $id = null): void {
        $tenantId = $this->requireAuth();
        $id = $id ?? (string) $request->input('id', '');
        if ($tenantId && $request->validateCsrf() && !empty($id)) {
            $this->service->delete($id, $tenantId);
            Response::withFlash('success', 'Aturan balas otomatis berhasil dihapus.', '/autoreplies');
            return;
        }
        Response::redirect('/autoreplies');
    }

    public function deleteBulk(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi tidak sah atau kedaluwarsa.', '/autoreplies');
            return;
        }

        $ids = (array) ($request->input('ids') ?? []);
        if (empty($ids)) {
            Response::withFlash('error', 'Pilih minimal satu aturan yang ingin dihapus.', '/autoreplies');
            return;
        }

        $count = $this->service->deleteBulk($ids, $tenantId);
        Response::withFlash('success', "Berhasil menghapus {$count} aturan balas otomatis terpilih.", '/autoreplies');
    }

    public function deleteAll(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi tidak sah atau kedaluwarsa.', '/autoreplies');
            return;
        }

        $deviceId = $request->input('device_id') ?: null;
        $count = $this->service->deleteAll($tenantId, $deviceId);
        Response::withFlash('success', "Seluruh aturan balas otomatis ({$count} aturan) berhasil dibersihkan.", '/autoreplies');
    }

    public function toggle(Request $request, string $id): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi tidak valid atau kedaluwarsa.', '/autoreplies');
            return;
        }
        $this->service->toggle($id, $tenantId);
        Response::withFlash('success', 'Status balas otomatis berhasil diperbarui.', '/autoreplies');
    }
}
