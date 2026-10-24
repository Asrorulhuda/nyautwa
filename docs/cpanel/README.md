# Panduan Deployment NyautWa ke cPanel

Panduan deployment aplikasi WhatsApp Gateway SaaS (NyautWa) ke hosting cPanel, mencakup PHP Native Web dan Node.js Baileys Engine.

---

## Arsitektur Aplikasi di cPanel

NyautWa di cPanel berjalan dengan dua komponen utama:
1. **Frontend & Backend Web (PHP 8.2+)**:
   - Ditaruh di `public_html` (atau folder subdomain).
   - Menjalankan router MVC, dashboard, autentikasi, dan API.
   - Terhubung langsung ke database MySQL cPanel.
2. **WhatsApp Gateway Engine (Node.js 20 LTS + Baileys)**:
   - Dijalankan via menu bawaan cPanel: **"Setup Node.js App"** (Phusion Passenger).
   - Berjalan di folder `engine/` port internal `3000`.
   - Mengelola sesi koneksi WhatsApp, QR Code, dan Socket Baileys.

---

## Daftar Langkah Deployment

1. [01. Setup Database MySQL & File .env](file:///c:/laragon/www/nyautwa/docs/cpanel/01_database_and_env.md)
2. [02. Setup Node.js App (Baileys Engine) di cPanel](file:///c:/laragon/www/nyautwa/docs/cpanel/02_nodejs_engine.md)

---

## Alur Update Kode (Manual via Git)

Untuk memperbarui kode di server hosting cPanel:
```bash
git pull origin main
```
