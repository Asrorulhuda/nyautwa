<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ClientService {
    public function getAll(): array {
        $tenants = Database::fetchAll("SELECT * FROM tenants ORDER BY created_at DESC");
        $subService = new SubscriptionService();
        foreach ($tenants as &$t) {
            $tid = $t['id'];
            $u = Database::fetchOne("SELECT name, email, phone FROM users WHERE tenant_id = :tid LIMIT 1", ['tid' => $tid]);
            $t['owner_name'] = $u['name'] ?? '-';
            $t['owner_email'] = $u['email'] ?? '-';
            $t['owner_phone'] = $u['phone'] ?? '-';
            $sub = $subService->getTenantSubscription($tid);
            $t['days_left'] = $sub['days_left'];
            $t['expiry_status'] = $sub['status'];
            $t['plan_name'] = $sub['plan_name'];
            $t['latest_invoice_id'] = Database::fetchOne("SELECT id FROM invoices WHERE tenant_id = :tid ORDER BY created_at DESC LIMIT 1", ['tid' => $tid])['id'] ?? null;
        }
        return $tenants;
    }

    public function getById(string $id): ?array {
        $t = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $id]);
        if ($t) {
            $u = Database::fetchOne("SELECT name, email, phone FROM users WHERE tenant_id = :tid LIMIT 1", ['tid' => $id]);
            $t['owner_name'] = $u['name'] ?? '';
            $t['owner_email'] = $u['email'] ?? '';
            $t['owner_phone'] = $u['phone'] ?? '';
        }
        return $t;
    }

    public function create(array $d): string {
        $id = bin2hex(random_bytes(16));
        $name = trim($d['name'] ?? ($d['username'] ?? 'Klien Baru'));
        $planId = $d['plan_id'] ?? 'starter';
        $plans = (new PlanService())->getAvailablePlans();
        $plan = $plans[$planId] ?? ($plans['starter'] ?? []);
        $dur = (int)($d['duration_days'] ?? ($plan['duration_days'] ?? 30));
        $subEnd = !empty($d['subscription_ends_at']) ? $d['subscription_ends_at'] : date('Y-m-d H:i:s', strtotime("+{$dur} days"));

        Database::query("INSERT INTO tenants (id, name, plan_id, status, message_limit, device_limit, subscription_ends_at, role, created_at, updated_at) VALUES (:id, :name, :plan, :st, :mlim, :dlim, :sub_end, :role, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)", [
            'id' => $id, 'name' => $name, 'plan' => $planId, 'st' => $d['status'] ?? 'active', 'mlim' => (int)($d['message_limit'] ?? 1000), 'dlim' => (int)($d['device_limit'] ?? ($plan['devices'] ?? 2)), 'sub_end' => $subEnd, 'role' => $d['role'] ?? 'user'
        ]);

        if (!empty($d['email'])) {
            $rawPass = !empty($d['password']) ? (string)$d['password'] : bin2hex(random_bytes(8));
            $pass = password_hash($rawPass, PASSWORD_DEFAULT);
            Database::query("INSERT INTO users (id, tenant_id, name, email, phone, password_hash, role) VALUES (:uid, :tid, :name, :email, :phone, :pass, :role)", [
                'uid' => bin2hex(random_bytes(16)), 'tid' => $id, 'name' => trim($d['username'] ?? $name), 'email' => trim($d['email']), 'phone' => trim($d['phone'] ?? ''), 'pass' => $pass, 'role' => $d['role'] ?? 'user'
            ]);
        }

        if (!empty($d['features']) && is_array($d['features'])) {
            (new FeatureService())->syncTenantFeatures($id, $d['features']);
        }

        $price = (int)($plan['price'] ?? 149000);
        (new BillingService())->createInvoice($id, $price, $planId, $d['payment_method_id'] ?? null, 'paid');
        return $id;
    }

    public function delete(string $id): bool {
        $p = ['id' => $id];
        Database::query("DELETE FROM tenant_features WHERE tenant_id = :id", $p);
        Database::query("DELETE FROM messages WHERE tenant_id = :id", $p);
        Database::query("DELETE FROM devices WHERE tenant_id = :id", $p);
        Database::query("DELETE FROM api_keys WHERE tenant_id = :id", $p);
        Database::query("DELETE FROM invoices WHERE tenant_id = :id", $p);
        Database::query("DELETE FROM users WHERE tenant_id = :id", $p);
        Database::query("DELETE FROM tenants WHERE id = :id", $p);
        return true;
    }

    public function update(string $id, array $d): bool {
        $p = ['id' => $id, 'name' => trim((string)$d['name']), 'plan' => $d['plan_id'] ?? 'starter', 'st' => $d['status'] ?? 'active', 'dlim' => (int)($d['device_limit'] ?? 2), 'mlim' => (int)($d['message_limit'] ?? 1000)];
        $sql = "UPDATE tenants SET name = :name, plan_id = :plan, status = :st, device_limit = :dlim, message_limit = :mlim, updated_at = CURRENT_TIMESTAMP";
        if (!empty($d['subscription_ends_at'])) { $sql .= ", subscription_ends_at = :sub_end"; $p['sub_end'] = $d['subscription_ends_at']; }
        Database::query($sql . " WHERE id = :id", $p);
        if (isset($d['features']) && is_array($d['features'])) { (new FeatureService())->syncTenantFeatures($id, $d['features']); }
        return true;
    }

    public function toggleStatus(string $id): string {
        $t = $this->getById($id);
        if (!$t) return 'not_found';
        $newStatus = ($t['status'] === 'active') ? 'suspended' : 'active';
        Database::query("UPDATE tenants SET status = :st, updated_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $id, 'st' => $newStatus]);
        return $newStatus;
    }
}
