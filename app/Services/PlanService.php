<?php

declare(strict_types=1);

namespace App\Services;

class PlanService {
    public function getAvailablePlans(): array {
        $st = (new LandingSettingsService())->getAll();
        $parseLines = fn($text, $def) => !empty(trim((string)$text)) ? array_values(array_filter(array_map('trim', explode("\n", (string)$text)))) : $def;
        $num = fn($raw, $fallback) => (float)(preg_replace('/[^0-9]/', '', (string)$raw) ?: $fallback);

        $mods = fn($k) => [
            'crm' => (bool) ($st["pricing_{$k}_feat_crm"] ?? 1),
            'send_message' => (bool) ($st["pricing_{$k}_feat_send_message"] ?? 1),
            'autoreply' => (bool) ($st["pricing_{$k}_feat_autoreply"] ?? 1),
            'broadcast' => (bool) ($st["pricing_{$k}_feat_broadcast"] ?? 1),
            'api_keys' => (bool) ($st["pricing_{$k}_feat_api_keys"] ?? 1),
        ];

        return [
            'trial' => [
                'id' => 'trial', 'name' => $st['pricing_trial_name'] ?? 'Free Trial', 'badge' => 'Uji Coba',
                'price' => 0, 'price_label' => $st['pricing_trial_price'] ?? 'Gratis',
                'duration_days' => (int) ($st['pricing_trial_duration_days'] ?? 7),
                'period' => ($st['pricing_trial_duration_days'] ?? 7) . ' Hari', 'popular' => false,
                'devices' => (int) ($st['pricing_trial_devices'] ?? 1),
                'quota' => $st['pricing_trial_quota'] ?? '200 Pesan / hari',
                'modules' => $mods('trial'),
                'features' => $parseLines($st['pricing_trial_features'] ?? null, [
                    '1 Koneksi WhatsApp Aktif', '200 Pesan kuota uji coba',
                    'Akses Notifikasi Pesan Dasar',
                ]),
            ],
            'starter' => [
                'id' => 'starter', 'name' => $st['pricing_starter_name'] ?? 'Starter', 'badge' => 'UMKM',
                'price' => $num($st['pricing_starter_price'] ?? null, 149000),
                'price_label' => $st['pricing_starter_price'] ?? 'Rp 149.000',
                'duration_days' => (int) ($st['pricing_starter_duration_days'] ?? 30),
                'period' => '/ bulan', 'popular' => false,
                'devices' => (int) ($st['pricing_starter_devices'] ?? 2),
                'quota' => $st['pricing_starter_quota'] ?? '10.000 pesan / bulan',
                'modules' => $mods('starter'),
                'features' => $parseLines($st['pricing_starter_features'] ?? null, [
                    ($st['pricing_starter_devices'] ?? 2) . ' Koneksi WhatsApp Simultan',
                    ($st['pricing_starter_quota'] ?? '10.000 pesan / bulan') . ' kuota notifikasi',
                ]),
            ],
            'business' => [
                'id' => 'business', 'name' => $st['pricing_pro_name'] ?? 'Pro Business', 'badge' => 'Populer',
                'price' => $num($st['pricing_pro_price'] ?? null, 349000),
                'price_label' => $st['pricing_pro_price'] ?? 'Rp 349.000',
                'duration_days' => (int) ($st['pricing_pro_duration_days'] ?? 30),
                'period' => '/ bulan', 'popular' => true,
                'devices' => (int) ($st['pricing_pro_devices'] ?? 5),
                'quota' => $st['pricing_pro_quota'] ?? '50.000 pesan / bulan',
                'modules' => $mods('pro'),
                'features' => $parseLines($st['pricing_pro_features'] ?? null, [
                    ($st['pricing_pro_devices'] ?? 5) . ' Koneksi WhatsApp Simultan',
                    ($st['pricing_pro_quota'] ?? '50.000 pesan / bulan') . ' kuota notifikasi',
                ]),
            ],
            'reseller' => [
                'id' => 'reseller', 'name' => $st['pricing_biz_name'] ?? 'Enterprise', 'badge' => 'Skala Besar',
                'price' => $num($st['pricing_biz_price'] ?? null, 899000),
                'price_label' => $st['pricing_biz_price'] ?? 'Rp 899.000',
                'duration_days' => (int) ($st['pricing_biz_duration_days'] ?? 30),
                'period' => '/ bulan', 'popular' => false,
                'devices' => (int) ($st['pricing_biz_devices'] ?? 20),
                'quota' => $st['pricing_biz_quota'] ?? 'Kuota Unlimited',
                'modules' => $mods('biz'),
                'features' => $parseLines($st['pricing_biz_features'] ?? null, [
                    ($st['pricing_biz_devices'] ?? 20) . ' Koneksi WhatsApp Aktif',
                    'Dedicated Gateway IP & White-label',
                ]),
            ],
        ];
    }

    public function getPlan(string $id): ?array {
        return $this->getAvailablePlans()[$id] ?? null;
    }
}
