-- ========================================================
-- NYAUTWA - DEFAULT INITIAL SEEDS (PLANS, USERS, DEFAULTS)
-- ========================================================
REPLACE INTO plans (id, name, limits_json, price_monthly, price_yearly) VALUES
('trial', 'Trial 7 Hari', '{"devices":1,"monthly_messages":200,"daily_messages":30,"api_rpm":30,"media":false,"webhooks":true}', 0, 0),
('starter', 'Starter', '{"devices":2,"monthly_messages":5000,"daily_messages":500,"api_rpm":120,"media":true,"webhooks":true}', 99000, 990000),
('business', 'Business', '{"devices":10,"monthly_messages":50000,"daily_messages":2500,"api_rpm":600,"media":true,"webhooks":true}', 249000, 2490000),
('reseller', 'Reseller', '{"devices":50,"monthly_messages":150000,"daily_messages":10000,"api_rpm":1200,"media":true,"webhooks":true}', 799000, 7990000);

REPLACE INTO tenants (id, name, plan_id, status) VALUES 
('tenant_demo_01', 'PT Teknologi Berkah Indonesia', 'business', 'active');

-- Akun Login: admin@nyautwa.test / password123
REPLACE INTO users (id, tenant_id, name, email, password_hash, role) VALUES 
('usr_admin_01', 'tenant_demo_01', 'Fikri Baihaqy', 'admin@nyautwa.test', '$2y$10$3cR73jL/Q64p52z99iQo/uX1N50yF9M2tXnI6Z5i7N9xJ9k1T.ZcK', 'admin');

REPLACE INTO devices (id, tenant_id, label, phone, status, session_ref, webhook_url, daily_limit) VALUES 
('dev_primary_01', 'tenant_demo_01', 'CS WhatsApp Utama', '+6281288990011', 'connected', 'sess_nyautwa_primary', 'https://api.bisnisanda.com/webhook/whatsapp', 5000);

REPLACE INTO api_keys (id, tenant_id, name, key_hash, prefix) VALUES 
('key_prod_01', 'tenant_demo_01', 'Production ERP Backend', '99c82cbb692bbda24177d704ad52f8546b1be4508922119ef473bca512b93b9c', 'nyaut_live_');

REPLACE INTO tags (id, tenant_id, name, color) VALUES 
('tag_grp_01', 'tenant_demo_01', 'Grup WhatsApp', '#6366F1'),
('tag_pers_01', 'tenant_demo_01', 'Kontak WhatsApp', '#16A36A');

REPLACE INTO saas_features (id, code, name, description, is_enabled, min_plan_tier) VALUES
('feat_01', 'autoreply', 'Balas Otomatis AI & Kata Kunci', 'Respon otomatis pesan masuk 24/7', 1, 'starter'),
('feat_02', 'campaign', 'Broadcast Massal Anti-Ban', 'Pengiriman pesan massal terkelola dengan delay jitter', 1, 'starter'),
('feat_03', 'phonebook', 'Buku Kontak & Sinkronisasi Grup', 'Kelola kontak dan sinkronisasi anggota grup WhatsApp', 1, 'starter'),
('feat_04', 'apikeys', 'REST API & Webhooks Engine', 'Integrasi sistem backend luar melalui token API', 1, 'starter');
