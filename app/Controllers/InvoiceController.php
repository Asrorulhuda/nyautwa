<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\BillingService;
use App\Services\ProofUploadService;
use App\Services\NotificationService;
use App\Services\SubscriptionService;

class InvoiceController {
    private AuthService $auth;
    private BillingService $billing;

    public function __construct() {
        $this->auth = new AuthService();
        $this->billing = new BillingService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        $tenantId = $this->auth->tenantId();
        $invoices = $this->billing->getInvoicesForTenant($tenantId);
        $sub = (new SubscriptionService())->getTenantSubscription($tenantId);

        View::render('invoices/index', [
            'title' => 'Riwayat Pembayaran & Tagihan',
            'invoices' => $invoices,
            'subscription' => $sub,
        ], 'app');
    }

    public function show(Request $request, string $id): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        $invoice = $this->billing->getInvoice($id);
        if (!$invoice) { Response::withFlash('error', 'Nota pembayaran tidak ditemukan.', '/invoices'); return; }

        if (!$this->auth->isAdmin() && $invoice['tenant_id'] !== $this->auth->tenantId()) {
            Response::withFlash('error', 'Anda tidak memiliki hak akses ke nota ini.', '/dashboard'); return;
        }

        View::render('invoices/show', [
            'title' => 'Nota Pembayaran ' . $invoice['invoice_no'],
            'invoice' => $invoice,
            'adminPhone' => (new \App\Services\LandingSettingsService())->getAll()['footer_contact_phone'] ?? '',
        ], 'app');
    }

    public function uploadProof(Request $request, string $id): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        if (!$request->validateCsrf()) { Response::withFlash('error', 'Token CSRF tidak valid.', "/invoices/{$id}"); return; }

        $invoice = $this->billing->getInvoice($id);
        if (!$invoice) { Response::withFlash('error', 'Invoice tidak ditemukan.', '/invoices'); return; }
        if (!$this->auth->isAdmin() && $invoice['tenant_id'] !== $this->auth->tenantId()) {
            Response::withFlash('error', 'Anda tidak memiliki hak akses ke invoice ini.', '/dashboard'); return;
        }

        $proofUrl = ProofUploadService::handle($_FILES['proof'] ?? null);
        $redirectUrl = (string)($request->post('redirect_to') ?: "/invoices/{$id}");
        if (!$proofUrl) {
            Response::withFlash('error', 'Gagal mengunggah bukti. Format harus JPG, PNG, WEBP, atau PDF (maks 5MB).', $redirectUrl); return;
        }

        $this->billing->saveProof($id, $proofUrl);
        (new NotificationService())->notifyAdminPaymentProof($invoice, $proofUrl);
        Response::withFlash('success', 'Bukti pembayaran berhasil diunggah! Notifikasi otomatis telah dikirim ke WhatsApp Admin.', $redirectUrl);
    }
}
