# NyautWa WhatsApp Gateway SaaS Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun aplikasi SaaS WhatsApp Gateway "NyautWa" lengkap dengan arsitektur Clean MVC (PHP 8.2+ Native) dan engine Baileys internal, mengadopsi 100% design system dari folder `docs/design/` dan aturan anti-slop di `AGENTS.md`.

**Architecture:** Frontend PHP Native Views memanfaatkan design system (Geist, JetBrains Mono, Tailwind/Design Tokens CSS) yang diambil langsung dari mockup HTML di `docs/design/`. Backend menggunakan routing native, PDO Database singleton, Session/Auth Manager, dan REST API. Engine WhatsApp dijalankan sebagai Node.js service internal di `/engine` yang berkomunikasi melalui HTTP + secret token.

**Tech Stack:** PHP 8.2+, MySQL 8 / SQLite (untuk portability/testing lokal), Node.js 20 LTS + Baileys, Tailwind CSS / Design Tokens, Vanilla JS.

**Spec:** [`docs/superpowers/specs/2026-10-23-nyautwa-gateway-design.md`](docs/superpowers/specs/2026-10-23-nyautwa-gateway-design.md) & [`AGENTS.md`](AGENTS.md)

## Global Constraints

- Wajib mengikuti palet warna `#F6F8F7`, `#16A36A`, `#17211F`, `#E4EAE6` dari `docs/design/nyautwa/DESIGN.md`.
- Wajib menggunakan font `Geist` untuk teks dan `JetBrains Mono` untuk nomor/ID/kode teknis.
- Dilarang elemen AI-slop: gradasi ungu-biru, glassmorphism, blob neon, copywriting klise.
- Semua form input wajib mempertahankan data saat validasi gagal (`old_inputs`), memiliki CSRF token, dan output HTML diescape (`htmlspecialchars`).
- Semua query SQL wajib menggunakan PDO parameter binding (anti SQL injection).

---

### Task 1: Environment & Project Scaffolding
**Files:**
- Create: `config/app.php`
- Create: `config/database.php`
- Create: `app/Core/Database.php`
- Create: `app/Core/Request.php`
- Create: `app/Core/Response.php`
- Create: `app/Core/Router.php`
- Create: `app/Core/View.php`
- Create: `public/index.php`
- Create: `.env.example`
- Create: `.env`

**Interfaces:**
- Produces: `Database::getInstance()->getConnection(): PDO`
- Produces: `Router::get(string $path, callable|array $handler)`
- Produces: `Router::post(string $path, callable|array $handler)`
- Produces: `View::render(string $view, array $data = [], string $layout = 'app')`

- [ ] **Step 1: Buat file konfigurasi `.env` dan `config/`**
- [ ] **Step 2: Buat kelas `Database.php` dengan koneksi PDO yang tangguh (mendukung MySQL dan SQLite fallback)**
- [ ] **Step 3: Buat kelas `Request.php`, `Response.php`, `Router.php`, dan `View.php`**
- [ ] **Step 4: Buat `public/index.php` sebagai single entry point dengan session & CSRF initialization**
- [ ] **Step 5: Verifikasi index.php dapat diakses dan merespons route dasar**

---

### Task 2: Skema Database & Migrasi
**Files:**
- Create: `database/migrations/001_create_tenants_and_users.sql`
- Create: `database/migrations/002_create_devices_and_api_keys.sql`
- Create: `database/migrations/003_create_messages_and_webhooks.sql`
- Create: `database/migrate.php`
- Create: `database/seed.php`

**Interfaces:**
- Produces: Skema tabel `tenants`, `users`, `plans`, `devices`, `api_keys`, `messages`, `webhook_deliveries`.
- Produces: Seeder data tenant & user demo awal (`admin@nyautwa.test` / `password123`).

- [ ] **Step 1: Tulis script SQL migrasi lengkap dengan foreign key dan indeks performa**
- [ ] **Step 2: Buat runner migrasi `database/migrate.php`**
- [ ] **Step 3: Buat seeder data demo `database/seed.php`**
- [ ] **Step 4: Jalankan migrasi dan seeder untuk memastikan struktur database siap**

