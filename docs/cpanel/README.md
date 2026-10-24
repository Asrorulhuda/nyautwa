# Panduan Deployment NyautWa ke cPanel

Panduan lengkap deployment aplikasi WhatsApp Gateway SaaS (NyautWa) ke hosting cPanel, mencakup PHP Native Web, Node.js Baileys Engine, dan CI/CD GitHub Actions.

---

## Arsitektur Aplikasi di cPanel

NyautWa di cPanel berjalan dengan dua komponen utama:
1. **Frontend & Backend Web (PHP 8.2+)**:
   - Ditaruh di `public_html` (atau subdomain).
   - Menjalankan router MVC, dashboard, autentikasi, dan API.
   - Terhubung ke database MySQL cPanel.
2. **WhatsApp Gateway Engine (Node.js 20 LTS + Baileys)**:
   - Dijalankan via menu bawaan cPanel: **"Setup Node.js App"** (Phusion Passenger).
   - Berjalan di folder `engine/` port internal `3000`.
   - Mengelola sesi koneksi WhatsApp, QR Code, dan Socket Baileys.

---

## Daftar Langkah Deployment

Silakan ikuti 3 panduan modular berikut secara berurutan:
1. [01. Setup Database MySQL & File .env](file:///c:/laragon/www/nyautwa/docs/cpanel/01_database_and_env.md)
2. [02. Setup Node.js App (Baileys Engine) di cPanel](file:///c:/laragon/www/nyautwa/docs/cpanel/02_nodejs_engine.md)
3. [03. Konfigurasi CI/CD Auto-Deploy via GitHub Actions](file:///c:/laragon/www/nyautwa/docs/cpanel/03_github_actions_ci_cd.md)

---

## Ringkasan Alur Auto-Deploy
```
Local (PC) ──git push──> GitHub (main) ──GitHub Actions──> cPanel (FTP/Git)
                             │
                             ▼
                    Uji Otomatis Lolos
                    (Check Lines & Tests)
```
Setiap kali Anda melakukan commit dan push dari komputer lokal, GitHub Actions akan menjalankan verifikasi kode dan langsung mengunggah perubahan ke cPanel secara otomatis tanpa perlu upload manual.
