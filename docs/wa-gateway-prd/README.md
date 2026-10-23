# WA Gateway (Baileys + PHP Native) — Paket PRD

Dokumen perencanaan untuk WhatsApp Gateway **tidak resmi** berbasis Baileys, dengan aplikasi PHP native dan desain **SaaS multi-tenant**.

## Bisa pakai PHP native?

Bisa, kecuali untuk koneksi ke WhatsApp. **Baileys adalah library Node.js**, jadi tidak bisa dijalankan di dalam PHP. Sistem terdiri dari dua proses:

| Lapisan | Teknologi | Tugas |
|---|---|---|
| Aplikasi | PHP 8.2+ native | Dashboard, auth, API publik, billing, kuota, antrean, webhook |
| Engine WA | Node.js 20 + Baileys | Sesi, QR, kirim/terima pesan, status |
| Data | MySQL/MariaDB + Redis | Data tenant, pesan, antrean, rate limit |

Node.js **hanya diakses internal** oleh PHP, tidak pernah terbuka ke publik.

## Daftar dokumen

| File | Isi |
|---|---|
| [docs/01-product-requirements.md](docs/01-product-requirements.md) | Tujuan, persona, cakupan fitur, kebutuhan fungsional, metrik |
| [docs/02-architecture.md](docs/02-architecture.md) | Arsitektur, stack, alur data, struktur folder, model data |
| [docs/03-api-spec.md](docs/03-api-spec.md) | REST API publik dan webhook |
| [docs/04-ui-ux.md](docs/04-ui-ux.md) | Panduan UI/UX, anti AI-slop, daftar layar, interaksi |
| [docs/05-saas-billing.md](docs/05-saas-billing.md) | Multi-tenant, paket, kuota, billing, super admin |
| [docs/06-security-antiban.md](docs/06-security-antiban.md) | Keamanan, strategi anti-ban, non-fungsional |
| [docs/07-cicd-deployment.md](docs/07-cicd-deployment.md) | GitHub CI/CD, branching, alur deploy bertahap |
| [docs/08-roadmap-risks.md](docs/08-roadmap-risks.md) | Rencana rilis, risiko, pertanyaan terbuka |
| [.github/workflows/](.github/workflows/) | Contoh workflow GitHub Actions siap pakai |

## Peringatan risiko

Baileys melanggar Ketentuan Layanan WhatsApp. Nomor yang dipakai berisiko **diblokir permanen**, dan protokol bisa berubah sewaktu-waktu. Untuk kebutuhan kritis (OTP, transaksi bernilai tinggi) sarankan WhatsApp Cloud API resmi. Pelanggan SaaS wajib menyetujui syarat yang menyatakan risiko ini.
