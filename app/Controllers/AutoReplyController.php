<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\AutoReplyService;

class AutoReplyController {
    private AuthService $auth;
    private AutoReplyService $service;

    public function __construct() {
        $this->auth = new AuthService();
        $this->service = new AutoReplyService();
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
        View::render('autoreplies/index', [
            'title' => 'Balas Otomatis (Auto-Reply)',
            'replies' => $this->service->getAll($tenantId),
        ], 'app');
    }

    public function create(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi kedaluwarsa.', '/autoreplies');
            return;
        }

        $keyword = trim((string) $request->input('keyword', ''));
        $response = trim((string) $request->input('response', ''));
        if (empty($keyword) || empty($response)) {
            Response::withFlash('error', 'Kata kunci dan pesan balasan wajib diisi.', '/autoreplies');
            return;
        }

        $this->service->create($tenantId, [
            'keyword' => $keyword,
            'match_type' => $request->input('match_type', 'contain'),
            'type' => $request->input('type', 'text'),
            'response' => $response,
            'media_url' => $request->input('media_url') ?: null,
            'delay_seconds' => (int) $request->input('delay_seconds', 1),
        ]);

        Response::withFlash('success', 'Aturan balas otomatis berhasil ditambahkan.', '/autoreplies');
    }

    public function delete(Request $request, string $id): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if ($request->validateCsrf()) {
            $this->service->delete($id, $tenantId);
            Response::withFlash('success', 'Aturan balas otomatis berhasil dihapus.', '/autoreplies');
            return;
        }
        Response::redirect('/autoreplies');
    }

    public function toggle(Request $request, string $id): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        $this->service->toggle($id, $tenantId);
        Response::withFlash('success', 'Status balas otomatis berhasil diperbarui.', '/autoreplies');
    }
}
