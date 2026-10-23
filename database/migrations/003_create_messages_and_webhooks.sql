CREATE TABLE IF NOT EXISTS messages (
    id VARCHAR(64) PRIMARY KEY,
    tenant_id VARCHAR(64) NOT NULL,
    device_id VARCHAR(64) NOT NULL,
    direction VARCHAR(10) NOT NULL DEFAULT 'outbound',
    to_from VARCHAR(30) NOT NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'text',
    body TEXT NOT NULL,
    media_ref TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'queued',
    wa_message_id VARCHAR(100) NULL,
    idempotency_key VARCHAR(100) NULL,
    error TEXT NULL,
    queued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sent_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS webhook_deliveries (
    id VARCHAR(64) PRIMARY KEY,
    tenant_id VARCHAR(64) NOT NULL,
    device_id VARCHAR(64) NOT NULL,
    event VARCHAR(50) NOT NULL,
    payload TEXT NOT NULL,
    attempts INT NOT NULL DEFAULT 1,
    last_status INT NULL,
    next_retry_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
