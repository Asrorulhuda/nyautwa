<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Services\FeatureService;
use App\Core\Database;

echo "=== NyautWa FeatureService Test ===\n\n";

$service = new FeatureService();

// 1. Get all features
$all = $service->getAll();
assert(count($all) >= 10, "Default features must be at least 10");
echo " [PASS] getAll returns " . count($all) . " features\n";

// 2. Add custom feature
$customCode = $service->create("Auto Broadcast Ramadan", "ramadan_broadcast");
assert($customCode === 'ramadan_broadcast', "Custom feature code matches");
echo " [PASS] create feature with custom code: $customCode\n";

// 3. Sync tenant features
$testTenantId = 'tenant_test_' . bin2hex(random_bytes(4));
$selected = ['wa_connection', 'webhooks', 'ramadan_broadcast'];
$service->syncTenantFeatures($testTenantId, $selected);

$tenantFeatures = $service->getTenantFeatures($testTenantId);
assert(count($tenantFeatures) === 3, "Tenant should have exactly 3 features enabled");
assert(in_array('wa_connection', $tenantFeatures), "Tenant has wa_connection enabled");
echo " [PASS] syncTenantFeatures works properly\n";

// Clean up
Database::query("DELETE FROM features WHERE code = 'ramadan_broadcast'");
Database::query("DELETE FROM tenant_features WHERE tenant_id = :tid", ['tid' => $testTenantId]);

echo "\nSELURUH PENGUJIAN FEATURESERVICE LOLOS 100%.\n";
