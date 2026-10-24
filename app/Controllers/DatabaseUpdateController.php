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
            if ($request->isJson() || $request->header('x-requested-with') === 'XMLHttpRequest') {
                Response::json(['error' => 'Akses ditolak: Hanya administrator yang dapat memperbarui database.'], 403);
                return;
            }
            Response::withFlash('error', 'Hanya administrator yang memiliki wewenang memperbarui database.', '/dashboard');
            return;
        }

        if (!$request->validateCsrf()) {
            if ($request->isJson() || $request->header('x-requested-with') === 'XMLHttpRequest') {
                Response::json(['error' => 'Token CSRF tidak valid atau telah kedaluwarsa.'], 419);
                return;
            }
            Response::withFlash('error', 'Sesi keamanan CSRF kedaluwarsa. Silakan muat ulang halaman.', '/dashboard');
            return;
        }

        try {
            $result = DatabaseUpdateService::runUpdate();
            $_SESSION['db_update_result'] = $result;

            if ($request->isJson() || $request->header('x-requested-with') === 'XMLHttpRequest') {
                Response::json([
                    'success' => true,
                    'message' => $result['message'],
                    'changes' => $result['changes'],
                    'updated_at' => $result['updated_at'],
                ]);
                return;
            }

            Response::withFlash('success', 'Skema database berhasil diperbarui. ' . $result['message'], '/dashboard');
        } catch (\Throwable $e) {
            error_log("Database Update Failed: " . $e->getMessage());
            if ($request->isJson() || $request->header('x-requested-with') === 'XMLHttpRequest') {
                Response::json(['error' => 'Pembaruan gagal: ' . $e->getMessage()], 500);
                return;
            }
            Response::withFlash('error', 'Pembaruan database gagal: ' . $e->getMessage(), '/dashboard');
        }
    }
}
