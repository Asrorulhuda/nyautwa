<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class LandingSettingsService {
    public function getAll(): array {
        $defaults = $this->getDefaults();
        try {
            $rows = Database::fetchAll("SELECT `key`, `value` FROM settings");
            foreach ($rows as $row) {
                if (isset($row['key']) && isset($row['value'])) {
                    $defaults[$row['key']] = $row['value'];
                }
            }
        } catch (\Throwable $e) {
            // Fallback to defaults if table query fails
        }
        return $defaults;
    }

    public function set(string $key, string $value, string $category = 'landing'): void {
        $exists = Database::fetchOne("SELECT `key` FROM settings WHERE `key` = :key", ['key' => $key]);
        if ($exists) {
            Database::query(
                "UPDATE settings SET `value` = :val, `category` = :cat, `updated_at` = CURRENT_TIMESTAMP WHERE `key` = :key",
                ['key' => $key, 'val' => $value, 'cat' => $category]
            );
        } else {
            Database::query(
                "INSERT INTO settings (`key`, `value`, `category`, `updated_at`) VALUES (:key, :val, :cat, CURRENT_TIMESTAMP)",
                ['key' => $key, 'val' => $value, 'cat' => $category]
            );
        }
    }

    public function updateBatch(array $data, string $category = 'landing'): void {
        foreach ($data as $k => $v) {
            if (is_string($v) || is_numeric($v)) {
                $this->set((string)$k, (string)$v, $category);
            }
        }
    }

    public function getDefaults(): array {
        return [
            'hero_badge' => 'WhatsApp Gateway API',
            'hero_title' => 'Integrasikan WhatsApp ke sistem Anda.',
            'hero_subtitle' => 'Kirim notifikasi, kelola koneksi WhatsApp, dan pantau aktivitas pesan melalui API yang dirancang untuk kebutuhan bisnis dan developer.',
            'hero_cta_primary' => 'Mulai Gratis',
            'hero_cta_secondary' => 'Lihat Dokumentasi API',
            'node_name' => 'Server Node Jakarta 01',
            'node_phone' => 'Terhubung (+62 812-9843-XXXX)',
            'node_uptime' => '99.8% (1.2s avg)',
            'feature_1_title' => 'Integrasi API yang sederhana',
            'feature_1_desc' => 'REST API standar dengan dokumentasi interaktif, SDK, dan contoh kode curl, Node.js, Python, & PHP.',
            'feature_2_title' => 'Pantau status pengiriman pesan',
            'feature_2_desc' => 'Real-time webhook delivery callback untuk status pending, sent, delivered, dan read tanpa polling manual.',
            'feature_3_title' => 'Kelola koneksi WhatsApp',
            'feature_3_desc' => 'Multi-device session manager dengan instant QR code pairing dan auto-reconnect failover otomatis.',
            'feature_4_title' => 'Anti-blokir & rate limit cerdas',
            'feature_4_desc' => 'Algoritma antrean pesan dengan dynamic delay acak dan proteksi lonjakan trafik untuk menjaga keamanan nomor.',
            'pricing_starter_price' => 'Rp 149.000',
            'pricing_starter_quota' => '10.000 pesan / bulan',
            'pricing_pro_price' => 'Rp 349.000',
            'pricing_pro_quota' => '50.000 pesan / bulan',
            'pricing_biz_price' => 'Rp 899.000',
            'pricing_biz_quota' => 'Kuota Unlimited',
            'faq_1_q' => 'Berapa lama proses setup hingga WhatsApp gateway siap digunakan?',
            'faq_1_a' => 'Kurang dari 2 menit. Cukup daftar akun, scan QR Code WhatsApp dari aplikasi ponsel, dan mulai kirim pesan via API.',
            'faq_2_q' => 'Apakah mendukung multi-device dan multi-nomor WhatsApp?',
            'faq_2_a' => 'Ya, paket Pro dan Business mendukung pengelolaan multi-device untuk nomor CS, notifikasi transaksi, dan marketing terpisah.',
            'faq_3_q' => 'Bagaimana sistem mencegah nomor WhatsApp terblokir (Anti-Ban)?',
            'faq_3_a' => 'NyautWa menerapkan human-like delay acak, batch throttling otomatis, dan rekomendasi rotasi nomor.',
            'footer_tagline' => 'Infrastruktur WhatsApp Gateway modern dan terpercaya untuk bisnis dan developer Indonesia.',
            'footer_contact_phone' => '+62 812-3456-7890',
            'footer_contact_email' => 'halo@nyautwa.id',
            'footer_address' => 'Jakarta Selatan, DKI Jakarta, Indonesia',
        ];
    }
}
