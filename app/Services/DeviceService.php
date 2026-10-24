<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class DeviceService {
    private EngineService $engine;

    public function __construct() {
        $this->engine = new EngineService();
    }

    public function getDevices(string $tenantId): array {
        return Database::fetchAll("SELECT * FROM devices WHERE tenant_id = :tenant_id ORDER BY created_at DESC", ['tenant_id' => $tenantId]);
    }

    public function find(string $id, string $tenantId): ?array {
        return Database::fetchOne("SELECT * FROM devices WHERE id = :id AND tenant_id = :tenant_id", ['id' => $id, 'tenant_id' => $tenantId]);
    }

    public function createDevice(string $tenantId, string $label, ?string $phone = null, ?string $webhookUrl = null, int $dailyLimit = 1000): ?array {
        $id = 'dev_' . bin2hex(random_bytes(6));
        $sessionRef = 'sess_' . bin2hex(random_bytes(8));
        $whSecret = 'whsec_' . bin2hex(random_bytes(16));

        Database::query(
            "INSERT INTO devices (id, tenant_id, label, phone, status, session_ref, webhook_url, webhook_secret, daily_limit) 
             VALUES (:id, :tenant_id, :label, :phone, 'pending_qr', :session_ref, :webhook_url, :webhook_secret, :daily_limit)",
            ['id' => $id, 'tenant_id' => $tenantId, 'label' => $label, 'phone' => $phone, 'session_ref' => $sessionRef, 'webhook_url' => $webhookUrl, 'webhook_secret' => $whSecret, 'daily_limit' => $dailyLimit]
        );

        return $this->find($id, $tenantId);
    }

    public function getLiveQr(string $id, string $tenantId): array {
        $device = $this->find($id, $tenantId);
        return $device ? $this->engine->startSession($device['session_ref']) : ['success' => false, 'error' => 'Perangkat tidak ditemukan'];
    }

    public function requestPairingCode(string $id, string $tenantId, string $phone): array {
        $device = $this->find($id, $tenantId);
        return $device ? $this->engine->requestPairingCode($device['session_ref'], $phone) : ['success' => false, 'error' => 'Perangkat tidak ditemukan'];
    }

    public function disconnect(string $id, string $tenantId): bool {
        $device = $this->find($id, $tenantId);
        if ($device) {
            try { $this->engine->logout($device['session_ref']); } catch (\Throwable) {}
        }
        return Database::execute("UPDATE devices SET status = 'disconnected', phone = NULL WHERE id = :id AND tenant_id = :tenant_id", ['id' => $id, 'tenant_id' => $tenantId]);
    }

    public function deleteDevice(string $id, string $tenantId): bool {
        $device = $this->find($id, $tenantId);
        if ($device) {
            try { $this->engine->logout($device['session_ref']); } catch (\Throwable) {}
        }
        return Database::execute("DELETE FROM devices WHERE id = :id AND tenant_id = :tenant_id", ['id' => $id, 'tenant_id' => $tenantId]);
    }

    public function updateStatus(string $id, string $status, ?string $phone = null): void {
        $params = ['id' => $id, 'status' => $status];
        $sql = "UPDATE devices SET status = :status" . ($phone !== null ? ", phone = :phone" : "") . " WHERE id = :id";
        if ($phone !== null) $params['phone'] = $phone;
        Database::query($sql, $params);
    }
}
