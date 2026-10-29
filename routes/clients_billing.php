<?php

declare(strict_types=1);

/** @var \App\Core\Router $router */

// SaaS Client Management & Subscription Actions
$router->get('/clients', [\App\Controllers\ClientController::class, 'index']);
$router->post('/clients/create', [\App\Controllers\ClientController::class, 'create']);
$router->post('/clients/{id}', [\App\Controllers\ClientController::class, 'update']);
$router->post('/clients/{id}/toggle', [\App\Controllers\ClientController::class, 'toggle']);
$router->post('/clients/{id}/delete', [\App\Controllers\ClientController::class, 'delete']);
$router->post('/clients/{id}/send-reminder', [\App\Controllers\ClientController::class, 'sendReminder']);

// Billing & Payments
$router->get('/billing', [\App\Controllers\BillingController::class, 'index']);
$router->post('/billing/invoices/create', [\App\Controllers\BillingController::class, 'createInvoice']);
$router->post('/billing/invoices/{id}/pay', [\App\Controllers\BillingController::class, 'markPaid']);
$router->post('/billing/invoices/{id}/send-wa', [\App\Controllers\BillingController::class, 'sendInvoiceWa']);
$router->post('/billing/methods/save', [\App\Controllers\BillingController::class, 'saveMethod']);
$router->post('/billing/methods/{id}/toggle', [\App\Controllers\BillingController::class, 'toggleMethod']);
$router->post('/billing/methods/{id}/delete', [\App\Controllers\BillingController::class, 'deleteMethod']);

// Invoices & Features
$router->post('/features/create', [\App\Controllers\FeatureController::class, 'create']);
$router->get('/invoices', [\App\Controllers\InvoiceController::class, 'index']);
$router->get('/invoices/{id}', [\App\Controllers\InvoiceController::class, 'show']);
$router->post('/invoices/{id}/proof', [\App\Controllers\InvoiceController::class, 'uploadProof']);
