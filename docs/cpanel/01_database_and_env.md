# Langkah 1 — Setup Database MySQL & File .env di cPanel

Ikuti langkah-langkah berikut untuk menyiapkan basis data produksi di cPanel:

---

### 1. Buat Database & User MySQL di cPanel
1. Masuk ke dashboard **cPanel**.
2. Cari dan buka menu **MySQL® Databases**.
3. Buat database baru, contoh: `username_nyautwa`.
4. Buat pengguna MySQL baru, contoh: `username_wauser` beserta kata sandi yang kuat.
5. Pada bagian **Add User to Database**, hubungkan pengguna tersebut ke database dengan memberikan centang pada **ALL PRIVILEGES** (Semua Hak Akses).

---

### 2. Jalankan Migrasi Database
Buka menu **Terminal** di cPanel (atau via phpMyAdmin):
Jalankan perintah berikut di folder aplikasi:
```bash
php database/migrate.php
```
*Seluruh 10 skema tabel (tenants, users, devices, autoreplies, contacts, campaigns, dll) akan otomatis terpasang dengan sukses.*

---

### 3. Buat File Konfigurasi `.env` di cPanel
Buka **File Manager** cPanel, navigasikan ke folder aplikasi Anda, lalu buat/edit file `.env` dengan konfigurasi berikut:

```ini
APP_ENV=production
APP_URL=https://domainanda.com
APP_KEY=nyautwa_production_secret_key_849201948201

# Konfigurasi Database MySQL cPanel
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=username_nyautwa
DB_USERNAME=username_wauser
DB_PASSWORD=KataSandiMySQLAnda

# Engine Baileys Internal Secret
ENGINE_PORT=3000
ENGINE_SECRET=nyautwa_engine_internal_secret_994821
```

> **Keamanan Penting:** Jangan pernah menyertakan file `.env` ini ke dalam Git publik. File ini tersimpan aman di server hosting cPanel Anda.
