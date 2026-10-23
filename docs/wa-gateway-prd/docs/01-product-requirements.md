# 01 — Product Requirements

**Versi:** 1.0 draft · **Tanggal:** 23 Oktober 2026

## 1. Ringkasan produk

Platform yang memungkinkan pengguna menghubungkan nomor WhatsApp lewat scan QR, lalu mengirim dan menerima pesan lewat dashboard maupun REST API. Dirancang multi-tenant sejak awal agar bisa dijual sebagai SaaS.

## 2. Tujuan

1. Pengguna menghubungkan nomor WA dalam kurang dari 2 menit.
2. Kirim pesan lewat dashboard dan REST API dengan dokumentasi jelas.
3. Pesan masuk dan status pengiriman diterima lewat webhook.
4. Satu instalasi melayani banyak tenant dengan isolasi data dan kuota per paket.
5. Menekan risiko banned lewat rate limit, jeda acak, dan antrean.
6. UI cepat dan jelas, terasa dibuat untuk operasional nyata (lihat [04-ui-ux.md](04-ui-ux.md)).

## 3. Non-tujuan (v1)

- Tidak membangun chatbot AI atau flow builder visual.
- Tidak membangun aplikasi mobile native.
- Tidak mengintegrasikan WhatsApp Business API resmi (roadmap saja).
- Tidak menyediakan fitur spam, scraping kontak, atau blast tanpa izin.

## 4. Persona

| Persona | Kebutuhan | Perilaku |
|---|---|---|
| Pemilik UMKM / admin toko | Kirim notifikasi order, balas pelanggan | Non-teknis, butuh tombol jelas |
| Developer / integrator | Kirim pesan dari aplikasi sendiri | Baca dokumentasi, pakai API key dan webhook |
| Reseller / agensi | Kelola banyak klien dan nomor | Butuh pemisahan workspace |
| Super admin | Kelola tenant, paket, tagihan, kesehatan sistem | Butuh monitoring dan kontrol manual |

## 5. Cakupan fitur

| ID | Fitur | Prioritas | Rilis |
|---|---|---|---|
| F1 | Registrasi, login, reset password, 2FA opsional | P0 | MVP |
| F2 | Manajemen device: tambah, scan QR, status, logout, hapus | P0 | MVP |
| F3 | Kirim pesan teks via dashboard | P0 | MVP |
| F4 | REST API kirim pesan + API key | P0 | MVP |
| F5 | Webhook pesan masuk dan status | P0 | MVP |
| F6 | Log pesan dan filter | P0 | MVP |
| F7 | Kirim media (gambar, dokumen, audio) | P1 | MVP |
| F8 | Antrean + rate limit + jeda acak | P0 | MVP |
| F9 | Paket, kuota, pembatasan | P0 | MVP |
| F10 | Kontak, grup, import CSV | P1 | v1.1 |
| F11 | Template pesan dengan variabel | P1 | v1.1 |
| F12 | Kirim massal terjadwal (campaign) | P1 | v1.1 |
| F13 | Auto reply kata kunci | P2 | v1.2 |
| F14 | Inbox percakapan sederhana | P2 | v1.2 |
| F15 | Billing otomatis (Midtrans/Xendit) | P1 | v1.1 |
| F16 | Panel super admin | P0 | MVP |
| F17 | Anggota tim dan role | P2 | v1.2 |
| F18 | Dokumentasi API publik + contoh kode | P0 | MVP |

## 6. Kebutuhan fungsional

### 6.1 Autentikasi dan akun (F1)
- Registrasi email + password (Argon2id), verifikasi email sebelum bisa membuat device.
- Proteksi brute force: maks 5 gagal per 15 menit per IP+email.
- Reset password lewat token sekali pakai, berlaku 30 menit.
- Cookie `HttpOnly`, `Secure`, `SameSite=Lax`; token CSRF di semua form.

### 6.2 Manajemen device (F2)
- Tambah device dengan label, scan QR yang diperbarui otomatis (SSE).
- Status: `pending_qr`, `connecting`, `connected`, `disconnected`, `banned_suspected`, `logged_out`.
- Aksi: reconnect, logout, hapus, ganti nama.
- Reconnect otomatis dengan backoff (5 dtk, 15 dtk, 60 dtk, 5 mnt), lalu tandai `disconnected` dan kirim email ke pemilik.
- Jumlah device dibatasi per paket.

### 6.3 Kirim pesan (F3, F4, F7)
- Jenis: teks, gambar, dokumen, audio, lokasi (media maks 16 MB).
- Normalisasi nomor ke format internasional (08xx → 628xx), cek nomor via `onWhatsApp`, cache 24 jam.
- `idempotency_key` opsional agar request ulang tidak menggandakan kiriman.
- API langsung membalas `202 Accepted`; status akhir lewat webhook atau polling.

### 6.4 Webhook (F5)
- Satu URL per device + secret untuk tanda tangan HMAC-SHA256 (`X-Signature`).
- Event: `message.received`, `message.sent`, `message.delivered`, `message.read`, `message.failed`, `device.connected`, `device.disconnected`.
- Retry 5 kali dengan backoff eksponensial, timeout 10 detik, riwayat terlihat di dashboard dengan tombol kirim ulang.

### 6.5 Antrean dan anti-ban (F8)
Rinci di [06-security-antiban.md](06-security-antiban.md).

### 6.6 Log pesan (F6)
- Filter: device, arah, status, rentang waktu, nomor.
- Detail menampilkan timeline status dan payload webhook terkait.
- Retensi isi pesan sesuai paket (default 30 hari), setelahnya hanya metadata.

### 6.7 Fitur lanjutan
- **Kontak (F10):** import CSV dengan pratinjau dan laporan baris gagal, grup, kolom kustom.
- **Template (F11):** variabel `{{nama}}`, pratinjau dengan data contoh.
- **Campaign (F12):** pilih template, grup, jadwal, kecepatan; bisa dijeda dan dilanjutkan; ada laporan hasil.
- **Auto reply (F13):** aturan kata kunci (persis, mengandung, regex dasar), jam aktif, batas balasan per kontak per hari.

## 7. Metrik keberhasilan

| Metrik | Target |
|---|---|
| Aktivasi (device terhubung + 1 pesan terkirim di sesi pertama) | ≥ 70% |
| Waktu ke pesan pertama (median) | < 3 menit |
| Pesan berstatus `sent` dari yang diterima API | ≥ 97% |
| Device tetap terhubung 7 hari tanpa intervensi | ≥ 95% |
| Tingkat banned per bulan (pengguna yang ikuti panduan) | < 5% |
| Konversi trial ke berbayar | 8–12% |
| Tiket dukungan per 100 pengguna per bulan | < 15 |
