<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class QuotaService {
    public function checkQuota(string $tenantId): array {
        $tenant = Database::fetchOne("SELECT plan_id, message_limit, messages_used FROM tenants WHERE id = :id", ['id' => $tenantId]);
        $planId = $tenant['plan_id'] ?? 'starter';
        $monthlyLimit = (int) ($tenant['message_limit'] ?? 10000);

        $period = date('Y-m');
        $usage = Database::fetchOne("SELECT messages_out FROM usage_counters WHERE tenant_id = :tid AND period = :p", ['tid' => $tenantId, 'p' => $period]);
        if ($usage === null && (int) ($tenant['messages_used'] ?? 0) > 0) {
            Database::query("UPDATE tenants SET messages_used = 0 WHERE id = :tid", ['tid' => $tenantId]);
            $sentMonth = 0;
        } else {
            $sentMonth = $usage ? (int) $usage['messages_out'] : (int) ($tenant['messages_used'] ?? 0);
        }

        $todayStart = date('Y-m-d 00:00:00');
        $sentToday = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE tenant_id = :tid AND created_at >= :t AND status != 'failed'",
            ['tid' => $tenantId, 't' => $todayStart]
        )['c'] ?? 0);

        $dailyLimit = max(100, (int) round($monthlyLimit / 30));
        $isExceeded = ($monthlyLimit < 99999999) && ($sentMonth >= $monthlyLimit);

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
            $cur = (int) (Database::fetchOne("SELECT messages_used FROM tenants WHERE id = :tid", ['tid' => $tenantId])['messages_used'] ?? 0);
            Database::query(
                "INSERT INTO usage_counters (tenant_id, period, messages_out, api_calls, updated_at) VALUES (:tid, :p, :m, :a, CURRENT_TIMESTAMP)",
                ['tid' => $tenantId, 'p' => $period, 'm' => $messages + $cur, 'a' => $apiCalls]
            );
        }
        if ($messages > 0) {
            Database::query(
                "UPDATE tenants t INNER JOIN usage_counters u ON t.id = u.tenant_id AND u.period = :p SET t.messages_used = u.messages_out WHERE t.id = :tid",
                ['p' => $period, 'tid' => $tenantId]
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
