<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Services\LandingSettingsService;

class LandingController {
    public function index(Request $request): void {
        $settingsService = new LandingSettingsService();
        $settings = $settingsService->getAll();

        View::render('landing/index', [
            'title' => 'WhatsApp Gateway SaaS untuk Developer & Bisnis Indonesia',
            'settings' => $settings,
        ], 'landing');
    }
}
