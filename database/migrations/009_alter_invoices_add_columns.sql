-- Add invoice_no, plan_id, payment_method_id, notes to invoices table
ALTER TABLE invoices ADD COLUMN invoice_no VARCHAR(50);
ALTER TABLE invoices ADD COLUMN plan_id VARCHAR(50) DEFAULT 'starter';
ALTER TABLE invoices ADD COLUMN payment_method_id VARCHAR(50);
ALTER TABLE invoices ADD COLUMN notes TEXT;
