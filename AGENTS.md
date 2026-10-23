# ATURAN & PROTOKOL AGENT — NYAUTWA (WA GATEWAY SAAS)

> Dokumen ini adalah **Hukum Tertinggi (Single Source of Truth)** bagi seluruh AI agent dan developer yang berkontribusi pada repositori **NyautWa**. Pelanggaran terhadap panduan ini dianggap sebagai cacat kode (*defect*).

---

## 1. Prinsip Utama: Anti-AI Slop & Larangan Keluar dari Docs

Semua pengerjaan **WAJIB** tunduk 100% pada dokumentasi di dalam folder:
1. `docs/wa-gateway-prd/docs/`
   - `01-product-requirements.md` (Kebutuhan fungsional, persona, metrik, anti-ban)
   - `02-architecture.md` (Arsitektur sistem, skema database, struktur folder)
   - `03-api-spec.md` (Spesifikasi REST API publik dan webhook)
   - `04-ui-ux.md` (Panduan tegas UI/UX, anti AI-slop, alur interaksi)
   - `05-saas-billing.md` (Multi-tenant, paket langganan, kuota, invoice)
   - `06-security-antiban.md` (Keamanan sesi, rate limit, rotasi token, enkripsi)
   - `07-cicd-deployment.md` (Workflow GitHub Actions, deployment)
   - `08-roadmap-risks.md` (Roadmap fitur dan manajemen risiko)
2. `docs/design/`
   - `nyautwa/DESIGN.md` (Design system, tokens, warna, tipografi, elevasi, komponen)
   - `nyautwa_dashboard_overview/` (Referensi visual dashboard utama)
   - `nyautwa_koneksi_whatsapp/` (Referensi visual halaman koneksi & QR device)
   - `nyautwa_riwayat_pesan/` (Referensi visual log pengiriman pesan)
   - `nyautwa_api_keys/` (Referensi visual manajemen API key & webhook)
   - `nyautwa_whatsapp_gateway_saas_landing_page/` (Referensi visual landing page publik)

**DILARANG KERAS**:
- Mengarang fitur, halaman, atau dependensi di luar PRD tanpa persetujuan eksplisit.
- Menghasilkan antarmuka generik "AI-slop" (gradasi ungu/biru, glassmorphism, blob neon, ilustrasi kartun 3D, kartu metrik hiasan tanpa aksi).
- Memakai copywriting robotik atau klise ("Revolusi bisnis Anda", "All-in-one powerful solution", "Oops, something went wrong").

---

## 2. Design System & Standar UI/UX (Mengacu pada `docs/design/nyautwa/DESIGN.md`)

### A. Palet Warna Resmi
- **Canvas / Background**: `#F6F8F7` (Background aplikasi yang tenang & ergonomis).
- **Surface / Container**: `#FFFFFF` dengan border tipis `1px solid #E4EAE6` (Tanpa drop shadow tebal).
- **Aksen Primer**: `#16A36A` (Brand utama), `#128557` (Hover/pressed state), `#EAF7F0` (Soft tint container).
- **Dark Surface**: `#17211F` (Untuk sidebar alternatif, panel code API, atau console).
- **Teks**: `#17211F` (Primary), `#697570` (Secondary/muted metadata).
- **Status Indikator**:
  - Connected / Live / Success: `#16865A` (Badge `#EAF7F0`, dot pulsasi).
  - Pending / Antrean / Warning: `#D99124` (Badge `#FEF6E7`).
  - Disconnected / Failed / Error: `#D84B4B` (Badge `#FDF0F0`).
  - Inactive / Revoked: `#697570` (Badge `#F0F4F2`).

### B. Tipografi
- **Interface & Content**: Font `Geist` (atau fallback clean sans-serif seperti Inter).
- **Technical & Numbers**: Font `JetBrains Mono` untuk seluruh API key, hash sesi, format nomor telepon (`+62...`), durasi latensi (`42ms`), timestamp log, dan angka kuota/keuangan (`font-feature-settings: "tnum"`).

### C. Bentuk & Spacing
- Grid baseline **8px** (half-step 4px).
- Radius sudut konsisten: **8px (`rounded-md` / `0.5rem`)** untuk input, tombol, badge, dan modal. Radius `16px` (`rounded-lg`) untuk kartu besar dan panel QR.
- Hindari shadow tebal; gunakan border hairline `1px solid #E4EAE6` dan ambient elevation minimalis.

### D. Copywriting & Bahasa
- Seluruh navigasi, alur kerja, form, notifikasi, dan pesan error menggunakan **Bahasa Indonesia bisnis yang lugas, sopan, dan jelas**:
  - ❌ *"Oops! Terjadi kesalahan pada sistem."*
  - ✅ *"Device terputus sejak 10:42. Silakan scan ulang QR agar 15 pesan antrean dapat terkirim."*
  - ❌ *"Sukses!"*
  - ✅ *"Pesan berhasil dijadwalkan ke antrean. Perkiraan terkirim dalam 5 detik."*
