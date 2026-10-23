<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\ClientService;

class ClientController {
    private AuthService $auth;
    private ClientService $clients;

    public function __construct() {
        $this->auth = new AuthService();
        $this->clients = new ClientService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $clients = $this->clients->getAll();

        View::render('clients/index', [
            'title' => 'Kelola Klien & Tenant SaaS',
            'clients' => $clients,
        ], 'app');
    }

    public function create(Request $request): void {
        if (!$this->auth->check()) Response::redirect('/login');
        if (!$request->validateCsrf()) Response::withFlash('error', 'Token CSRF tidak valid.', '/clients');

        $name = trim((string)$request->post('name', ''));
        if (empty($name)) Response::withFlash('error', 'Nama perusahaan atau klien wajib diisi.', '/clients');

        $this->clients->create($request->all());
        Response::withFlash('success', "Klien {$name} berhasil ditambahkan ke sistem.", '/clients');
    }

    public function update(Request $request, string $id): void {
        if (!$this->auth->check()) Response::redirect('/login');
        if (!$request->validateCsrf()) Response::withFlash('error', 'Token CSRF tidak valid.', '/clients');

        $this->clients->update($id, $request->all());
        Response::withFlash('success', 'Informasi klien berhasil diperbarui.', '/clients');
    }

    public function toggle(Request $request, string $id): void {
        if (!$this->auth->check()) Response::redirect('/login');
        if (!$request->validateCsrf()) Response::withFlash('error', 'Token CSRF tidak valid.', '/clients');

        $newStatus = $this->clients->toggleStatus($id);
        $statusLabel = ($newStatus === 'active') ? 'diaktifkan' : 'ditangguhkan (suspended)';
        Response::withFlash('success', "Status akun klien berhasil {$statusLabel}.", '/clients');
    }
}
