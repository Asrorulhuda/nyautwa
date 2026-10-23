<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

echo "=== Menjalankan Database Seeder NyautWa ===\n";

$db = Database::getInstance()->getConnection();

// 1. Seed Plans (Sesuai 05-saas-billing.md)
$plans = [
    [
        'id' => 'trial',
        'name' => 'Trial 7 Hari',
        'limits_json' => json_encode(['devices' => 1, 'monthly_messages' => 200, 'daily_messages' => 30, 'api_rpm' => 30, 'media' => false, 'webhooks' => true]),
        'price_monthly' => 0,
        'price_yearly' => 0,
    ],
    [
        'id' => 'starter',
        'name' => 'Starter',
        'limits_json' => json_encode(['devices' => 2, 'monthly_messages' => 5000, 'daily_messages' => 500, 'api_rpm' => 120, 'media' => true, 'webhooks' => true]),
        'price_monthly' => 99000,
        'price_yearly' => 990000,
    ],
    [
        'id' => 'business',
        'name' => 'Business',
        'limits_json' => json_encode(['devices' => 10, 'monthly_messages' => 50000, 'daily_messages' => 2500, 'api_rpm' => 600, 'media' => true, 'webhooks' => true]),
        'price_monthly' => 249000,
        'price_yearly' => 2490000,
    ],
    [
        'id' => 'pro',
        'name' => 'Professional (Legacy)',
        'limits_json' => json_encode(['devices' => 10, 'monthly_messages' => 50000, 'daily_messages' => 2500, 'api_rpm' => 600, 'media' => true, 'webhooks' => true]),
        'price_monthly' => 249000,
        'price_yearly' => 2490000,
    ],
    [
        'id' => 'reseller',
        'name' => 'Reseller',
        'limits_json' => json_encode(['devices' => 50, 'monthly_messages' => 150000, 'daily_messages' => 10000, 'api_rpm' => 1200, 'media' => true, 'webhooks' => true]),
        'price_monthly' => 799000,
        'price_yearly' => 7990000,
    ],
    [
        'id' => 'enterprise',
        'name' => 'Enterprise (Legacy)',
        'limits_json' => json_encode(['devices' => 50, 'monthly_messages' => 150000, 'daily_messages' => 10000, 'api_rpm' => 1200, 'media' => true, 'webhooks' => true]),
        'price_monthly' => 799000,
        'price_yearly' => 7990000,
    ],
];

foreach ($plans as $plan) {
    $stmt = $db->prepare("INSERT OR REPLACE INTO plans (id, name, limits_json, price_monthly, price_yearly) VALUES (:id, :name, :limits_json, :price_monthly, :price_yearly)");
    // Support MySQL REPLACE INTO fallback
    if ($db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') {
        $stmt = $db->prepare("REPLACE INTO plans (id, name, limits_json, price_monthly, price_yearly) VALUES (:id, :name, :limits_json, :price_monthly, :price_yearly)");
    }
    $stmt->execute($plan);
}
echo "Plans seeded.\n";

// 2. Seed Demo Tenant & User
$tenantId = 'tenant_demo_01';
$stmt = $db->prepare("SELECT id FROM tenants WHERE id = :id");
$stmt->execute(['id' => $tenantId]);
if (!$stmt->fetch()) {
    $db->prepare("INSERT INTO tenants (id, name, plan_id, status) VALUES (:id, :name, :plan_id, :status)")
        ->execute([
            'id' => $tenantId,
            'name' => 'PT Teknologi Berkah Indonesia',
            'plan_id' => 'pro',
            'status' => 'active',
        ]);
}

$userEmail = 'admin@nyautwa.test';
$stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute(['email' => $userEmail]);
if (!$stmt->fetch()) {
    $db->prepare("INSERT INTO users (id, tenant_id, name, email, password_hash, role) VALUES (:id, :tenant_id, :name, :email, :password_hash, :role)")
        ->execute([
            'id' => 'usr_admin_01',
            'tenant_id' => $tenantId,
            'name' => 'Fikri Baihaqy',
            'email' => $userEmail,
            'password_hash' => password_hash('password123', PASSWORD_BCRYPT),
            'role' => 'admin',
        ]);
}
echo "User & Tenant seeded (admin@nyautwa.test / password123).\n";

