<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\SidebarQuotaService;

$svc = new SidebarQuotaService();

echo "=== TEST ADMIN SIDEBAR QUOTA ===\n";
$adminData = $svc->getSidebarData(null, true);
print_r($adminData);

echo "\n=== ALL TENANTS IN DB ===\n";
$tenants = \App\Core\Database::fetchAll("SELECT id, name, plan_id, device_limit, message_limit FROM tenants");
print_r($tenants);

echo "\n=== TEST CLIENT (PT Teknologi Berkah Indonesia - tenant_demo_01) ===\n";
$demoData = $svc->getSidebarData('tenant_demo_01', false);
print_r($demoData);
