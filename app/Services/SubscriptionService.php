<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class SubscriptionService {
    private PlanService $planService;

    public function __construct() {
        $this->planService = new PlanService();
    }

    public function canAccess(string $tenantId, string $module): bool {
        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $tenantId]);
        if (!$tenant) return false;
        if (($tenant['role'] ?? '') === 'admin' || $tenantId === 'system') return true;
        if (($tenant['status'] ?? '') === 'suspended') return false;

        $now = time();
        if (!empty($tenant['subscription_ends_at']) && strtotime($tenant['subscription_ends_at']) < $now) {
            return false;
        }

        $override = Database::fetchOne(
            "SELECT enabled FROM tenant_features WHERE tenant_id = :tid AND feature_code = :f",
            ['tid' => $tenantId, 'f' => $module]
        );
        if ($override !== null) {
            return (bool) $override['enabled'];
        }

        $plans = $this->planService->getAvailablePlans();
        $plan = $plans[$tenant['plan_id'] ?? 'trial'] ?? $plans['trial'] ?? null;
        return (bool) ($plan['modules'][$module] ?? false);
    }

    public function getTenantSubscription(string $tenantId): array {
        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $tenantId]) ?: [];
        $endsAt = $tenant['subscription_ends_at'] ?? null;
        $now = time();

        $daysLeft = null;
        $status = 'active';

        if (!empty($endsAt)) {
            $endTs = strtotime($endsAt);
            $diffSecs = $endTs - $now;
            $daysLeft = (int) ceil($diffSecs / 86400);

            if ($diffSecs < 0) {
                $status = 'expired';
                $daysLeft = 0;
            } elseif ($daysLeft <= 3) {
                $status = 'expiring_soon';
            }
        }

        $plans = $this->planService->getAvailablePlans();
        $plan = $plans[$tenant['plan_id'] ?? 'trial'] ?? ($plans['trial'] ?? []);

        return [
            'tenant' => $tenant,
            'plan' => $plan,
            'plan_name' => $plan['name'] ?? ucfirst($tenant['plan_id'] ?? 'Trial'),
            'status' => $status,
            'days_left' => $daysLeft,
            'ends_at' => $endsAt,
            'modules' => $plan['modules'] ?? [],
        ];
    }

    public function renewSubscription(string $tenantId, int $durationDays): void {
        $endsAt = date('Y-m-d H:i:s', strtotime("+{$durationDays} days"));
        Database::query(
            "UPDATE tenants SET status = 'active', subscription_ends_at = :end, updated_at = CURRENT_TIMESTAMP WHERE id = :id",
            ['id' => $tenantId, 'end' => $endsAt]
        );
    }
}