---

### Task 3: Core Layouts & Assets Sesuai Design System
**Files:**
- Create: `public/assets/css/design-tokens.css`
- Create: `public/assets/css/app.css`
- Create: `public/assets/js/app.js`
- Create: `app/Views/layouts/app.php`
- Create: `app/Views/layouts/auth.php`
- Create: `app/Views/layouts/landing.php`
- Create: `app/Views/partials/sidebar.php`
- Create: `app/Views/partials/header.php`
- Create: `app/Views/partials/flash.php`

**Interfaces:**
- Produces: Master layout yang mereplikasi secara presisi sidebar, topbar status device, dan container cards dari `docs/design/`.

- [ ] **Step 1: Ekstraksi token warna, font Geist & JetBrains Mono, dan utility CSS ke `design-tokens.css` dan `app.css`**
- [ ] **Step 2: Buat partial `sidebar.php` dengan active state indicator (`#EAF7F0`, `#16A36A`)**
- [ ] **Step 3: Buat partial `header.php` dengan status koneksi device langsung dan avatar profil**
- [ ] **Step 4: Buat layout `app.php` dan `auth.php`**

---

### Task 4: Halaman Landing Publik & Autentikasi
**Files:**
- Create: `app/Controllers/LandingController.php`
- Create: `app/Controllers/AuthController.php`
- Create: `app/Views/landing/index.php`
- Create: `app/Views/auth/login.php`
- Create: `app/Views/auth/register.php`
- Create: `app/Services/AuthService.php`

**Interfaces:**
- Produces: Landing page publik konversi tinggi sesuai `docs/design/nyautwa_whatsapp_gateway_saas_landing_page/code.html`
- Produces: Alur autentikasi login/register aman dengan password hashing dan proteksi CSRF

- [ ] **Step 1: Implementasi `LandingController.php` dan view `landing/index.php` dari design mockup**
- [ ] **Step 2: Implementasi `AuthService.php` untuk autentikasi user dan tenant**
- [ ] **Step 3: Implementasi `AuthController.php`, view `login.php` dan `register.php`**
- [ ] **Step 4: Uji fungsionalitas login/logout dan retensi form input jika error**

---

### Task 5: Dashboard Overview & Telemetri
**Files:**
- Create: `app/Controllers/DashboardController.php`
- Create: `app/Services/DashboardService.php`
- Create: `app/Views/dashboard/index.php`

**Interfaces:**
- Produces: Tampilan dashboard operasional sesuai `docs/design/nyautwa_dashboard_overview/code.html` dengan ringkasan status device aktif, kuota terpakai, dan antrean pesan.

- [ ] **Step 1: Implementasi `DashboardService.php` untuk agregasi metrik pengiriman dan status kuota**
- [ ] **Step 2: Implementasi `DashboardController.php`**
- [ ] **Step 3: Buat view `dashboard/index.php` mengadaptasi mockup pixel-perfect tanpa AI-slop**
- [ ] **Step 4: Verifikasi visual dan navigasi dashboard**

---

### Task 6: Manajemen Koneksi WhatsApp & QR Scanner
**Files:**
- Create: `app/Controllers/DeviceController.php`
- Create: `app/Services/DeviceService.php`
- Create: `app/Views/devices/index.php`
- Create: `app/Views/devices/connect.php`
- Create: `public/assets/js/qr-client.js`

**Interfaces:**
- Produces: Halaman manajemen device dan pairing QR sesuai `docs/design/nyautwa_koneksi_whatsapp/code.html`.

- [ ] **Step 1: Buat `DeviceService.php` untuk CRUD device dan interaksi ke engine internal**
- [ ] **Step 2: Buat `DeviceController.php` dengan endpoint status dan request QR**
- [ ] **Step 3: Buat view `devices/index.php` dan `devices/connect.php` dengan hitung mundur QR dan status auto-detect**
- [ ] **Step 4: Uji simulasi koneksi device dan perubahan status indikator**

