# 04 — Panduan UI/UX

Dokumen ini sengaja tegas supaya hasil akhir tidak terasa seperti template generik hasil AI.

## 1. Prinsip

1. **Alat kerja, bukan brosur.** Dashboard dipakai berulang tiap hari; utamakan kepadatan informasi yang nyaman dibaca.
2. **Satu halaman, satu tugas utama.** Satu tombol aksi utama per layar.
3. **Status selalu terlihat.** Kondisi device terlihat dari halaman mana pun.
4. **Bahasa manusia.** Error menjelaskan apa yang terjadi dan langkah berikutnya.
5. **Jujur soal risiko.** Peringatan banned muncul di tempat relevan (kirim massal, device baru), bukan disembunyikan di T&C.

## 2. Yang dilarang (anti AI-slop)

- Gradasi ungu-biru, glassmorphism, blob dekoratif, glow neon.
- Hero besar dengan slogan kosong ("Revolusionerkan komunikasi bisnis Anda").
- Kartu statistik dekoratif yang tidak bisa diklik atau tidak berguna.
- Ikon generik di setiap baris tanpa fungsi, emoji sebagai pengganti ikon, ilustrasi stok 3D.
- Placeholder bergaya marketing di dalam aplikasi ("Seamless", "Powerful", "All-in-one").
- Animasi yang menghambat kerja (transisi > 200 ms, loading panjang).
- Testimoni dan logo klien palsu di landing page.

## 3. Sistem visual

**Warna**
- Satu warna aksen (hijau tua atau teal, jangan menyerupai logo WhatsApp), netral hangat untuk latar dan teks.
- Warna status konsisten di seluruh aplikasi: hijau = terhubung/terkirim, kuning = menunggu, merah = gagal/putus, abu = nonaktif.
- Kontras minimal WCAG AA. Status tidak boleh hanya dibedakan lewat warna; sertakan teks atau ikon.

**Tipografi**
- Satu sans-serif yang terbaca di ukuran kecil (Inter, IBM Plex Sans, atau font sistem) dan satu monospace untuk nomor, ID, kode API.
- Ukuran dasar 14 px untuk tabel, 16 px untuk form.

**Spasi dan bentuk**
- Grid 4/8 px, radius 4–6 px, border tipis ketimbang bayangan tebal.
- Tabel adalah komponen utama: header lengket, kolom bisa diurutkan, baris bisa diklik, aksi massal.

**Tema dan responsif**
- Mode gelap sejak awal lewat variabel CSS.
- Nyaman di tablet; di ponsel minimal bisa cek status device, baca log, dan kirim pesan.

## 4. Daftar layar

| Area | Layar | Isi inti |
|---|---|---|
| Publik | Landing, harga, dokumentasi API, login, daftar | Landing berisi demo request/respons nyata, harga transparan, risiko dijelaskan |
| Onboarding | Panduan 3 langkah | Tambah device → scan QR → kirim pesan uji (< 2 menit) |
| Dashboard | Ringkasan | Status device, pemakaian kuota, pesan gagal terbaru yang perlu tindakan |
| Device | Daftar, detail | Status, QR, webhook, batas harian, log koneksi |
| Pesan | Kirim, log | Form dengan pratinjau gelembung chat; tabel log berfilter |
| Kontak | Daftar, grup, import | Import CSV dengan pratinjau dan validasi per baris |
| Campaign | Buat, jadwal, laporan | Langkah bertahap, estimasi durasi, tombol jeda |
| Developer | API key, webhook, log webhook | Salin sekali klik, uji webhook, kirim ulang |
| Penagihan | Paket, invoice, pemakaian | Bandingkan paket, riwayat tagihan |
| Pengaturan | Profil, tim, keamanan | 2FA, anggota, log aktivitas |
| Super admin | Tenant, sistem, paket | Tabel tenant, kesehatan sistem, impersonasi |

## 5. Detail interaksi

- **Scan QR:** QR besar, instruksi 3 langkah singkat, hitung mundur kedaluwarsa, tombol muat ulang, status berubah otomatis saat terhubung (tanpa refresh).
- **Kondisi kosong:** menjelaskan langkah berikutnya dengan satu tombol ("Belum ada device — Tambah device").
- **Kondisi error:** device terputus tampil sebagai banner di atas semua halaman dengan tombol *Sambungkan ulang*.
- **Kirim massal:** sebelum mulai, tampilkan ringkasan (jumlah penerima, estimasi durasi, batas kecepatan, peringatan risiko) dan wajib konfirmasi.
- **Aksi destruktif:** dialog menyebut apa yang akan hilang, bukan sekadar "Yakin?".
- **Loading:** skeleton pada tabel, bukan spinner layar penuh.
- **Keyboard:** pencarian cepat (`/`), tabel bisa dinavigasi keyboard, `Ctrl+Enter` untuk kirim.
- **Salin cepat:** semua ID, API key, URL webhook punya tombol salin dengan umpan balik singkat.
- **Formulir:** validasi inline, error di samping field, data tidak hilang saat gagal submit.

## 6. Copywriting

Bahasa Indonesia lugas, kalimat aktif, tanpa jargon marketing.

| Buruk | Baik |
|---|---|
| Oops! Something went wrong. | Device terputus sejak 10:42. Sambungkan ulang agar 12 pesan di antrean bisa dikirim. |
| Berhasil! 🎉 | Pesan masuk antrean. Perkiraan terkirim dalam 8 detik. |
| Kuota Anda hampir habis | Sisa 120 dari 5.000 pesan. Reset 1 November. |

Siapkan lokalisasi Inggris dengan file bahasa terpisah sejak awal.

## 7. Aksesibilitas

Label form yang benar, fokus keyboard terlihat, ukuran target sentuh ≥ 40 px, `aria-live` untuk perubahan status device, hormati `prefers-reduced-motion`.

## 8. Checklist review desain

- [ ] Apakah ada elemen yang hanya dekorasi? Hapus.
- [ ] Apakah aksi utama jelas dalam 3 detik?
- [ ] Apakah semua status punya warna + teks?
- [ ] Apakah setiap kondisi kosong/error/loading sudah dirancang?
- [ ] Apakah teks error memberi langkah berikutnya?
- [ ] Apakah lolos kontras AA di mode terang dan gelap?
