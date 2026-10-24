<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
use App\Services\FeatureService;

class FeatureController {
    private AuthService $auth;
    private FeatureService $features;

    public function __construct() {
        $this->auth = new AuthService();
        $this->features = new FeatureService();
    }

    public function create(Request $request): void {
        if (!$this->auth->check() || !$this->auth->isAdmin()) {
            Response::withFlash('error', 'Hanya administrator yang dapat menambah fitur baru.', '/login');
            return;
        }
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form telah kedaluwarsa.', '/clients');
            return;
        }

        $name = trim((string)$request->input('name', ''));
        $code = trim((string)$request->input('code', ''));

        if (empty($name)) {
            Response::withFlash('error', 'Nama fitur wajib diisi.', '/clients');
            return;
        }

        $createdCode = $this->features->create($name, $code ?: null);
        Response::withFlash('success', "Fitur '{$name}' (kode: {$createdCode}) berhasil ditambahkan ke katalog sistem.", '/clients');
    }
}
