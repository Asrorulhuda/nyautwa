<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class BillingService {
    public function getPaymentMethods(): array {
        return Database::fetchAll("SELECT * FROM payment_methods WHERE is_active = 1 ORDER BY created_at ASC");
    }

    public function createInvoice(
        string $tenantId,
        int $amount,
        string $planId = 'starter',
        ?string $methodId = null,
        string $status = 'paid',
        ?string $notes = null
    ): array {
        $id = 'inv_' . bin2hex(random_bytes(8));
        $invoiceNo = 'INV/' . date('Ymd') . '/' . strtoupper(bin2hex(random_bytes(3)));
        $paidAt = ($status === 'paid') ? date('Y-m-d H:i:s') : null;

        Database::query(
            "INSERT INTO invoices (id, invoice_no, tenant_id, plan_id, amount, status, payment_method_id, paid_at, notes, created_at)
             VALUES (:id, :inv_no, :tid, :plan, :amt, :status, :pm_id, :paid_at, :notes, CURRENT_TIMESTAMP)",
            [
                'id' => $id,
                'inv_no' => $invoiceNo,
                'tid' => $tenantId,
                'plan' => $planId,
                'amt' => $amount,
                'status' => $status,
                'pm_id' => $methodId,
                'paid_at' => $paidAt,
                'notes' => $notes ?: "Pembayaran Berlangganan Paket " . ucfirst($planId),
            ]
        );

        return $this->getInvoice($id) ?? [];
    }

    public function getInvoice(string $id): ?array {
        $invoice = Database::fetchOne("SELECT * FROM invoices WHERE id = :id OR invoice_no = :inv", [
            'id' => $id,
            'inv' => $id,
        ]);
        if (!$invoice) {
            return null;
        }

        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :tid", ['tid' => $invoice['tenant_id']]);
        $owner = Database::fetchOne("SELECT name, email FROM users WHERE tenant_id = :tid LIMIT 1", ['tid' => $invoice['tenant_id']]);
        $method = Database::fetchOne("SELECT * FROM payment_methods WHERE id = :mid", ['mid' => $invoice['payment_method_id']]);

        $invoice['tenant'] = $tenant;
        $invoice['owner'] = $owner;
        $invoice['payment_method'] = $method;
        return $invoice;
    }

    public function getInvoicesForTenant(string $tenantId): array {
        return Database::fetchAll(
            "SELECT * FROM invoices WHERE tenant_id = :tid ORDER BY created_at DESC",
            ['tid' => $tenantId]
        );
    }
}
