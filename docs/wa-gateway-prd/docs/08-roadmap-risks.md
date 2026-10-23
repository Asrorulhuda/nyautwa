# 08 — Roadmap, Risiko, dan Pertanyaan Terbuka

## 1. Rencana rilis

| Fase | Perkiraan | Isi |
|---|---|---|
| 0. Fondasi | 1 minggu | Skema DB, struktur PHP, engine Node dasar, komunikasi internal, Docker Compose, **repo + CI/CD + staging** |
| 1. MVP inti | 3–4 minggu | F1–F6, F8, F18, dashboard dasar, QR realtime |
| 2. SaaS dasar | 2–3 minggu | F9, F16, tenant, paket, kuota, API key, harga, syarat & kebijakan |
| 3. Beta tertutup | 2 minggu | 10–20 pengguna, pantau banned dan stabilitas sesi, perbaiki UX |
| 4. v1.1 | 4 minggu | Kontak, template, campaign, billing otomatis, media |
| 5. v1.2 | 4 minggu | Auto reply, inbox, tim dan role, laporan |

Pipeline CI/CD dibangun di **Fase 0**, bukan belakangan, supaya semua kode MVP sudah melewati alur PR → staging → production.

## 2. Risiko dan mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Nomor pelanggan diblokir | Tinggi | Warm-up, rate limit, jeda acak, peringatan jelas, opt-out, sarankan API resmi untuk kasus kritis |
| Baileys rusak karena perubahan protokol | Tinggi | Pin versi, staging, pantau repo upstream, halaman status |
| Penyalahgunaan untuk spam | Tinggi | Persetujuan kebijakan, deteksi pola, suspend, log audit |
| Kebocoran sesi WA | Tinggi | Enkripsi at-rest, jaringan privat, rotasi secret |
| Deploy engine memutus sesi | Menengah | Deploy engine terpisah di jam sepi, pemulihan sesi otomatis, path filter |
| Satu proses Node jadi titik gagal | Menengah | Auto-restart, pemulihan sesi, sharding di v2 |
| Data PHP dan Node tidak konsisten | Menengah | Idempotensi, DB sebagai sumber kebenaran, rekonsiliasi berkala |
| Rilis buruk masuk production | Menengah | Staging wajib, approval manual, backup, rollback otomatis |
| Risiko hukum dan reputasi | Menengah | Syarat layanan jelas, tinjau konsultan hukum sebelum komersial |

## 3. Pertanyaan terbuka

1. Model harga final: paket bulanan, per pesan, atau gabungan?
2. White-label (domain dan logo sendiri) untuk reseller: v1 atau v2?
3. Hosting: satu VPS atau app dan engine dipisah?
4. Perlu enkripsi tingkat kolom untuk isi pesan?
5. Dukungan grup WhatsApp di MVP, atau cukup nomor pribadi?
6. Siapa yang menangani dukungan saat gangguan massal?
7. Berapa orang tim? Ini menentukan jumlah approval wajib di branch protection.
8. Apakah staging dan production di server berbeda (disarankan) atau satu server?
