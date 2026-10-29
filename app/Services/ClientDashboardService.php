<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ClientDashboardService {
    public function getMetrics(string $tenantId): array {
        $todayStart = date('Y-m-d 00:00:00');
        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $tenantId]);
        $planId = $tenant['plan_id'] ?? 'starter';
        
        $plan = (new PlanService())->getPlan($planId);
        $quota = (new QuotaService())->checkQuota($tenantId);

        $sentToday = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND created_at >= :t AND status IN ('sent','delivered','read')",
            ['tid' => $tenantId, 't' => $todayStart]
        )['c'] ?? 0);

        $failedToday = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND created_at >= :t AND status = 'failed'",
            ['tid' => $tenantId, 't' => $todayStart]
        )['c'] ?? 0);

        $queuedCount = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND status IN ('queued','pending')",
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

        $totalProcessed = $sentToday + $failedToday;
        $successRate = $totalProcessed > 0 ? round(($sentToday / $totalProcessed) * 100, 1) : null;

        return [
            'tenant' => $tenant,
            'plan_name' => $plan['name'] ?? ucfirst($planId),
            'message_limit' => $quota['limit'] ?? 10000,
            'sent_month' => $quota['sent_month'] ?? 0,
            'remaining_quota' => $quota['remaining'] ?? 0,
            'quota_percentage' => $quota['percentage'] ?? 0.0,
            'sent_today' => $sentToday,
            'failed_today' => $failedToday,
            'queued_count' => $queuedCount,
            'success_rate' => $successRate,
            'devices' => $devices,
            'total_devices' => count($devices),
            'connected_devices' => count($connectedDevices),
            'primary_device' => $primaryDevice,
            'recent_messages' => $recentMessages,
            'api_key' => $apiKey,
            'webhook' => $webhook,
            'chart_data' => (new ClientHourlyChartService())->getChartData($tenantId, $todayStart),
        ];
    }
}
