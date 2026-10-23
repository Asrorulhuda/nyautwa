<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class DeviceService {
    public function getDevices(string $tenantId): array {
        return Database::fetchAll(
            "SELECT * FROM devices WHERE tenant_id = :tenant_id ORDER BY created_at DESC",
            ['tenant_id' => $tenantId]
        );
    }

    public function find(string $id, string $tenantId): ?array {
        return Database::fetchOne(
            "SELECT * FROM devices WHERE id = :id AND tenant_id = :tenant_id",
            ['id' => $id, 'tenant_id' => $tenantId]
        );
    }

    public function createDevice(string $tenantId, string $label, ?string $webhookUrl = null, int $dailyLimit = 1000): array {
        $id = 'dev_' . bin2hex(random_bytes(6));
        $sessionRef = 'sess_' . bin2hex(random_bytes(8));

        Database::query(
            "INSERT INTO devices (id, tenant_id, label, status, session_ref, webhook_url, daily_limit) VALUES (:id, :tenant_id, :label, 'qr_ready', :session_ref, :webhook_url, :daily_limit)",
            [
                'id' => $id,
                'tenant_id' => $tenantId,
                'label' => $label,
                'session_ref' => $sessionRef,
                'webhook_url' => $webhookUrl,
                'daily_limit' => $dailyLimit,
            ]
        );

        return $this->find($id, $tenantId);
    }

    public function disconnect(string $id, string $tenantId): bool {
        return Database::execute(
            "UPDATE devices SET status = 'disconnected', phone = NULL WHERE id = :id AND tenant_id = :tenant_id",
            ['id' => $id, 'tenant_id' => $tenantId]
        );
    }

    public function updateStatus(string $id, string $status, ?string $phone = null): void {
        $params = ['id' => $id, 'status' => $status];
        $sql = "UPDATE devices SET status = :status";
        if ($phone !== null) {
            $sql .= ", phone = :phone";
            $params['phone'] = $phone;
        }
        $sql .= " WHERE id = :id";
        Database::query($sql, $params);
    }
}
