-- Migrasi 011: Memperluas kolom phone dan receiver untuk mendukung ID Grup WhatsApp (@g.us)

ALTER TABLE contacts MODIFY phone VARCHAR(64) NOT NULL;
ALTER TABLE blasts MODIFY receiver VARCHAR(64) NOT NULL;
