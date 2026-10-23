# 06 — Keamanan, Anti-Ban, dan Non-Fungsional

## 1. Strategi anti-ban

Tidak ada jaminan bebas banned. Tujuannya menurunkan risiko.

- Antrean per device, diproses berurutan.
- Jeda acak antar pesan default 3–9 detik (bisa diatur dalam batas paket).
- Batas harian per device; default 500 untuk nomor yang sudah matang.
- **Warm-up** nomor baru: 20 pesan di hari pertama, naik 50% per hari sampai batas paket.
- Simulasi `composing` sebelum kirim, durasi sebanding panjang teks.
- Auto-stop kirim massal jika tingkat gagal > 20% dalam 50 pesan terakhir; device ditandai untuk ditinjau.
- Dukungan spintax dan variabel untuk memvariasikan isi pesan massal.
- Opt-out otomatis (STOP) dan larangan kirim ke kontak yang opt-out.
- Peringatan risiko di UI saat kirim massal dan saat device baru.

## 2. Keamanan

- HTTPS wajib, HSTS, header keamanan (CSP, X-Frame-Options, Referrer-Policy).
- Prepared statement untuk semua query; escape output; validasi input di server.
- Password Argon2id; API key disimpan sebagai hash; secret webhook dan sesi WA dienkripsi (libsodium).
- Node engine hanya mendengarkan di jaringan privat, dengan shared secret; tolak semua request tanpa tanda tangan.
- Rate limit per IP dan per API key.
- Perlindungan SSRF pada URL webhook: blokir IP privat, loopback, metadata cloud, dan redirect ke alamat tersebut.
- Log audit untuk aksi sensitif.
- Backup harian database dan penyimpanan sesi; pemulihan diuji berkala.
- Kepatuhan UU PDP untuk data pesan dan kontak.
- Pemindaian dependensi dan secret otomatis di CI (lihat [07-cicd-deployment.md](07-cicd-deployment.md)).

## 3. Non-fungsional

| Aspek | Target |
|---|---|
| Latensi API kirim pesan | p95 < 300 ms (hanya menulis ke antrean) |
| Kapasitas MVP | ≥ 50 sesi aktif, 20 pesan/detik agregat per node |
| Pemulihan sesi setelah restart | < 60 detik |
| Ketahanan pesan | Tidak hilang saat Node restart (antrean persisten + idempotensi) |
| Uptime API | 99,5% (tanpa menjamin ketersediaan WhatsApp) |
| Monitoring | Log terstruktur; alert saat sesi massal putus, antrean menumpuk, tingkat gagal naik |

## 4. Kemudahan perawatan

- Migrasi database berversi, seeding paket default.
- Konfigurasi lewat `.env`; deploy lewat Docker Compose.
- Update Baileys diuji di staging dengan nomor uji sebelum produksi.
