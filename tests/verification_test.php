<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Services\AuthService;
use App\Services\DeviceService;
use App\Services\MessageService;
use App\Services\ApiKeyService;

echo "=== NyautWa Verification Suite ===\n\n";

$testsPassed = 0;
$testsFailed = 0;

function assertCondition(string $name, bool $condition): void {
    global $testsPassed, $testsFailed;
    if ($condition) {
        echo " [PASS] $name\n";
        $testsPassed++;
    } else {
        echo " [FAIL] $name\n";
        $testsFailed++;
    }
}

// 1. Test Database Connectivity
$db = Database::getInstance()->getConnection();
assertCondition("Database connection initialized", $db instanceof PDO);

// 2. Test Seeded Plans
$plans = Database::fetchAll("SELECT * FROM plans");
assertCondition("Plans seeded properly (at least 3 tiers)", count($plans) >= 3);

// 3. Test AuthService Login
$auth = new AuthService();
$loginSuccess = $auth->attempt('admin@nyautwa.test', 'password123');
assertCondition("AuthService can authenticate admin user", $loginSuccess === true);
assertCondition("AuthService sets session user and tenant", !empty($_SESSION['tenant_id']));

// 4. Test DeviceService
$devicesService = new DeviceService();
$devices = $devicesService->getDevices($_SESSION['tenant_id']);
assertCondition("DeviceService returns tenant devices", count($devices) >= 1);

// 5. Test Phone Normalization
$msgService = new MessageService();
$norm1 = $msgService->normalizePhone('081234567890');
$norm2 = $msgService->normalizePhone('6285712345678');
$norm3 = $msgService->normalizePhone('+6289987654321');
assertCondition("Normalize 08... to +628...", $norm1 === '+6281234567890');
assertCondition("Normalize 628... to +628...", $norm2 === '+6285712345678');
assertCondition("Preserve +628...", $norm3 === '+6289987654321');

// 6. Test Message Queuing
$deviceId = $devices[0]['id'];
$queuedMsg = $msgService->queueMessage($_SESSION['tenant_id'], $deviceId, '081299887766', 'Test automated suite message');
assertCondition("Message queued successfully with ID", !empty($queuedMsg['id']));
assertCondition("Message destination normalized in DB", $queuedMsg['to_from'] === '+6281299887766');

// 7. Test ApiKeyService
$apiKeyService = new ApiKeyService();
$rawKey = 'nyaut_live_948f2178ad99e120';
$validatedTenant = $apiKeyService->validateRawKey($rawKey);
assertCondition("ApiKeyService validates known raw key", $validatedTenant !== null && $validatedTenant['id'] === 'tenant_demo_01');

echo "\n==================================\n";
echo "Ringkasan Hasil Uji: $testsPassed Lolos, $testsFailed Gagal.\n";

if ($testsFailed > 0) {
    exit(1);
}
echo "Seluruh verifikasi sistem NyautWa BERHASIL.\n";
