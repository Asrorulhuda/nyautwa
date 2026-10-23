# 05 — SaaS, Paket, dan Billing

## 1. Multi-tenant

- Model: tenant (workspace) memiliki banyak user, device, kontak, pesan.
- Semua tabel bisnis punya `tenant_id`. Semua query wajib lewat repository yang menyuntikkan `tenant_id` dari sesi atau API key; tidak ada query tanpa filter tenant.
- v1 memakai satu database bersama (shared schema). Struktur disiapkan agar klien besar bisa dipindah ke database terpisah.
- Tes otomatis wajib memverifikasi tidak ada kebocoran lintas tenant (lihat [07-cicd-deployment.md](07-cicd-deployment.md)).

## 2. Paket dan kuota

| Batasan | Trial 7 hari | Starter | Business | Reseller |
|---|---|---|---|---|
| Device | 1 | 2 | 10 | 50 |
| Pesan keluar / bulan | 200 | 5.000 | 50.000 | Kustom |
| Panggilan API / menit | 30 | 120 | 600 | 1.200 |
| Media | Tidak | Ya | Ya | Ya |
| Campaign | Tidak | Ya | Ya | Ya |
| Anggota tim | 1 | 2 | 10 | 50 |
| Retensi log | 7 hari | 30 hari | 90 hari | 180 hari |

Angka hanya titik awal dan disimpan di tabel `plans`, bukan di-hardcode.

- Kuota habis → API membalas `402` dengan pesan jelas; dashboard memberi peringatan di 80% dan 100%.
- Penghitungan atomik lewat Redis `INCR`, disinkronkan berkala ke database.

## 3. Billing

- Integrasi Midtrans atau Xendit: invoice, VA, e-wallet, QRIS.
- Langganan bulanan dan tahunan; masa tenggang 3 hari sebelum device dijeda.
- Halaman penagihan: paket aktif, pemakaian periode ini, riwayat invoice, tombol upgrade.
- Webhook pembayaran diverifikasi tanda tangannya dan idempoten.

## 4. Panel super admin

- Daftar tenant, status, paket, pemakaian; suspend/aktifkan.
- Kesehatan sistem: sesi aktif, panjang antrean, tingkat gagal, memori proses Node.
- Impersonasi tenant dengan log audit.
- Pengumuman global dan manajemen paket/kupon.

## 5. Syarat dan kebijakan

- Persetujuan eksplisit saat registrasi: layanan tidak resmi dan berisiko pemblokiran nomor.
- Kebijakan penggunaan: dilarang spam, penipuan, konten ilegal; pelanggaran memicu suspend.
- Laporan penyalahgunaan dan opt-out otomatis (balasan STOP menandai kontak tidak boleh dihubungi).
- Kebijakan privasi sesuai UU PDP: data yang disimpan, lama retensi, cara menghapus.
