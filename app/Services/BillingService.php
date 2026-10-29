<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class BillingService {
    public function getPaymentMethods(): array {
        return (new PaymentMethodService())->getActive();
    }

    public function getAllInvoices(?string $status = null): array {
        $sql = "SELECT i.*, t.name as tenant_name, pm.name as method_name, u.name as owner_name, u.phone as owner_phone 
                FROM invoices i 
                LEFT JOIN tenants t ON i.tenant_id = t.id 
                LEFT JOIN payment_methods pm ON i.payment_method_id = pm.id 
                LEFT JOIN users u ON u.tenant_id = t.id";
        $params = [];
        if ($status && $status !== 'all') {
            $sql .= " WHERE i.status = :st";
            $params['st'] = $status;
        }
        $sql .= " ORDER BY i.created_at DESC";
        return Database::fetchAll($sql, $params);
    }

    public function createInvoice(string $tenantId, int $amount, string $planId = 'starter', ?string $methodId = null, string $status = 'paid', ?string $notes = null): array {
        $id = 'inv_' . bin2hex(random_bytes(8));
        $invoiceNo = 'INV/' . date('Ymd') . '/' . strtoupper(bin2hex(random_bytes(3)));
        $paidAt = ($status === 'paid') ? date('Y-m-d H:i:s') : null;

        Database::query(
            "INSERT INTO invoices (id, invoice_no, tenant_id, plan_id, amount, status, payment_method_id, paid_at, notes, created_at)
             VALUES (:id, :inv_no, :tid, :plan, :amt, :status, :pm_id, :paid_at, :notes, CURRENT_TIMESTAMP)",
            ['id' => $id, 'inv_no' => $invoiceNo, 'tid' => $tenantId, 'plan' => $planId, 'amt' => $amount, 'status' => $status, 'pm_id' => $methodId, 'paid_at' => $paidAt, 'notes' => $notes ?: "Langganan Paket " . ucfirst($planId)]
        );
        return $this->getInvoice($id) ?? [];
    }

    public function markAsPaid(string $id): bool {
        $inv = $this->getInvoice($id);
        if (!$inv) return false;
        Database::query("UPDATE invoices SET status = 'paid', paid_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $id]);
        $plan = (new PlanService())->getPlan($inv['plan_id'] ?? 'starter') ?? [];
        $dur = (int)($plan['duration_days'] ?? 30);
        $devs = (int)($plan['devices'] ?? 2);
        $q = (int)(preg_replace('/[^0-9]/', '', (string)($plan['quota'] ?? '10000')) ?: 10000);
        $endsAt = date('Y-m-d H:i:s', strtotime("+{$dur} days"));
        Database::query(
            "UPDATE tenants SET plan_id = :plan, device_limit = :devs, message_limit = :q, messages_used = 0, subscription_ends_at = :end, status = 'active', updated_at = CURRENT_TIMESTAMP WHERE id = :tid",
            ['plan' => $inv['plan_id'], 'devs' => $devs, 'q' => $q, 'end' => $endsAt, 'tid' => $inv['tenant_id']]
        );
        (new NotificationService())->notifyClientPaymentConfirmed($inv);
        return true;
    }

    public function getInvoice(string $id): ?array {
        $invoice = Database::fetchOne("SELECT * FROM invoices WHERE id = :id OR invoice_no = :inv", ['id' => $id, 'inv' => $id]);
        if (!$invoice) return null;
        $invoice['tenant'] = Database::fetchOne("SELECT * FROM tenants WHERE id = :tid", ['tid' => $invoice['tenant_id']]);
        $invoice['owner'] = Database::fetchOne("SELECT name, email, phone FROM users WHERE tenant_id = :tid LIMIT 1", ['tid' => $invoice['tenant_id']]);
        $invoice['payment_method'] = Database::fetchOne("SELECT * FROM payment_methods WHERE id = :mid", ['mid' => $invoice['payment_method_id']]);
        return $invoice;
    }

    public function getInvoicesForTenant(string $tenantId): array {
        return Database::fetchAll(
            "SELECT i.*, pm.name as method_name, pm.account_number, pm.account_name 
             FROM invoices i LEFT JOIN payment_methods pm ON i.payment_method_id = pm.id 
             WHERE i.tenant_id = :tid ORDER BY i.created_at DESC",
            ['tid' => $tenantId]
        );
    }

    public function saveProof(string $id, string $proofUrl): bool {
        Database::query("UPDATE invoices SET payment_proof = :proof WHERE id = :id", ['id' => $id, 'proof' => $proofUrl]);
        return true;
    }
}
