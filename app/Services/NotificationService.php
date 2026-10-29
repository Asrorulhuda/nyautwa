<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class NotificationService {
    public function notifyAdminPaymentProof(array $inv, string $proofUrl): bool {
        $st = (new LandingSettingsService())->getAll();
        $adminPhone = trim((string)($st['footer_contact_phone'] ?? ''));
        if (empty($adminPhone)) return false;

        $dev = Database::fetchOne("SELECT id, tenant_id FROM devices WHERE status = 'connected' LIMIT 1") 
            ?? Database::fetchOne("SELECT id, tenant_id FROM devices LIMIT 1");
        if (!$dev) return false;

        $tenantName = $inv['tenant']['name'] ?? 'Klien';
        $ownerName = $inv['owner']['name'] ?? '-';
        $ownerPhone = $inv['owner']['phone'] ?? '-';
        $plan = (new PlanService())->getPlan($inv['plan_id'] ?? 'starter');
        $planName = $plan['name'] ?? ucfirst($inv['plan_id']);
        $amt = number_format((float)$inv['amount'], 0, ',', '.');
        $method = $inv['payment_method']['name'] ?? 'Transfer Bank';

        $msg = "Halo Admin NyautWa,\n\nAda konfirmasi bukti pembayaran baru:\n"
             . "- Klien: *{$tenantName}*\n"
             . "- PIC: *{$ownerName}* ({$ownerPhone})\n"
             . "- Invoice: *{$inv['invoice_no']}*\n"
             . "- Paket: *{$planName}*\n"
             . "- Nominal: *Rp {$amt}*\n"
             . "- Metode: *{$method}*\n\n"
             . "Bukti Transfer:\n"
             . $this->getFullUrl($proofUrl) . "\n\n"
             . "Silakan cek & konfirmasi lunas di panel Billing:\n"
             . $this->getFullUrl('/billing');

        (new MessageService())->queueMessage($dev['tenant_id'] ?? $inv['tenant_id'], $dev['id'], $adminPhone, $msg, 'text', ['is_system' => true]);
        return true;
    }

    public function notifyClientPaymentConfirmed(array $inv): bool {
        $ownerPhone = trim((string)($inv['owner']['phone'] ?? ''));
        if (empty($ownerPhone)) return false;

        $dev = Database::fetchOne("SELECT id, tenant_id FROM devices WHERE status = 'connected' LIMIT 1") 
            ?? Database::fetchOne("SELECT id, tenant_id FROM devices LIMIT 1");
        if (!$dev) return false;

        $ownerName = $inv['owner']['name'] ?? 'Pelanggan';
        $plan = (new PlanService())->getPlan($inv['plan_id'] ?? 'starter');
        $planName = $plan['name'] ?? ucfirst($inv['plan_id']);

        $msg = "Halo *{$ownerName}*,\n\n"
             . "Pembayaran untuk invoice *{$inv['invoice_no']}* telah berhasil diverifikasi oleh Admin.\n"
             . "Paket *{$planName}* Anda kini telah aktif!\n\n"
             . "Silakan akses dashboard Anda di:\n"
             . $this->getFullUrl('/dashboard') . "\n\n"
             . "Terima kasih atas kepercayaan Anda menggunakan NyautWa Gateway.";

        (new MessageService())->queueMessage($dev['tenant_id'] ?? $inv['tenant_id'], $dev['id'], $ownerPhone, $msg, 'text', ['is_system' => true]);
        return true;
    }

    private function getFullUrl(string $path): string {
        $base = env('APP_URL', '');
        if (empty($base)) {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $basePath = (new \App\Core\Request())->getBasePath();
            $base = $scheme . '://' . $host . $basePath;
        }
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}
