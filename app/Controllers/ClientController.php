<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Request, Response, View, Database};
use App\Services\{AuthService, ClientService, FeatureService, BillingService, PlanService, SubscriptionService, LandingSettingsService, MessageService};

class ClientController {
    private AuthService $auth;
    private ClientService $clients;

    public function __construct() {
        $this->auth = new AuthService();
        $this->clients = new ClientService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        View::render('clients/index', [
            'title' => 'Kelola Klien & Tenant SaaS',
            'clients' => $this->clients->getAll(),
            'plans' => (new PlanService())->getAvailablePlans(),
            'features' => (new FeatureService())->getAll(),
            'paymentMethods' => (new BillingService())->getPaymentMethods(),
        ], 'app');
    }

    public function create(Request $request): void {
        if (!$this->auth->check() || !$request->validateCsrf()) { Response::redirect('/clients'); return; }
        $name = trim((string)($request->post('name') ?: $request->post('username', '')));
        $email = trim((string)$request->post('email', ''));
        if (empty($name) || empty($email)) {
            Response::withFlash('error', 'Nama dan email wajib diisi.', '/clients'); return;
        }
        $this->clients->create($request->all());
        Response::withFlash('success', "Klien '{$name}' berhasil ditambahkan.", '/clients');
    }

    public function delete(Request $request, string $id): void {
        if (!$this->auth->check() || !$this->auth->isAdmin() || !$request->validateCsrf()) { Response::redirect('/clients'); return; }
        $this->clients->delete($id);
        Response::withFlash('success', 'Akun klien berhasil dihapus permanen.', '/clients');
    }

    public function update(Request $request, string $id): void {
        if (!$this->auth->check() || !$request->validateCsrf()) { Response::redirect('/clients'); return; }
        $this->clients->update($id, $request->all());
        Response::withFlash('success', 'Informasi klien berhasil diperbarui.', '/clients');
    }

    public function toggle(Request $request, string $id): void {
        if (!$this->auth->check() || !$request->validateCsrf()) { Response::redirect('/clients'); return; }
        $newStatus = $this->clients->toggleStatus($id);
        Response::withFlash('success', "Status akun klien: " . ($newStatus === 'active' ? 'diaktifkan' : 'ditangguhkan'), '/clients');
    }

    public function sendReminder(Request $request, string $id): void {
        if (!$this->auth->check() || !$request->validateCsrf()) { Response::redirect('/clients'); return; }
        $c = $this->clients->getById($id);
        if (!$c || empty($c['owner_phone'])) {
            Response::withFlash('error', 'Nomor WhatsApp klien belum terdaftar.', '/clients'); return;
        }
        $dev = Database::fetchOne("SELECT id FROM devices WHERE status = 'connected' LIMIT 1") ?? Database::fetchOne("SELECT id FROM devices LIMIT 1");
        if (!$dev) {
            Response::withFlash('error', 'Belum ada device WhatsApp yang terhubung.', '/clients'); return;
        }
        $sub = (new SubscriptionService())->getTenantSubscription($id);
        $tpl = (new LandingSettingsService())->getAll()['reminder_wa_template'] ?? '';
        $msg = str_replace(
            ['{nama}', '{paket}', '{sisa_hari}', '{tanggal_habis}', '{link_perpanjang}'],
            [$c['owner_name'] ?: $c['name'], $sub['plan_name'], (string)$sub['days_left'], $sub['ends_at'] ? date('d M Y', strtotime($sub['ends_at'])) : '-', rtrim(APP_URL, '/') . '/onboarding/plan'],
            $tpl
        );
        (new MessageService())->queueMessage($c['id'], $dev['id'], $c['owner_phone'], $msg);
        Response::withFlash('success', "Pengingat berhasil dikirim ke {$c['owner_phone']}.", '/clients');
    }
}
