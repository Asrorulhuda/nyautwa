# 02 — Arsitektur

## 1. Diagram

```
[Browser / Klien API]
        |
        v  HTTPS
[Nginx] --> [PHP-FPM: aplikasi native]
                 |        |         |
                 |        |         +--> [Worker PHP: antrean & webhook]
                 |        v                    |
                 |     [MySQL]              [Redis]
                 |                             ^
                 v  HTTP internal + secret     |
          [Node.js: Baileys Engine] -----------+
                 |   (event: qr, status, pesan masuk)
                 v
            [WhatsApp]
```

## 2. Tech stack

| Komponen | Pilihan | Catatan |
|---|---|---|
| Bahasa app | PHP 8.2+ | Tanpa framework penuh, struktur sendiri |
| Router | FastRoute atau router buatan sendiri | Composer untuk library kecil |
| Template | PHP native + partial | Logika berat jangan di view |
| Database | MySQL 8 / MariaDB 10.6 | utf8mb4 |
| Cache & antrean | Redis 7 | |
| Engine WA | Node.js 20 LTS + Baileys + Fastify | Hanya internal |
| Process manager | Supervisor (PHP worker), PM2 atau Docker restart policy (Node) | |
| Web server | Nginx | |
| Frontend | HTML + CSS native + Alpine.js/vanilla | Tanpa React/Vue di v1 |
| Realtime | Server-Sent Events dari PHP | Lebih sederhana dari WebSocket di PHP |
| Kontainer | Docker + Docker Compose | Basis deploy dan CI/CD |

## 3. Alur kirim pesan

1. Klien `POST /api/v1/messages` dengan API key.
2. PHP validasi key, kuota, format nomor; simpan pesan status `queued`.
3. Worker PHP mengambil dari antrean sesuai rate limit sesi, memanggil Node engine.
4. Engine kirim via Baileys, kembalikan `wa_message_id`.
5. Status `sent/delivered/read/failed` dikirim balik dari Node ke PHP lewat callback internal, lalu diteruskan ke webhook pelanggan.

## 4. Alur pesan masuk

Node menerima `messages.upsert` → kirim ke endpoint internal PHP → PHP simpan → jalankan webhook ke URL tenant dengan retry.

## 5. Keputusan teknis

- **Sesi Baileys** disimpan persisten dan terenkripsi, satu record per device, wajib di-backup.
- **Satu proses Node memegang banyak sesi** di v1 (awal 50 sesi/proses); sharding per `device_id` di v2.
- **PHP ke Node** lewat HTTP internal + shared secret + whitelist jaringan privat, tanpa CORS terbuka.
- **Antrean** memakai Redis list/stream dengan worker PHP CLI di bawah Supervisor.
- **Sumber kebenaran status** ada di database PHP; Node hanya melaporkan event. Ada rekonsiliasi berkala.
- **Idempotensi** di setiap langkah agar restart Node tidak menghilangkan atau menggandakan pesan.

## 6. Struktur folder

```
/app
  /Controllers
  /Services      (DeviceService, MessageService, QuotaService, WebhookService)
  /Repositories
  /Middleware    (Auth, ApiKey, RateLimit, Tenant)
  /Views
/public          (index.php, assets)
/workers         (queue_worker.php, webhook_worker.php)
/engine          (proyek Node: Baileys)
/migrations
/config
/tests
/docker
/.github/workflows
```

## 7. Model data

| Tabel | Kolom penting |
|---|---|
| `tenants` | id, name, plan_id, status, trial_ends_at, created_at |
| `users` | id, tenant_id, email, password_hash, role, email_verified_at, totp_secret |
| `plans` | id, name, limits_json, price_monthly, price_yearly |
| `subscriptions` | id, tenant_id, plan_id, status, period_start, period_end |
| `invoices` | id, tenant_id, amount, status, gateway_ref, paid_at |
| `devices` | id, tenant_id, label, phone, status, session_ref, webhook_url, webhook_secret, daily_limit, warmup_started_at |
| `api_keys` | id, tenant_id, name, key_hash, last_used_at, revoked_at |
| `messages` | id, tenant_id, device_id, direction, to_from, type, body, media_ref, status, wa_message_id, idempotency_key, error, queued_at, sent_at |
| `message_events` | id, message_id, status, occurred_at |
| `webhook_deliveries` | id, tenant_id, device_id, event, payload, attempts, last_status, next_retry_at |
| `contacts` | id, tenant_id, phone, name, attrs_json, opted_out_at |
| `contact_groups`, `contact_group_members` | relasi kontak ke grup |
| `templates` | id, tenant_id, name, body |
| `campaigns` | id, tenant_id, device_id, template_id, group_id, scheduled_at, status, rate_config |
| `auto_replies` | id, tenant_id, device_id, match_type, keyword, reply_body, active |
| `usage_counters` | tenant_id, period, messages_out, api_calls |
| `audit_logs` | id, tenant_id, user_id, action, meta_json, ip, created_at |

Indeks wajib: `(tenant_id, created_at)` di `messages`, `(device_id, status)`, `idempotency_key` unik per tenant.

## 8. Konfigurasi lingkungan

Semua konfigurasi lewat `.env` (tidak di-commit). Minimal: `APP_ENV`, `APP_KEY`, `DB_*`, `REDIS_URL`, `ENGINE_URL`, `ENGINE_SECRET`, `SESSION_ENC_KEY`, `MAIL_*`, `PAYMENT_*`. Nilai rahasia produksi disimpan di GitHub Environments secrets atau secret manager di server, bukan di repo.
