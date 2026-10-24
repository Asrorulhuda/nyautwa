<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Services\AutoReplyService;
use App\Services\ContactService;
use App\Services\CampaignService;

echo "=== Menjalankan Pengujian Fitur MPWA & Otomasi ===\n";

try {
    $tenantId = 'tenant_test_' . bin2hex(random_bytes(4));
    Database::query("INSERT INTO tenants (id, name, plan_id, status) VALUES (:id, 'Tenant MPWA Test', 'starter', 'active')", ['id' => $tenantId]);

// 1. Test AutoReplyService
$replyService = new AutoReplyService();
$replyService->create($tenantId, [
    'keyword' => 'halo',
    'match_type' => 'contain',
    'type' => 'text',
    'response' => 'Halo! Ini balasan otomatis MPWA',
]);
$replies = $replyService->getAll($tenantId);
assert(count($replies) === 1, 'Auto-reply harus tersimpan 1 item');
assert($replies[0]['status'] === 'active', 'Auto-reply harus aktif');

$replyService->toggle($replies[0]['id'], $tenantId);
$updatedReplies = $replyService->getAll($tenantId);
assert($updatedReplies[0]['status'] === 'inactive', 'Auto-reply harus berubah menjadi inactive');
echo "1. Pengujian AutoReplyService: PASS\n";

// 2. Test ContactService
$contactService = new ContactService();
$contactService->createTag($tenantId, 'Pelanggan Tetap', '#16A36A');
$tags = $contactService->getTags($tenantId);
assert(count($tags) === 1, 'Tag harus tersimpan 1');

$contactService->createContact($tenantId, [
    'name' => 'Ahmad Dahlan',
    'phone' => '081234567890',
    'tag_id' => $tags[0]['id'],
]);
$contacts = $contactService->getContacts($tenantId);
assert(count($contacts) === 1, 'Kontak harus tersimpan 1');
assert($contacts[0]['tag_name'] === 'Pelanggan Tetap', 'Tag name relasi kontak harus cocok');
echo "2. Pengujian ContactService: PASS\n";

// 3. Test CampaignService
$devId = 'dev_test_' . bin2hex(random_bytes(4));
Database::query("INSERT INTO devices (id, tenant_id, label, status, session_ref) VALUES (:id, :tid, 'Node Campaign', 'connected', 'sess_test')", ['id' => $devId, 'tid' => $tenantId]);

$campaignService = new CampaignService();
$campId = $campaignService->createCampaign($tenantId, [
    'device_id' => $devId,
    'name' => 'Promo Diskon 50%',
    'message' => 'Halo Kak! Nikmati diskon hari ini',
], ['081234567890', '089876543210']);

$campaigns = $campaignService->getCampaigns($tenantId);
assert(count($campaigns) === 1, 'Campaign harus tersimpan 1');
assert((int)$campaigns[0]['total_recipients'] === 2, 'Penerima harus berjumlah 2');
echo "3. Pengujian CampaignService: PASS\n";

// Cleanup
Database::query("DELETE FROM blasts WHERE tenant_id = :id", ['id' => $tenantId]);
Database::query("DELETE FROM campaigns WHERE tenant_id = :id", ['id' => $tenantId]);
Database::query("DELETE FROM contacts WHERE tenant_id = :id", ['id' => $tenantId]);
Database::query("DELETE FROM tags WHERE tenant_id = :id", ['id' => $tenantId]);
Database::query("DELETE FROM autoreplies WHERE tenant_id = :id", ['id' => $tenantId]);
Database::query("DELETE FROM devices WHERE tenant_id = :id", ['id' => $tenantId]);
    Database::query("DELETE FROM tenants WHERE id = :id", ['id' => $tenantId]);
    echo "SELURUH PENGUJIAN FITUR MPWA BERHASIL 100%!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}