// 3. Seed Demo Device
$deviceId = 'dev_primary_01';
$stmt = $db->prepare("SELECT id FROM devices WHERE id = :id");
$stmt->execute(['id' => $deviceId]);
if (!$stmt->fetch()) {
    $db->prepare("INSERT INTO devices (id, tenant_id, label, phone, status, session_ref, webhook_url, daily_limit) VALUES (:id, :tenant_id, :label, :phone, :status, :session_ref, :webhook_url, :daily_limit)")
        ->execute([
            'id' => $deviceId,
            'tenant_id' => $tenantId,
            'label' => 'CS WhatsApp Utama',
            'phone' => '+6281288990011',
            'status' => 'connected',
            'session_ref' => 'sess_nyautwa_primary',
            'webhook_url' => 'https://api.bisnisanda.com/webhook/whatsapp',
            'daily_limit' => 5000,
        ]);
}
echo "Device seeded.\n";

// 4. Seed Demo API Key
$keyPrefix = 'nyaut_live_';
$rawKey = 'nyaut_live_948f2178ad99e120';
$stmt = $db->prepare("SELECT id FROM api_keys WHERE prefix = :prefix");
$stmt->execute(['prefix' => $keyPrefix]);
if (!$stmt->fetch()) {
    $db->prepare("INSERT INTO api_keys (id, tenant_id, name, key_hash, prefix) VALUES (:id, :tenant_id, :name, :key_hash, :prefix)")
        ->execute([
            'id' => 'key_prod_01',
            'tenant_id' => $tenantId,
            'name' => 'Production ERP Backend',
            'key_hash' => hash('sha256', $rawKey),
            'prefix' => $keyPrefix,
        ]);
}
echo "API Key seeded.\n";

// 5. Seed Sample Messages
$sampleMessages = [
    [
        'id' => 'msg_001',
        'tenant_id' => $tenantId,
        'device_id' => $deviceId,
        'to_from' => '+6281234567890',
        'body' => 'Halo Kak Budi, pesanan #INV-20261021 telah dikirimkan via JNE No Resi: JNE992819281. Terima kasih!',
        'status' => 'delivered',
        'wa_message_id' => 'wamid_BAE58921A',
    ],
    [
        'id' => 'msg_002',
        'tenant_id' => $tenantId,
        'device_id' => $deviceId,
        'to_from' => '+6285712345678',
        'body' => 'Kode OTP verifikasi akun NyautWa Anda adalah: 849-210. Berlaku 5 menit. Dilarang memberikan kode ini ke siapa pun.',
        'status' => 'read',
        'wa_message_id' => 'wamid_BAE58922B',
    ],
    [
        'id' => 'msg_003',
        'tenant_id' => $tenantId,
        'device_id' => $deviceId,
        'to_from' => '+6289987654321',
        'body' => 'Pengingat: Tagihan internet bulanan Anda jatuh tempo besok 24 Oktober 2026. Silakan bayar lewat QRIS berikut.',
        'status' => 'queued',
        'wa_message_id' => null,
    ],
    [
        'id' => 'msg_004',
        'tenant_id' => $tenantId,
        'device_id' => $deviceId,
        'to_from' => '+6281122334455',
        'body' => 'Terima kasih telah mengunjungi booth kami pada pameran Tech Expo.',
        'status' => 'failed',
        'wa_message_id' => null,
    ],
];

foreach ($sampleMessages as $m) {
    $stmt = $db->prepare("SELECT id FROM messages WHERE id = :id");
    $stmt->execute(['id' => $m['id']]);
    if (!$stmt->fetch()) {
        $db->prepare("INSERT INTO messages (id, tenant_id, device_id, to_from, body, status, wa_message_id) VALUES (:id, :tenant_id, :device_id, :to_from, :body, :status, :wa_message_id)")
            ->execute($m);
    }
}
echo "Sample messages seeded.\n";
echo "Seeder selesai dengan sukses!\n";
