<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\LandingSettingsService;

class LandingConfigController {
    private AuthService $auth;

    public function __construct() {
        $this->auth = new AuthService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $service = new LandingSettingsService();
        $settings = $service->getAll();

        View::render('settings/landing/index', [
            'title' => 'Konfigurasi Landing Page',
            'settings' => $settings,
            'activeTab' => $request->get('tab', 'hero'),
        ], 'app');
    }

    public function update(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Token CSRF tidak valid. Silakan coba kembali.', '/settings/landing');
        }

        $postData = $request->all();
        unset($postData['_csrf_token'], $postData['_csrf']);

        $service = new LandingSettingsService();
        $service->updateBatch($postData, 'landing');

        $tab = $request->post('current_tab', 'hero');
        Response::withFlash('success', 'Konfigurasi landing page berhasil disimpan dan langsung aktif.', '/settings/landing?tab=' . urlencode($tab));
    }
}
