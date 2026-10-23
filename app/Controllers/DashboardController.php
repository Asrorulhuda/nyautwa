<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\AdminDashboardService;
use App\Services\ClientDashboardService;

class DashboardController {
    private AuthService $auth;

    public function __construct() {
        $this->auth = new AuthService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
        }

        if ($this->auth->isAdmin()) {
            $adminService = new AdminDashboardService();
            $data = $adminService->getMetrics();
            View::render('dashboard/admin/index', array_merge($data, [
                'title' => 'Dashboard Platform SaaS — NyautWa',
                'isAdmin' => true,
            ]), 'app');
            return;
        }

        $tenantId = $this->auth->tenantId();
        $clientService = new ClientDashboardService();
        $data = $clientService->getMetrics($tenantId);

        View::render('dashboard/client/index', array_merge($data, [
            'title' => 'Workspace WhatsApp — NyautWa',
            'isAdmin' => false,
        ]), 'app');
    }
}

