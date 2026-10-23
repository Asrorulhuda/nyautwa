<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\DashboardService;

class DashboardController {
    private AuthService $auth;
    private DashboardService $dashboard;

    public function __construct() {
        $this->auth = new AuthService();
        $this->dashboard = new DashboardService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        $tenantId = $this->auth->tenantId();
        $data = $this->dashboard->getMetrics($tenantId);

        View::render('dashboard/index', array_merge($data, [
            'title' => 'Ringkasan Operasional Gateway',
        ]), 'app');
    }
}
