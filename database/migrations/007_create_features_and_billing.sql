CREATE TABLE IF NOT EXISTS features (
    code VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) DEFAULT 'messaging',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tenant_features (
    tenant_id VARCHAR(64) NOT NULL,
    feature_code VARCHAR(50) NOT NULL,
    enabled INT DEFAULT 1,
    PRIMARY KEY (tenant_id, feature_code)
);

CREATE TABLE IF NOT EXISTS payment_methods (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    account_number VARCHAR(100),
    account_name VARCHAR(100),
    type VARCHAR(30) DEFAULT 'bank_transfer',
    is_active INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS invoices (
    id VARCHAR(64) PRIMARY KEY,
    invoice_no VARCHAR(50) UNIQUE NOT NULL,
    tenant_id VARCHAR(64) NOT NULL,
    plan_id VARCHAR(50) DEFAULT 'starter',
    amount INT NOT NULL DEFAULT 0,
    status VARCHAR(20) DEFAULT 'paid',
    payment_method_id VARCHAR(50),
    paid_at TIMESTAMP,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed initial features corresponding to actual NyautWa application capabilities
INSERT OR IGNORE INTO features (code, name, category) VALUES
    ('wa_connection', 'Koneksi WhatsApp & Multi-Device', 'device'),
    ('send_text', 'Kirim Pesan Teks Dashboard', 'messaging'),
    ('send_media', 'Kirim Media & Dokumen', 'messaging'),
    ('message_history', 'Riwayat & Log Pesan', 'messaging'),
    ('anti_ban_queue', 'Antrean Pesan & Anti-Ban', 'security'),
    ('rest_api', 'Akses REST API Gateway', 'developer'),
    ('api_keys', 'Manajemen API Key', 'developer'),
    ('webhooks', 'Webhook Pesan Masuk & Event', 'developer'),
    ('api_docs', 'Dokumentasi API & SDK', 'developer'),
    ('analytics_dashboard', 'Dashboard Analitik & Metrik', 'analytics');

-- Seed default payment methods
INSERT OR IGNORE INTO payment_methods (id, name, account_number, account_name, type) VALUES
    ('bca_transfer', 'Transfer Bank BCA', '8830-1928-11', 'PT NyautWa Digital Indonesia', 'bank_transfer'),
    ('mandiri_transfer', 'Transfer Bank Mandiri', '137-00-998822-1', 'PT NyautWa Digital Indonesia', 'bank_transfer'),
    ('qris_instant', 'QRIS Statis / Instan', 'NMID-ID10200392019', 'NyautWa Gateway Official', 'qris');
