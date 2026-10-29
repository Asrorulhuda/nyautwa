<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Services\SidebarQuotaService;
use App\Services\QuotaService;

$tenantId = 'tenant_demo_01';
$quotaService = new QuotaService();
$sidebarService = new SidebarQuotaService();

echo "=== 1. INITIAL STATE ===\n";
Database::query("UPDATE tenants SET messages_used = 15 WHERE id = :id", ['id' => $tenantId]);
Database::query("UPDATE usage_counters SET messages_out = 15 WHERE tenant_id = :id AND period = :p", ['id' => $tenantId, 'p' => date('Y-m')]);
$data1 = $sidebarService->getSidebarData($tenantId, false);
echo "Terkirim: {$data1['sent']} / {$data1['limit_formatted']} ({$data1['percentage_text']})\n";

echo "\n=== 2. RECORD OUTBOUND MESSAGE (SIMULASI PENGIRIMAN) ===\n";
$quotaService->recordUsage($tenantId, 5, 0);
$data2 = $sidebarService->getSidebarData($tenantId, false);
echo "Setelah kirim 5 pesan: Terkirim: {$data2['sent']} / {$data2['limit_formatted']}\n";

echo "\n=== 3. HAPUS SEMUA LOG PESAN (SIMULASI CLIENT CLEAR LOG) ===\n";
Database::query("DELETE FROM messages WHERE tenant_id = :id", ['id' => $tenantId]);
$data3 = $sidebarService->getSidebarData($tenantId, false);
echo "Setelah log pesan dihapus: Terkirim: {$data3['sent']} / {$data3['limit_formatted']}\n";

if ($data3['sent'] === 20) {
    echo "\n>>> SUKSES: Pemakaian kuota TIDAK TER-RESET meski log pesan dihapus! <<<\n";
} else {
    echo "\n>>> GAGAL: Pemakaian kuota ter-reset! <<<\n";
}
