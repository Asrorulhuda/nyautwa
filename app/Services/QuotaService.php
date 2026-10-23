<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class QuotaService {
    public function checkQuota(string $tenantId): array {
        $tenant = Database::fetchOne("SELECT plan_id FROM tenants WHERE id = :id", ['id' => $tenantId]);
        $planId = $tenant['plan_id'] ?? 'starter';
        $plan = Database::fetchOne("SELECT limits_json FROM plans WHERE id = :id", ['id' => $planId]);
        $limits = json_decode($plan['limits_json'] ?? '{}', true);

        $monthlyLimit = (int) ($limits['monthly_messages'] ?? 5000);
        $dailyLimit = (int) ($limits['daily_messages'] ?? 500);
        $monthStart = date('Y-m-01 00:00:00');
        $todayStart = date('Y-m-d 00:00:00');

        $sentMonth = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND created_at >= :t AND status != 'failed'",
            ['tid' => $tenantId, 't' => $monthStart]
        )['c'] ?? 0);

        $sentToday = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND created_at >= :t AND status != 'failed'",
            ['tid' => $tenantId, 't' => $todayStart]
        )['c'] ?? 0);

        $isExceeded = ($sentMonth >= $monthlyLimit) || ($sentToday >= $dailyLimit);
        return [
            'allowed' => !$isExceeded,
            'plan_id' => $planId,
            'monthly_limit' => $monthlyLimit,
            'sent_month' => $sentMonth,
            'remaining_month' => max(0, $monthlyLimit - $sentMonth),
            'daily_limit' => $dailyLimit,
            'sent_today' => $sentToday,
            'remaining_today' => max(0, $dailyLimit - $sentToday),
        ];
    }

    public function recordUsage(string $tenantId, int $messages = 1, int $apiCalls = 1): void {
        $period = date('Y-m');
        $existing = Database::fetchOne(
            "SELECT tenant_id FROM usage_counters WHERE tenant_id = :tid AND period = :p",
            ['tid' => $tenantId, 'p' => $period]
        );
        if ($existing) {
            Database::query(
                "UPDATE usage_counters SET messages_out = messages_out + :m, api_calls = api_calls + :a, updated_at = CURRENT_TIMESTAMP WHERE tenant_id = :tid AND period = :p",
                ['m' => $messages, 'a' => $apiCalls, 'tid' => $tenantId, 'p' => $period]
            );
        } else {
            Database::query(
                "INSERT INTO usage_counters (tenant_id, period, messages_out, api_calls, updated_at) VALUES (:tid, :p, :m, :a, CURRENT_TIMESTAMP)",
                ['tid' => $tenantId, 'p' => $period, 'm' => $messages, 'a' => $apiCalls]
            );
        }
    }

    public function getRateLimitInfo(string $tenantId): array {
        $tenant = Database::fetchOne("SELECT plan_id FROM tenants WHERE id = :id", ['id' => $tenantId]);
        $plan = Database::fetchOne("SELECT limits_json FROM plans WHERE id = :id", ['id' => $tenant['plan_id'] ?? 'starter']);
        $limits = json_decode($plan['limits_json'] ?? '{}', true);
        $rpm = (int) ($limits['api_rpm'] ?? 120);

        return [
            'limit' => $rpm,
            'remaining' => max(1, $rpm - 1),
            'reset' => time() + 60,
        ];
    }
}
