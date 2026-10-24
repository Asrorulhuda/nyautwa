<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ClientService {
    public function getAll(): array {
        $tenants = Database::fetchAll("SELECT * FROM tenants ORDER BY created_at DESC");
        foreach ($tenants as &$t) {
            $tid = $t['id'];
            $u = Database::fetchOne("SELECT name, email FROM users WHERE tenant_id = :tid LIMIT 1", ['tid' => $tid]);
            $t['owner_name'] = $u['name'] ?? '-';
            $t['owner_email'] = $u['email'] ?? '-';
            $t['device_count'] = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM devices WHERE tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
            $t['message_count'] = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
            $inv = Database::fetchOne("SELECT id FROM invoices WHERE tenant_id = :tid ORDER BY created_at DESC LIMIT 1", ['tid' => $tid]);
            $t['latest_invoice_id'] = $inv['id'] ?? null;
        }
        return $tenants;
    }

    public function getById(string $id): ?array {
        return Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $id]);
    }

    public function create(array $d): string {
        $id = bin2hex(random_bytes(16));
        $name = trim($d['name'] ?? ($d['username'] ?? 'Klien Baru'));
        $plan = $d['plan_id'] ?? 'starter';
        $status = in_array($d['status'] ?? '', ['active', 'inactive', 'trial'], true) ? $d['status'] : 'active';
        $role = in_array($d['role'] ?? '', ['admin', 'reseller', 'user'], true) ? $d['role'] : 'user';

        Database::query(
            "INSERT INTO tenants (id, name, plan_id, status, message_limit, device_limit, subscription_ends_at, role, created_at, updated_at)
             VALUES (:id, :name, :plan, :st, :mlim, :dlim, :sub_end, :role, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
            [
                'id' => $id, 'name' => $name, 'plan' => $plan, 'st' => $status,
                'mlim' => (int)($d['message_limit'] ?? 1000), 'dlim' => (int)($d['device_limit'] ?? 1),
                'sub_end' => !empty($d['subscription_ends_at']) ? $d['subscription_ends_at'] : null, 'role' => $role,
            ]
        );

        if (!empty($d['email'])) {
            $pass = password_hash($d['password'] ?? 'password123', PASSWORD_DEFAULT);
            Database::query(
                "INSERT INTO users (id, tenant_id, name, email, password_hash, role) VALUES (:uid, :tid, :name, :email, :pass, :role)",
                ['uid' => bin2hex(random_bytes(16)), 'tid' => $id, 'name' => trim($d['username'] ?? $name), 'email' => trim($d['email']), 'pass' => $pass, 'role' => $role]
            );
        }

        if (!empty($d['features']) && is_array($d['features'])) {
            (new FeatureService())->syncTenantFeatures($id, $d['features']);
        }

        $price = match($plan) { 'pro' => 150000, 'business', 'enterprise' => 500000, default => 50000 };
        (new BillingService())->createInvoice($id, $price, $plan, $d['payment_method_id'] ?? 'bca_transfer', 'paid');
        return $id;
    }

    public function delete(string $id): bool {
        Database::query("DELETE FROM tenant_features WHERE tenant_id = :id", ['id' => $id]);
        Database::query("DELETE FROM messages WHERE tenant_id = :id", ['id' => $id]);
        Database::query("DELETE FROM devices WHERE tenant_id = :id", ['id' => $id]);
        Database::query("DELETE FROM api_keys WHERE tenant_id = :id", ['id' => $id]);
        Database::query("DELETE FROM invoices WHERE tenant_id = :id", ['id' => $id]);
        Database::query("DELETE FROM users WHERE tenant_id = :id", ['id' => $id]);
        Database::query("DELETE FROM tenants WHERE id = :id", ['id' => $id]);
        return true;
    }

    public function update(string $id, array $d): bool {
        return Database::execute(
            "UPDATE tenants SET name = :name, plan_id = :plan, status = :st, updated_at = CURRENT_TIMESTAMP WHERE id = :id",
            ['id' => $id, 'name' => trim($d['name']), 'plan' => $d['plan_id'], 'st' => $d['status']]
        );
    }

    public function toggleStatus(string $id): string {
        $t = $this->getById($id);
        if (!$t) return 'not_found';
        $newStatus = ($t['status'] === 'active') ? 'suspended' : 'active';
        Database::query("UPDATE tenants SET status = :st, updated_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $id, 'st' => $newStatus]);
        return $newStatus;
    }
}