- Elemen teknis pengembang (HTTP method `POST`/`GET`, webhook payload JSON, field API) tetap dalam bahasa Inggris teknis baku.

---

## 3. Standar Arsitektur & Rekayasa Kode (Senior Code Craft)

### A. Backend PHP Native (PHP 8.2+)
- Menggunakan arsitektur **Clean MVC**:
  - `app/Controllers/`: Controller ramping (orchestrator: validasi input -> panggil service/model -> render view/JSON).
  - `app/Services/`: Logika bisnis murni (`DeviceService`, `MessageService`, `QuotaService`, `WebhookService`, `AuthService`).
  - `app/Repositories/` / `app/Models/`: Akses data database.
  - `app/Middleware/`: Autentikasi sesi, validasi API Key tenant, rate limiter.
  - `app/Views/`: Template PHP native bersih tanpa query database atau kalkulasi bisnis rumit.
- **Keamanan Wajib**:
  - Semua query database **100% wajib menggunakan PDO Prepared Statements**. Dilarang interpolasi variabel SQL langsung.
  - Semua form mutasi (POST, PUT, DELETE) wajib menyertakan token CSRF.
  - Seluruh output dinamis ke HTML wajib diescape dengan `htmlspecialchars($data, ENT_QUOTES, 'UTF-8')`.
  - Password wajib di-hash menggunakan `password_hash($pass, PASSWORD_BCRYPT)`.
  - Form validation failure wajib mempertahankan input lama pengguna (`old_inputs`) agar form tidak ter-reset.

### B. Engine Baileys (Node.js 20 LTS)
- Diletakkan di folder `/engine`.
- **Hanya diakses melalui jaringan internal** oleh PHP backend (menggunakan shared secret token pada header HTTP `X-Engine-Secret`).
- Tidak boleh mengekspos endpoint langsung ke publik.
- Mengirimkan callback event kembali ke PHP (`/internal/engine-callback`) untuk status QR, koneksi, pesan masuk, dan ack pengiriman.

### C. Database & Caching
- MySQL 8 / MariaDB dengan charset `utf8mb4_unicode_ci`.
- Redis 7 untuk rate limiting, job antrean pesan outbox, dan webhook retry worker.

---

## 4. Struktur Direktori Proyek

```
c:\laragon\www\nyautwa\
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── DeviceController.php
│   │   ├── MessageController.php
│   │   ├── ApiKeyController.php
│   │   ├── WebhookController.php
│   │   └── Api/
│   ├── Services/
│   ├── Models/
│   ├── Repositories/
│   ├── Middleware/
│   ├── Core/
│   │   ├── Router.php
│   │   ├── Database.php
│   │   ├── View.php
│   │   ├── Request.php
│   │   └── Session.php
│   └── Views/
│       ├── layouts/
│       │   ├── app.php
│       │   ├── auth.php
│       │   ├── landing.php
│       │   └── partials/
│       │       ├── sidebar.php
│       │       ├── header.php
│       │       └── flash.php
│       ├── dashboard/
│       ├── devices/
│       ├── messages/
│       ├── api-keys/
│       └── auth/
├── config/
│   ├── app.php
│   └── database.php
├── database/
│   ├── migrations/
│   └── seeds/
├── docs/
│   ├── design/
│   └── wa-gateway-prd/
├── engine/             # Node.js 20 + Baileys internal gateway engine
│   ├── src/
│   ├── package.json
│   └── server.js
├── public/
│   ├── index.php
│   └── assets/
│       ├── css/
│       │   ├── design-tokens.css
│       │   └── app.css
│       └── js/
│           ├── app.js
│           └── qr-scanner.js
├── workers/
│   ├── queue_worker.php
│   └── webhook_worker.php
├── .env.example
├── AGENTS.md
└── composer.json
```

---

## 5. Checklist Verifikasi Sebelum Menyatakan Selesai
Setiap task wajib melalui checklist ini:
- [ ] Apakah desain persis mengikuti tokens di `docs/design/nyautwa/DESIGN.md` dan mockups di `docs/design/`?
- [ ] Apakah ada elemen dekoratif AI-slop yang melanggar `docs/04-ui-ux.md`? (Jika ada, hapus segera).
- [ ] Apakah seluruh interaksi form mempertahankan state (`old_inputs`) dan aman dari CSRF & XSS?
- [ ] Apakah seluruh query database menggunakan PDO parameter binding?
- [ ] Apakah copywriting sudah menggunakan Bahasa Indonesia yang manusiawi, informatif, dan jelas?
