<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class SidebarQuotaService {
    public function getSidebarData(?string $tenantId, bool $isAdmin): array {
        if ($isAdmin || empty($tenantId)) {
            return $this->getAdminQuotaData();
        }
        return $this->getClientQuotaData($tenantId);
    }

    private function getAdminQuotaData(): array {
        $monthStart = date('Y-m-01 00:00:00');
        $sentMonth = (int) (Database::fetchOne(
            "SELECT COUNT(*) as c FROM messages WHERE status IN ('sent','delivered','read') AND created_at >= :t",
            ['t' => $monthStart]
        )['c'] ?? 0);

        return [
            'label' => 'Trafik Pesan Global',
            'sent' => $sentMonth,
            'limit' => 0,
            'limit_formatted' => 'Unlimited',
            'percentage' => 100.0,
            'percentage_text' => 'Bulan Ini',
            'plan_name' => 'SaaS Master',
            'is_unlimited' => true,
        ];
    }

    private function getClientQuotaData(string $tenantId): array {
        $monthStart = date('Y-m-01 00:00:00');
        $tenant = Database::fetchOne(
            "SELECT id, plan_id, message_limit, messages_used FROM tenants WHERE id = :id",
            ['id' => $tenantId]
        );

        $planService = new PlanService();
        $planId = $tenant['plan_id'] ?? 'starter';
        $plan = $planService->getPlan($planId) ?? ['name' => ucfirst($planId), 'quota_num' => 10000];

        $limit = (int) ($tenant['message_limit'] ?? 0);
        if ($limit <= 0) {
            $limit = (int) ($plan['quota_num'] ?? 10000);
        }

        $sentMonth = (int) ($tenant['messages_used'] ?? 0);
        $isUnlimited = ($limit >= 99999999);
        $pct = $limit > 0 ? min(100.0, round(($sentMonth / $limit) * 100, 1)) : 0.0;

        return [
            'label' => 'Kuota Pesan',
            'sent' => $sentMonth,
            'limit' => $limit,
            'limit_formatted' => $isUnlimited ? 'Unlimited' : number_format($limit, 0, ',', '.'),
            'percentage' => $isUnlimited ? min(100.0, $sentMonth > 0 ? 10.0 : 0.0) : $pct,
            'percentage_text' => $isUnlimited ? 'Aktif' : $pct . '% terpakai',
            'plan_name' => $plan['name'] ?? ucfirst($planId),
            'is_unlimited' => $isUnlimited,
        ];
    }
}
