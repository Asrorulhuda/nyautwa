<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ClientDashboardService {
    public function getMetrics(string $tenantId): array {
        $todayStart = date('Y-m-d 00:00:00');
        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $tenantId]);
        $planId = $tenant['plan_id'] ?? 'starter';
        $plan = Database::fetchOne("SELECT * FROM plans WHERE id = :p", ['p' => $planId]);
        
        $limits = json_decode($plan['limits_json'] ?? '{"devices":1,"daily_messages":1000}', true);
        $dailyLimit = (int) ($limits['daily_messages'] ?? 1000);

        $sentToday = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND created_at >= :t AND status IN ('sent','delivered','read')",
            ['tid' => $tenantId, 't' => $todayStart]
        )['c'] ?? 0);

        $failedToday = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND created_at >= :t AND status = 'failed'",
            ['tid' => $tenantId, 't' => $todayStart]
        )['c'] ?? 0);

        $queuedCount = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND status = 'queued'",
            ['tid' => $tenantId]
        )['c'] ?? 0);

        $totalSentPeriod = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND status IN ('sent','delivered','read')",
            ['tid' => $tenantId]
        )['c'] ?? 0);

        $devices = Database::fetchAll("SELECT * FROM devices WHERE tenant_id = :tid ORDER BY created_at DESC", ['tid' => $tenantId]);
        $connectedDevices = array_filter($devices, fn($d) => $d['status'] === 'connected');
        $primaryDevice = $devices[0] ?? null;

        $recentMessages = Database::fetchAll(
            "SELECT * FROM messages WHERE tenant_id = :tid ORDER BY created_at DESC LIMIT 6",
            ['tid' => $tenantId]
        );

        $apiKey = Database::fetchOne("SELECT * FROM api_keys WHERE tenant_id = :tid AND revoked_at IS NULL ORDER BY created_at DESC LIMIT 1", ['tid' => $tenantId]);
        $webhook = Database::fetchOne("SELECT webhook_url FROM devices WHERE tenant_id = :tid AND webhook_url IS NOT NULL LIMIT 1", ['tid' => $tenantId]);

        $remainingQuota = max(0, $dailyLimit - $sentToday);
        $quotaPercentage = $dailyLimit > 0 ? min(100.0, round(($sentToday / $dailyLimit) * 100, 1)) : 0.0;
        $totalProcessed = $sentToday + $failedToday;
        $successRate = $totalProcessed > 0 ? round(($sentToday / $totalProcessed) * 100, 1) : 100.0;

        return [
            'tenant' => $tenant,
            'plan_name' => $plan['name'] ?? 'Starter',
            'daily_limit' => $dailyLimit,
            'sent_today' => $sentToday,
            'failed_today' => $failedToday,
            'queued_count' => $queuedCount,
            'total_sent_period' => $totalSentPeriod,
            'remaining_quota' => $remainingQuota,
            'quota_percentage' => $quotaPercentage,
            'success_rate' => $successRate,
            'devices' => $devices,
            'total_devices' => count($devices),
            'connected_devices' => count($connectedDevices),
            'primary_device' => $primaryDevice,
            'recent_messages' => $recentMessages,
            'api_key' => $apiKey,
            'webhook' => $webhook,
        ];
    }
}
