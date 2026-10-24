-- Add limits and subscription details to tenants table
ALTER TABLE tenants ADD COLUMN message_limit INT DEFAULT 1000;
ALTER TABLE tenants ADD COLUMN device_limit INT DEFAULT 1;
ALTER TABLE tenants ADD COLUMN subscription_ends_at TIMESTAMP NULL;
ALTER TABLE tenants ADD COLUMN role VARCHAR(30) DEFAULT 'user';
