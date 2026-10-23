<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class DashboardService {
    public function getMetrics(string $tenantId): array {
        // Total sent messages today
        $todayStart = date('Y-m-d 00:00:00');
        $sentCount = Database::fetchOne(
            "SELECT COUNT(*) as count FROM messages WHERE tenant_id = :tenant_id AND status IN ('sent', 'delivered', 'read')",
            ['tenant_id' => $tenantId]
        )['count'] ?? 0;

        $failedCount = Database::fetchOne(
            "SELECT COUNT(*) as count FROM messages WHERE tenant_id = :tenant_id AND status = 'failed'",
            ['tenant_id' => $tenantId]
        )['count'] ?? 0;

        $queuedCount = Database::fetchOne(
            "SELECT COUNT(*) as count FROM messages WHERE tenant_id = :tenant_id AND status = 'queued'",
            ['tenant_id' => $tenantId]
        )['count'] ?? 0;

        $devices = Database::fetchAll(
            "SELECT * FROM devices WHERE tenant_id = :tenant_id ORDER BY created_at DESC",
            ['tenant_id' => $tenantId]
        );

        $connectedDevices = array_filter($devices, fn($d) => $d['status'] === 'connected');

        $recentMessages = Database::fetchAll(
            "SELECT * FROM messages WHERE tenant_id = :tenant_id ORDER BY created_at DESC LIMIT 6",
            ['tenant_id' => $tenantId]
        );

        $primaryDevice = $devices[0] ?? null;

        return [
            'sent_today' => (int) $sentCount,
            'failed_today' => (int) $failedCount,
            'queued_count' => (int) $queuedCount,
            'total_devices' => count($devices),
            'connected_devices' => count($connectedDevices),
            'daily_limit' => $primaryDevice['daily_limit'] ?? 5000,
            'primary_device' => $primaryDevice,
            'recent_messages' => $recentMessages,
        ];
    }
}
