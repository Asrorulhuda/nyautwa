<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Services\{SubscriptionService, LandingSettingsService, MessageService};

echo "=== Memulai Worker Pengingat Masa Aktif Langganan NyautWa ===\n";

$subService = new SubscriptionService();
$msgService = new MessageService();
$settings = (new LandingSettingsService())->getAll();
$tpl = $settings['reminder_wa_template'] ?? '';

if (empty($tpl)) {
    echo "[ABORT] Template reminder_wa_template belum dikonfigurasi di admin.\n";
    exit(0);
}

$dev = Database::fetchOne("SELECT id FROM devices WHERE status = 'connected' LIMIT 1") ?? Database::fetchOne("SELECT id FROM devices LIMIT 1");
if (!$dev) {
    echo "[ABORT] Tidak ada device WhatsApp aktif untuk mengirim pesan pengingat.\n";
    exit(0);
}

$tenants = Database::fetchAll("SELECT id, name FROM tenants WHERE status = 'active'");
$countSent = 0;

foreach ($tenants as $t) {
    $tid = $t['id'];
    $sub = $subService->getTenantSubscription($tid);
    $daysLeft = $sub['days_left'];

    if ($daysLeft !== null && $daysLeft <= 3 && $daysLeft >= 0) {
        $u = Database::fetchOne("SELECT name, phone FROM users WHERE tenant_id = :tid LIMIT 1", ['tid' => $tid]);
        $phone = trim($u['phone'] ?? '');

        if (!empty($phone)) {
            $msg = str_replace(
                ['{nama}', '{paket}', '{sisa_hari}', '{tanggal_habis}', '{link_perpanjang}'],
                [
                    $u['name'] ?: $t['name'],
                    $sub['plan_name'],
                    (string)$daysLeft,
                    $sub['ends_at'] ? date('d M Y', strtotime($sub['ends_at'])) : '-',
                    rtrim(APP_URL, '/') . '/onboarding/plan'
                ],
                $tpl
            );

            $msgService->queueMessage($tid, $dev['id'], $phone, $msg, 'text', ['is_system' => true]);
            echo "[SENT] Pengingat H-{$daysLeft} berhasil dikirim ke {$t['name']} ({$phone})\n";
            $countSent++;
        }
    }
}

echo "=== Worker Selesai. Total Pengingat Terkirim: {$countSent} ===\n";
