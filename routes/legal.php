<?php

declare(strict_types=1);

/** @var \App\Core\Router $router */

$router->get('/terms', [\App\Controllers\LegalController::class, 'terms']);
$router->get('/privacy', [\App\Controllers\LegalController::class, 'privacy']);
$router->get('/sla', [\App\Controllers\LegalController::class, 'sla']);
$router->get('/contact', [\App\Controllers\LegalController::class, 'contact']);
$router->post('/contact', [\App\Controllers\LegalController::class, 'submitContact']);

// Onboarding & Pemilihan Paket Langganan Pasca Pendaftaran
$router->get('/onboarding/plan', [\App\Controllers\OnboardingPlanController::class, 'index']);
$router->post('/onboarding/plan', [\App\Controllers\OnboardingPlanController::class, 'select']);

