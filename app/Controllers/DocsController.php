<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;

class DocsController {
    private AuthService $auth;

    public function __construct() {
        $this->auth = new AuthService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $tenantId = $this->auth->tenantId();
        $apiKey = Database::fetchOne(
            "SELECT prefix FROM api_keys WHERE tenant_id = :tid AND revoked_at IS NULL ORDER BY created_at DESC LIMIT 1",
            ['tid' => $tenantId]
        );
        $device = Database::fetchOne(
            "SELECT id, label, phone FROM devices WHERE tenant_id = :tid ORDER BY created_at DESC LIMIT 1",
            ['tid' => $tenantId]
        );

        View::render('docs/index', [
            'title' => 'Dokumentasi REST API v1 — NyautWa',
            'apiKeyPrefix' => $apiKey['prefix'] ?? 'nyaut_live',
            'sampleDeviceId' => $device['id'] ?? 'dev_01H9A9X78M21',
            'samplePhone' => $device['phone'] ?? '+6281234567890',
        ], 'app');
    }

    public function downloadPdf(Request $request): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        $target = dirname(__DIR__, 2) . '/public/Panduan-Integrasi-NyautWa.pdf';
        if (!file_exists($target)) {
            $content = (new \App\Services\PdfService())->generateIntegrationPdf();
            file_put_contents($target, $content);
        } else {
            $content = (string) file_get_contents($target);
        }
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Panduan-Integrasi-NyautWa.pdf"');
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit;
    }
}