---

### Task 7: Riwayat Pengiriman Pesan & Outbox Console
**Files:**
- Create: `app/Controllers/MessageController.php`
- Create: `app/Services/MessageService.php`
- Create: `app/Views/messages/index.php`
- Create: `app/Views/messages/send.php`

**Interfaces:**
- Produces: Tampilan log pengiriman tabular dengan filter status (`Delivered`, `Failed`, `Queued`) dan form kirim pesan langsung dengan pratinjau chat bubble sesuai `docs/design/nyautwa_riwayat_pesan/code.html`.

- [ ] **Step 1: Implementasi `MessageService.php` untuk query log pesan terfilter dan validasi nomor `+62`**
- [ ] **Step 2: Implementasi `MessageController.php`**
- [ ] **Step 3: Buat view `messages/index.php` (tabel data rapat dengan font JetBrains Mono untuk ID & nomor)**
- [ ] **Step 4: Buat form `messages/send.php` dengan live WhatsApp bubble preview**

---

### Task 8: API Keys & Webhook Management
**Files:**
- Create: `app/Controllers/ApiKeyController.php`
- Create: `app/Services/ApiKeyService.php`
- Create: `app/Views/api-keys/index.php`

**Interfaces:**
- Produces: Layar manajemen API Key, salin satu-klik, rotasi token, dan konfigurasi webhook URL sesuai `docs/design/nyautwa_api_keys/code.html`.

- [ ] **Step 1: Implementasi `ApiKeyService.php` untuk generate aman API key (`nyaut_live_...`)**
- [ ] **Step 2: Implementasi `ApiKeyController.php` (buat key baru, cabut/revoke, simpan webhook url)**
- [ ] **Step 3: Buat view `api-keys/index.php` dengan dark code console untuk contoh CURL / Node.js**
- [ ] **Step 4: Uji generate key dan penyalinan clipboard**

---

### Task 9: REST API Publik & Webhook Event Callback
**Files:**
- Create: `app/Controllers/Api/MessageApiController.php`
- Create: `app/Controllers/Api/DeviceApiController.php`
- Create: `app/Middleware/ApiKeyMiddleware.php`
- Create: `app/Middleware/RateLimitMiddleware.php`

**Interfaces:**
- Produces: REST API v1 publik (`POST /api/v1/messages`, `GET /api/v1/devices`, `POST /api/v1/internal/callback`).

- [ ] **Step 1: Implementasi `ApiKeyMiddleware.php` untuk validasi header `Authorization: Bearer <key>`**
- [ ] **Step 2: Implementasi `MessageApiController.php` dengan pengecekan kuota dan deduplikasi idempotency**
- [ ] **Step 3: Implementasi endpoint internal callback dari engine Baileys**
- [ ] **Step 4: Pengujian endpoint via cURL / PowerShell**

---

### Task 10: Baileys WhatsApp Engine (Node.js)
**Files:**
- Create: `engine/package.json`
- Create: `engine/server.js`
- Create: `engine/src/sessionManager.js`
- Create: `engine/src/baileysClient.js`
- Create: `engine/src/config.js`

**Interfaces:**
- Produces: Service internal Baileys di port 3000 dengan header auth `X-Engine-Secret`.

- [ ] **Step 1: Buat konfigurasi `engine/package.json` dengan `@whiskeysockets/baileys`**
- [ ] **Step 2: Buat `sessionManager.js` untuk mengelola multi-sesi multi-device**
- [ ] **Step 3: Buat `server.js` dengan route internal: `/session/start`, `/session/qr`, `/message/send`**
- [ ] **Step 4: Integrasikan callback event ke PHP saat QR keluar dan saat status terhubung**

---

### Task 11: Verifikasi Akhir & Quality Gate
- [ ] Cek kepatuhan terhadap seluruh aturan `AGENTS.md`
- [ ] Uji alur lengkap dari Landing Page -> Login -> Dashboard -> Device Connection -> Pesan -> API Keys
- [ ] Validasi kontras, responsivitas mobile/desktop, dan ketiadaan error log
