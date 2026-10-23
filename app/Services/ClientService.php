<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ClientService {
    public function getAll(): array {
        $tenants = Database::fetchAll("SELECT * FROM tenants ORDER BY created_at DESC");
        foreach ($tenants as &$t) {
            $tid = $t['id'];
            $user = Database::fetchOne("SELECT name, email FROM users WHERE tenant_id = :tid LIMIT 1", ['tid' => $tid]);
            $t['owner_name'] = $user['name'] ?? '-';
            $t['owner_email'] = $user['email'] ?? '-';
            $t['device_count'] = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM devices WHERE tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
            $t['message_count'] = (int)(Database::fetchOne("SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid", ['tid' => $tid])['c'] ?? 0);
        }
        return $tenants;
    }

    public function getById(string $id): ?array {
        return Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $id]);
    }

    public function create(array $data): string {
        $id = bin2hex(random_bytes(16));
        $name = trim($data['name'] ?? 'Klien Baru');
        $planId = $data['plan_id'] ?? 'starter';
        Database::query(
            "INSERT INTO tenants (id, name, plan_id, status, created_at, updated_at) VALUES (:id, :name, :plan, 'active', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
            ['id' => $id, 'name' => $name, 'plan' => $planId]
        );

        if (!empty($data['email'])) {
            $userId = bin2hex(random_bytes(16));
            $userEmail = trim($data['email']);
            $userName = trim($data['owner_name'] ?? $name);
            $passHash = password_hash($data['password'] ?? 'password123', PASSWORD_BCRYPT);
            Database::query(
                "INSERT INTO users (id, tenant_id, name, email, password_hash, role) VALUES (:uid, :tid, :name, :email, :pass, 'client')",
                ['uid' => $userId, 'tid' => $id, 'name' => $userName, 'email' => $userEmail, 'pass' => $passHash]
            );
        }
        return $id;
    }

    public function update(string $id, array $data): bool {
        return Database::execute(
            "UPDATE tenants SET name = :name, plan_id = :plan, status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id",
            ['id' => $id, 'name' => trim($data['name']), 'plan' => $data['plan_id'], 'status' => $data['status']]
        );
    }

    public function toggleStatus(string $id): string {
        $tenant = $this->getById($id);
        if (!$tenant) return 'not_found';
        $newStatus = ($tenant['status'] === 'active') ? 'suspended' : 'active';
        Database::query("UPDATE tenants SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id", [
            'id' => $id, 'status' => $newStatus
        ]);
        return $newStatus;
    }
}
