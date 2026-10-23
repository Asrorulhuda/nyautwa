# 03 — Spesifikasi API Publik (v1)

**Autentikasi:** `Authorization: Bearer <API_KEY>`. Key hanya ditampilkan sekali saat dibuat; yang disimpan hanya hash.

## Endpoint

| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/api/v1/devices` | Daftar device dan status |
| POST | `/api/v1/devices` | Buat device baru |
| GET | `/api/v1/devices/{id}/qr` | Ambil QR jika menunggu scan |
| POST | `/api/v1/devices/{id}/logout` | Putuskan sesi |
| POST | `/api/v1/messages` | Kirim pesan (teks/media) |
| POST | `/api/v1/messages/bulk` | Kirim ke banyak nomor (masuk antrean) |
| GET | `/api/v1/messages/{id}` | Detail dan status pesan |
| GET | `/api/v1/messages` | Daftar dengan filter, paginasi kursor |
| POST | `/api/v1/numbers/check` | Cek nomor terdaftar di WhatsApp |
| GET | `/api/v1/usage` | Pemakaian dan sisa kuota |

## Kirim pesan

```http
POST /api/v1/messages
Authorization: Bearer <API_KEY>
Content-Type: application/json

{
  "device_id": "dev_01H...",
  "to": "6281234567890",
  "type": "text",
  "text": "Pesanan #1042 sudah dikirim.",
  "idempotency_key": "order-1042-shipped"
}
```

Respons `202 Accepted`:

```json
{ "id": "msg_01H...", "status": "queued" }
```

## Format error

```json
{ "error": { "code": "quota_exceeded", "message": "Kuota pesan bulan ini habis." } }
```

Kode HTTP: `400`, `401`, `402` (kuota), `404`, `409` (idempotensi bentrok), `422`, `429` (rate limit), `503`.

## Webhook

Dikirim `POST` ke URL device dengan header:

- `X-Signature: sha256=<HMAC-SHA256(body, webhook_secret)>`
- `X-Event: message.received`
- `X-Delivery-Id: <uuid>`

Contoh payload `message.received`:

```json
{
  "event": "message.received",
  "device_id": "dev_01H...",
  "message": {
    "id": "msg_01H...",
    "from": "6281234567890",
    "type": "text",
    "text": "Halo",
    "timestamp": "2026-10-23T10:42:00Z"
  }
}
```

Aturan: respons `2xx` dalam 10 detik dianggap sukses. Selain itu retry 5 kali (backoff eksponensial). Penerima wajib memverifikasi `X-Signature` dan memakai `X-Delivery-Id` untuk deduplikasi.

## Rate limit

Header respons: `X-RateLimit-Limit`, `X-RateLimit-Remaining`, `X-RateLimit-Reset`. Batas per menit mengikuti paket.

## Versioning

Perubahan yang merusak kompatibilitas hanya lewat versi baru (`/api/v2`). Versi lama didukung minimal 6 bulan setelah pengumuman deprecation.
