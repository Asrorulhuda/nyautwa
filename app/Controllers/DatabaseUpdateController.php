<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
use App\Services\DatabaseUpdateService;

class DatabaseUpdateController {
    private AuthService $auth;

    public function __construct() {
        $this->auth = new AuthService();
    }

    public function update(Request $request): void {
        if (!$this->auth->check() || !$this->auth->isAdmin()) {
            Response::withFlash('error', 'Hanya administrator yang memiliki wewenang memperbarui database.', '/dashboard');
            return;
        }

        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi keamanan CSRF kedaluwarsa. Silakan muat ulang halaman.', '/dashboard');
            return;
        }

        try {
            $result = DatabaseUpdateService::runUpdate();
            Response::withFlash('success', 'Skema database berhasil diperbarui. ' . $result['message'], '/dashboard');
        } catch (\Throwable $e) {
            error_log("Database Update Failed: " . $e->getMessage());
            Response::withFlash('error', 'Pembaruan database gagal: ' . $e->getMessage(), '/dashboard');
        }
    }
}
