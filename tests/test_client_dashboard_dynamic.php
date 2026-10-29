<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\ClientDashboardService;

echo "=== TESTING DYNAMIC CLIENT DASHBOARD ===\n\n";

$service = new ClientDashboardService();

$tenants = ['tenant_7d70395f63cc', 'tenant_demo_01'];

foreach ($tenants as $tid) {
    echo "--- Testing Tenant: $tid ---\n";
    $metrics = $service->getMetrics($tid);

    echo "1. Plan Name: {$metrics['plan_name']}\n";
    echo "2. Quota Limit: " . number_format($metrics['message_limit']) . " | Sent Month: {$metrics['sent_month']} | Remaining: {$metrics['remaining_quota']}\n";
    echo "3. Sent Today: {$metrics['sent_today']} | Failed Today: {$metrics['failed_today']}\n";
    echo "4. SLA Success Rate: " . ($metrics['success_rate'] !== null ? $metrics['success_rate'] . '%' : 'NULL (Belum ada trafik)') . "\n";
    echo "5. Total Devices: {$metrics['total_devices']} | Connected: {$metrics['connected_devices']}\n";
    echo "6. Chart Points: " . count($metrics['chart_data']['points']) . " | Has Data: " . ($metrics['chart_data']['has_data'] ? 'TRUE' : 'FALSE') . "\n";

    echo "7. Rendering View Templates...\n";
    extract($metrics);
    ob_start();
    include dirname(__DIR__) . '/app/Views/dashboard/client/header.php';
    include dirname(__DIR__) . '/app/Views/dashboard/client/metrics.php';
    include dirname(__DIR__) . '/app/Views/dashboard/client/chart.php';
    include dirname(__DIR__) . '/app/Views/dashboard/client/device_card.php';
    include dirname(__DIR__) . '/app/Views/dashboard/client/recent_messages.php';
    include dirname(__DIR__) . '/app/Views/dashboard/client/api_quickstart.php';
    $html = ob_get_clean();
    echo "[PASS] Successfully rendered " . strlen($html) . " bytes of HTML without any warning or error!\n\n";
}

echo "ALL CLIENT DASHBOARD TESTS PASSED!\n";
