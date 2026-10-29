-- Migration: 012_alter_autoreplies_options.sql
-- Menambahkan kolom options (JSON untuk polling/voting dan list tombol button)
ALTER TABLE autoreplies ADD COLUMN options TEXT NULL AFTER media_url;
