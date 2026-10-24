<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\ClientService;
use App\Services\FeatureService;
use App\Services\BillingService;

class ClientController {
    private AuthService $auth;
    private ClientService $clients;
    private FeatureService $features;
    private BillingService $billing;

    public function __construct() {
        $this->auth = new AuthService();
        $this->clients = new ClientService();
        $this->features = new FeatureService();
        $this->billing = new BillingService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        View::render('clients/index', [
            'title' => 'Kelola Klien & Tenant SaaS',
            'clients' => $this->clients->getAll(),
            'features' => $this->features->getAll(),
            'paymentMethods' => $this->billing->getPaymentMethods(),
        ], 'app');
    }

    public function create(Request $request): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        if (!$request->validateCsrf()) { Response::withFlash('error', 'Token CSRF tidak valid.', '/clients'); return; }

        $name = trim((string)($request->post('name') ?: $request->post('username', '')));
        $email = trim((string)$request->post('email', ''));

        if (empty($name) || empty($email)) {
            Response::withFlash('error', 'Nama pengguna dan email wajib diisi.', '/clients');
            return;
        }

        $this->clients->create($request->all());
        Response::withFlash('success', "Klien '{$name}' berhasil ditambahkan dan nota pembayaran otomatis diterbitkan.", '/clients');
    }

    public function delete(Request $request, string $id): void {
        if (!$this->auth->check() || !$this->auth->isAdmin()) {
            Response::withFlash('error', 'Hanya admin yang berhak menghapus klien.', '/clients');
            return;
        }
        if (!$request->validateCsrf()) { Response::withFlash('error', 'Token CSRF tidak valid.', '/clients'); return; }

        $this->clients->delete($id);
        Response::withFlash('success', 'Akun klien dan seluruh data terkait berhasil dihapus permanen.', '/clients');
    }

    public function update(Request $request, string $id): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        if (!$request->validateCsrf()) { Response::withFlash('error', 'Token CSRF tidak valid.', '/clients'); return; }

        $this->clients->update($id, $request->all());
        Response::withFlash('success', 'Informasi klien berhasil diperbarui.', '/clients');
    }

    public function toggle(Request $request, string $id): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        if (!$request->validateCsrf()) { Response::withFlash('error', 'Token CSRF tidak valid.', '/clients'); return; }

        $newStatus = $this->clients->toggleStatus($id);
        $statusLabel = ($newStatus === 'active') ? 'diaktifkan' : 'ditangguhkan (suspended)';
        Response::withFlash('success', "Status akun klien berhasil {$statusLabel}.", '/clients');
    }
}
