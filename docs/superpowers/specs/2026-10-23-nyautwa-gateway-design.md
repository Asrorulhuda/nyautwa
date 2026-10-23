# NyautWa WhatsApp Gateway SaaS — Spesifikasi & Desain Arsitektur

> **Dokumen Terkait**:
> - PRD: `docs/wa-gateway-prd/docs/`
> - Design System: `docs/design/nyautwa/DESIGN.md`
> - Mockups: `docs/design/` (`nyautwa_dashboard_overview`, `nyautwa_koneksi_whatsapp`, `nyautwa_riwayat_pesan`, `nyautwa_api_keys`, `nyautwa_whatsapp_gateway_saas_landing_page`)
> - Aturan Agen: `AGENTS.md`

---

## 1. Ringkasan Sistem
NyautWa adalah platform WhatsApp Gateway SaaS multi-tenant yang tangguh, dirancang untuk pasar Indonesia. Menggunakan arsitektur Clean MVC berbasis PHP 8.2+ native (tanpa overhead framework raksasa) untuk routing, autentikasi, API publik, manajemen kuota, dan dashboard, serta Node.js 20 LTS dengan Baileys untuk penanganan koneksi WhatsApp multi-device melalui jaringan internal terisolasi.

## 2. Arsitektur Komponen

```
[Browser / Klien REST API]
         |
         v
   [Nginx / Apache (Laragon)]
         |
         v
[public/index.php] -> [App/Core/Router]
         |
    +----+----+
    |         |
[Middleware] [Controllers]
 (Auth, API)  (Dashboard, Device, Messages, ApiKey, Webhook, Auth)
    |         |
    +----+----+
         |
     [Services] (AuthService, DeviceService, MessageService, QuotaService)
         |
   +-----+-----+
   |           |
[MySQL 8]    [Redis 7]
(State & Log) (Queue & Rate Limit)
   |           |
   +-----+-----+
         | (HTTP internal + shared secret)
         v
[engine/server.js] (Baileys WhatsApp Engine)
```

## 3. Komponen Desain & UI/UX (Sesuai `DESIGN.md`)
- **Tokens Warna**:
  - Background Canvas: `#F6F8F7`
  - Container / Surface: `#FFFFFF`, border hairline `1px solid #E4EAE6`
  - Primary Accent: `#16A36A`, hover `#128557`, soft badge `#EAF7F0`
  - Dark Surface: `#17211F` (panel code / terminal / dark sidebar)
  - Teks: `#17211F` (primary), `#697570` (muted)
- **Tipografi**:
  - Sans-serif: `Geist` untuk antarmuka, judul, dan form.
  - Monospace: `JetBrains Mono` untuk nomor telepon (`+62...`), API key, hash, latensi, dan log.
- **Copywriting**: Bahasa Indonesia bisnis yang lugas, sopan, dan transparan mengenai risiko anti-ban.

## 4. Struktur Database & Model Data (MySQL 8)
- `tenants`: id, name, plan_id, status, trial_ends_at, created_at, updated_at
- `users`: id, tenant_id, name, email, password_hash, role, created_at
- `plans`: id, name, limits_json, price_monthly, price_yearly
- `devices`: id, tenant_id, label, phone, status, session_ref, webhook_url, webhook_secret, daily_limit, created_at
- `api_keys`: id, tenant_id, name, key_hash, prefix, last_used_at, revoked_at, created_at
- `messages`: id, tenant_id, device_id, direction, to_from, type, body, status, wa_message_id, idempotency_key, error, queued_at, sent_at, created_at
- `webhook_deliveries`: id, tenant_id, device_id, event, payload, attempts, last_status, next_retry_at, created_at

## 5. REST API Publik
- `POST /api/v1/messages`: Kirim pesan teks/media dengan header `Authorization: Bearer <api_key>`
- `GET /api/v1/messages/{id}`: Cek status pesan
- `GET /api/v1/devices`: Daftar device dan status
- `POST /api/v1/devices/{id}/qr`: Request QR baru untuk scanning
