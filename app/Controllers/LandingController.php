<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;

class LandingController {
    public function index(Request $request): void {
        View::render('landing/index', [
            'title' => 'WhatsApp Gateway SaaS untuk Developer & Bisnis Indonesia',
        ], 'landing');
    }
}
