<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Services\QuotaService;
use App\Services\MessageService;

$tenantId = 'tenant_demo_01';
$quota = new QuotaService();
$msgService = new MessageService();
$period = date('Y-m');

echo "=== STARTING COMPREHENSIVE QUOTA FIX VERIFICATION ===\n\n";

// 1. Initial State Reset
Database::query("UPDATE usage_counters SET messages_out = 10, api_calls = 0 WHERE tenant_id = :id AND period = :p", ['id' => $tenantId, 'p' => $period]);
Database::query("UPDATE tenants SET messages_used = 10, message_limit = 100 WHERE id = :id", ['id' => $tenantId]);
$q1 = $quota->checkQuota($tenantId);
assert($q1['sent_month'] === 10, "Initial sent_month must be 10");
echo "[PASS] 1. Initial state confirmed (sent_month: {$q1['sent_month']})\n";

// 2. Normal Outbound Message Usage (+1)
$quota->recordUsage($tenantId, 1, 0);
$q2 = $quota->checkQuota($tenantId);
assert($q2['sent_month'] === 11, "Sent month must increment to 11");
echo "[PASS] 2. Normal outbound message incremented quota (+1 => {$q2['sent_month']})\n";

// 3. System Notification Exemption (Must NOT consume quota)
$dev = Database::fetchOne("SELECT id FROM devices WHERE tenant_id = :tid LIMIT 1", ['tid' => $tenantId]);
$devId = $dev['id'] ?? 'dev_01';
// queueMessage with is_system => true
$simulatedMsg = $msgService->queueMessage($tenantId, $devId, '08123456789', 'System test notification', 'text', ['is_system' => true]);
$q3 = $quota->checkQuota($tenantId);
assert($q3['sent_month'] === 11, "System notification must NOT increment quota (still 11)");
echo "[PASS] 3. System notification exempted from quota (sent_month remains: {$q3['sent_month']})\n";

// 4. Delete Message Log (Must NOT reset or reduce quota)
Database::query("DELETE FROM messages WHERE tenant_id = :id", ['id' => $tenantId]);
$q4 = $quota->checkQuota($tenantId);
assert($q4['sent_month'] === 11, "Deleting messages must NOT reset quota (still 11)");
echo "[PASS] 4. Clear message logs did NOT reset or reduce quota (still 11)\n";

// 5. Test sync_messages_used.php script
require dirname(__DIR__) . '/scripts/sync_messages_used.php';
$tAfterSync = Database::fetchOne("SELECT messages_used FROM tenants WHERE id = :id", ['id' => $tenantId]);
assert((int)$tAfterSync['messages_used'] === 11, "sync_messages_used must preserve quota from usage_counters");
echo "[PASS] 5. sync_messages_used preserved quota from audit ledger (messages_used: {$tAfterSync['messages_used']})\n";

// 6. Quota exhaustion and blocking
Database::query("UPDATE usage_counters SET messages_out = 100 WHERE tenant_id = :id AND period = :p", ['id' => $tenantId, 'p' => $period]);
$q5 = $quota->checkQuota($tenantId);
assert($q5['allowed'] === false, "checkQuota must block when sent_month reaches message_limit (100)");
echo "[PASS] 6. Quota check strictly blocked sending when limit reached (allowed: false)\n";

echo "\n>>> ALL 6 COMPREHENSIVE QUOTA FIX TESTS PASSED 100%! <<<\n";
