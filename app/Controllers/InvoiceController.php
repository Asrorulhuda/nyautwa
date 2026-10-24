<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\BillingService;

class InvoiceController {
    private AuthService $auth;
    private BillingService $billing;

    public function __construct() {
        $this->auth = new AuthService();
        $this->billing = new BillingService();
    }

    public function show(Request $request, string $id): void {
        if (!$this->auth->check()) {
            Response::redirect('/login');
            return;
        }

        $invoice = $this->billing->getInvoice($id);
        if (!$invoice) {
            Response::withFlash('error', 'Nota pembayaran tidak ditemukan.', '/clients');
            return;
        }

        if (!$this->auth->isAdmin() && $invoice['tenant_id'] !== $this->auth->tenantId()) {
            Response::withFlash('error', 'Anda tidak memiliki hak akses ke nota ini.', '/dashboard');
            return;
        }

        View::render('invoices/show', [
            'title' => 'Nota Pembayaran ' . $invoice['invoice_no'],
            'invoice' => $invoice,
        ], 'app');
    }
}
