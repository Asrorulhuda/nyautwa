<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Request, Response, View, Database};
use App\Services\{AuthService, BillingService, PaymentMethodService, PlanService, MessageService};

class BillingController {
    private AuthService $auth;
    private BillingService $billing;
    private PaymentMethodService $methods;

    public function __construct() {
        $this->auth = new AuthService();
        $this->billing = new BillingService();
        $this->methods = new PaymentMethodService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check() || !$this->auth->isAdmin()) { Response::redirect('/login'); return; }
        $tab = $request->get('tab', 'invoices');
        $status = $request->get('status', 'all');
        View::render('billing/index', [
            'title' => 'Billing & Pembayaran',
            'tab' => $tab,
            'status' => $status,
            'invoices' => $this->billing->getAllInvoices($status),
            'methods' => $this->methods->getAll(),
            'plans' => (new PlanService())->getAvailablePlans(),
            'tenants' => Database::fetchAll("SELECT id, name FROM tenants ORDER BY name ASC"),
        ], 'app');
    }

    public function createInvoice(Request $request): void {
        if (!$this->auth->check() || !$this->auth->isAdmin() || !$request->validateCsrf()) { Response::redirect('/billing'); return; }
        $tid = (string)$request->post('tenant_id', '');
        $amt = (int)$request->post('amount', 0);
        $plan = (string)$request->post('plan_id', 'starter');
        $mid = (string)$request->post('payment_method_id', '');
        $st = (string)$request->post('status', 'unpaid');
        $this->billing->createInvoice($tid, $amt, $plan, $mid ?: null, $st, (string)$request->post('notes', ''));
        Response::withFlash('success', 'Invoice baru berhasil diterbitkan.', '/billing');
    }

    public function markPaid(Request $request, string $id): void {
        if (!$this->auth->check() || !$this->auth->isAdmin() || !$request->validateCsrf()) { Response::redirect('/billing'); return; }
        $this->billing->markAsPaid($id);
        Response::withFlash('success', 'Invoice berhasil ditandai Lunas dan masa aktif klien diperpanjang.', '/billing');
    }

    public function sendInvoiceWa(Request $request, string $id): void {
        if (!$this->auth->check() || !$this->auth->isAdmin() || !$request->validateCsrf()) { Response::redirect('/billing'); return; }
        $inv = $this->billing->getInvoice($id);
        if (!$inv || empty($inv['owner']['phone'])) {
            Response::withFlash('error', 'Klien tidak ditemukan atau tidak memiliki nomor WhatsApp.', '/billing'); return;
        }
        $dev = Database::fetchOne("SELECT id FROM devices WHERE status = 'connected' LIMIT 1") ?? Database::fetchOne("SELECT id FROM devices LIMIT 1");
        if (!$dev) { Response::withFlash('error', 'Tidak ada device WhatsApp yang terhubung.', '/billing'); return; }
        $msg = "Halo *{$inv['owner']['name']}*,\n\nBerikut informasi tagihan langganan NyautWa Anda:\n- No. Invoice: *{$inv['invoice_no']}*\n- Paket: *{$inv['plan_id']}*\n- Total: *Rp " . number_format((float)$inv['amount'], 0, ',', '.') . "*\n- Status: *" . strtoupper($inv['status']) . "*\n\nLihat & unduh nota pembayaran di:\n" . rtrim(APP_URL, '/') . "/invoices/{$inv['id']}\n\nTerima kasih atas kerja samanya!";
        (new MessageService())->queueMessage($inv['tenant_id'], $dev['id'], $inv['owner']['phone'], $msg);
        Response::withFlash('success', "Tagihan berhasil dikirim ke WhatsApp {$inv['owner']['phone']}.", '/billing');
    }

    public function saveMethod(Request $request): void {
        if (!$this->auth->check() || !$this->auth->isAdmin() || !$request->validateCsrf()) { Response::redirect('/billing?tab=methods'); return; }
        $this->methods->save($request->all());
        Response::withFlash('success', 'Metode pembayaran berhasil disimpan.', '/billing?tab=methods');
    }

    public function toggleMethod(Request $request, string $id): void {
        if (!$this->auth->check() || !$this->auth->isAdmin() || !$request->validateCsrf()) { Response::redirect('/billing?tab=methods'); return; }
        $this->methods->toggle($id);
        Response::withFlash('success', 'Status metode pembayaran berhasil diperbarui.', '/billing?tab=methods');
    }

    public function deleteMethod(Request $request, string $id): void {
        if (!$this->auth->check() || !$this->auth->isAdmin() || !$request->validateCsrf()) { Response::redirect('/billing?tab=methods'); return; }
        $this->methods->delete($id);
        Response::withFlash('success', 'Metode pembayaran berhasil dihapus.', '/billing?tab=methods');
    }
}
