<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

$plans = [
    ['trial', 'Trial 7 Hari', '{"devices":1,"monthly_messages":200,"daily_messages":30,"api_rpm":30,"media":false,"webhooks":true}', 0, 0],
    ['starter', 'Starter', '{"devices":2,"monthly_messages":5000,"daily_messages":500,"api_rpm":120,"media":true,"webhooks":true}', 99000, 990000],
    ['business', 'Business', '{"devices":10,"monthly_messages":50000,"daily_messages":2500,"api_rpm":600,"media":true,"webhooks":true}', 249000, 2490000],
    ['reseller', 'Reseller', '{"devices":50,"monthly_messages":150000,"daily_messages":10000,"api_rpm":1200,"media":true,"webhooks":true}', 799000, 7990000],
];

foreach ($plans as $p) {
    Database::query("REPLACE INTO plans (id, name, limits_json, price_monthly, price_yearly) VALUES (?, ?, ?, ?, ?)", $p);
}

$tenantId = 'tenant_demo_01';
Database::query("REPLACE INTO tenants (id, name, plan_id, status) VALUES (?, 'PT Teknologi Berkah Indonesia', 'business', 'active')", [$tenantId]);

$passHash = '$2y$10$U7FKKxw5KUgqiNJuk91q3ubbIO.vagx5Itc15Gw6mIExX/GgxrmbG';
Database::query("REPLACE INTO users (id, tenant_id, name, email, password_hash, role) VALUES ('usr_admin_01', ?, 'Fikri Baihaqy', 'admin@nyautwa.test', ?, 'admin')", [$tenantId, $passHash]);

$devId = 'dev_primary_01';
Database::query(
    "REPLACE INTO devices (id, tenant_id, label, phone, status, session_ref, webhook_url, daily_limit) VALUES (?, ?, 'CS WhatsApp Utama', '+6281288990011', 'connected', 'sess_nyautwa_primary', 'https://api.bisnisanda.com/webhook/whatsapp', 5000)",
    [$devId, $tenantId]
);

$keyHash = hash('sha256', 'nyaut_live_948f2178ad99e120');
Database::query("REPLACE INTO api_keys (id, tenant_id, name, key_hash, prefix) VALUES ('key_prod_01', ?, 'Production ERP Backend', ?, 'nyaut_live_')", [$tenantId, $keyHash]);

$messages = [
    ['msg_001', $tenantId, $devId, '+6281234567890', 'Halo Kak Budi, pesanan #INV-20261021 telah dikirimkan via JNE No Resi: JNE992819281.', 'delivered', 'wamid_BAE58921A'],
    ['msg_002', $tenantId, $devId, '+6285712345678', 'Kode OTP verifikasi akun NyautWa Anda adalah: 849-210. Berlaku 5 menit.', 'read', 'wamid_BAE58922B'],
    ['msg_003', $tenantId, $devId, '+6289987654321', 'Pengingat: Tagihan bulanan Anda jatuh tempo besok.', 'queued', null],
];

foreach ($messages as $m) {
    Database::query("REPLACE INTO messages (id, tenant_id, device_id, to_from, body, status, wa_message_id) VALUES (?, ?, ?, ?, ?, ?, ?)", $m);
}

echo "Database MySQL berhasil diseed secara utuh!\n";
