<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Database, Request, Response, View};
use App\Services\{AuthService, BillingService, PlanService, PaymentMethodService};

class OnboardingPlanController {
    private AuthService $auth;
    private PlanService $planService;
    private BillingService $billingService;

    public function __construct() {
        $this->auth = new AuthService();
        $this->planService = new PlanService();
        $this->billingService = new BillingService();
    }

    public function index(Request $request): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }

        $tenantId = $this->auth->tenantId();
        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $tenantId]);
        $plans = $this->planService->getAvailablePlans();
        $methods = (new PaymentMethodService())->getActive();

        View::render('onboarding/plan', [
            'title' => 'Pilih Paket Langganan — NyautWa Gateway',
            'plans' => $plans,
            'currentPlan' => $tenant['plan_id'] ?? 'trial',
            'tenant' => $tenant,
            'methods' => $methods,
        ], 'landing');
    }

    public function select(Request $request): void {
        if (!$this->auth->check()) { Response::redirect('/login'); return; }
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi Anda telah kedaluwarsa. Silakan muat ulang.', '/onboarding/plan'); return;
        }

        $planId = (string) $request->input('plan_id', 'trial');
        $plans = $this->planService->getAvailablePlans();
        if (!isset($plans[$planId])) {
            Response::withFlash('error', 'Paket langganan yang dipilih tidak valid.', '/onboarding/plan'); return;
        }

        $p = $plans[$planId];
        $tenantId = $this->auth->tenantId();

        if ($p['price'] <= 0) {
            $dur = (int)($p['duration_days'] ?? 7);
            $devs = (int)($p['devices'] ?? 1);
            $q = (int)(preg_replace('/[^0-9]/', '', (string)($p['quota'] ?? '200')) ?: 200);
            $subEnd = date('Y-m-d H:i:s', strtotime("+{$dur} days"));
            Database::query(
                "UPDATE tenants SET plan_id = 'trial', device_limit = :d, message_limit = :q, subscription_ends_at = :end, status = 'active', updated_at = CURRENT_TIMESTAMP WHERE id = :id",
                ['d' => $devs, 'q' => $q, 'end' => $subEnd, 'id' => $tenantId]
            );
            $_SESSION['plan_id'] = 'trial';
            Response::withFlash('success', 'Paket Free Trial aktif! Silakan scan QR untuk menghubungkan WhatsApp.', '/devices');
            return;
        }

        $pmId = (string)$request->input('payment_method_id', '');
        $invoice = $this->billingService->createInvoice(
            $tenantId, (int)$p['price'], $planId, $pmId ?: null, 'unpaid',
            "Tagihan Berlangganan Paket " . $p['name']
        );

        $invUrl = !empty($invoice['id']) ? '/invoices/' . $invoice['id'] : '/invoices';
        Response::withFlash('success', "Invoice Paket {$p['name']} berhasil diterbitkan. Silakan lakukan pembayaran dan unggah bukti transfer agar diverifikasi Admin.", $invUrl);
    }
}
