# ATURAN & PROTOKOL AGENT — NYAUTWA (WA GATEWAY SAAS)

> Dokumen ini adalah **Hukum Tertinggi (Single Source of Truth)** bagi seluruh AI agent dan developer yang berkontribusi pada repositori **NyautWa**. Pelanggaran terhadap panduan ini dianggap sebagai cacat kode (*defect*).

---

## 1. Prinsip Utama: Anti-AI Slop & Larangan Keluar dari Docs

Semua pengerjaan **WAJIB** tunduk 100% pada dokumentasi di dalam folder:
1. `docs/wa-gateway-prd/docs/`
2. `docs/design/` (Seluruh file `code.html` dan `screen.png` adalah cetak biru mutlak desain visual UI).

**DILARANG KERAS**:
- Mengarang fitur, halaman, atau dependensi di luar PRD tanpa persetujuan eksplisit.
- Menghasilkan antarmuka generik "AI-slop" (gradasi ungu/biru, glassmorphism, blob neon, ilustrasi kartun 3D, kartu metrik hiasan tanpa aksi).
- Memakai copywriting robotik atau klise ("Revolusi bisnis Anda", "All-in-one powerful solution", "Oops, something went wrong").
- **FILE MELEBIHI 100 BARIS**: Seluruh file di dalam repositori (baik PHP Controller, Service, Model, View template, Component, JavaScript, maupun CSS/HTML) **TIDAK BOLEH LEBIH DARI 100 BARIS KODE** (`<= 100 lines per file`). Jika mendekati/melebihi 100 baris, **WAJIB DIPENDEKKAN & DIPECAH** menjadi sub-komponen, partial views, traits, atau sub-services modular.

---

## 2. Design System & Standar UI/UX (Mengacu pada `docs/design/nyautwa/DESIGN.md`)

### A. Palet Warna Resmi
- **Canvas / Background**: `#F6F8F7`
- **Surface / Container**: `#FFFFFF` dengan border tipis `1px solid #E4EAE6`
- **Aksen Primer**: `#16A36A` (Brand utama), `#128557` (Hover/pressed state), `#EAF7F0` (Soft tint container)
- **Dark Surface**: `#17211F` (Untuk header terminal, panel code API, atau console)
- **Teks**: `#17211F` (Primary), `#697570` (Secondary/muted metadata)
- **Status Indikator**:
  - Connected / Live / Success: `#16865A` (Badge `#EAF7F0`, dot pulsasi)
  - Pending / Antrean / Warning: `#D99124` (Badge `#FEF6E7`)
  - Disconnected / Failed / Error: `#D84B4B` (Badge `#FDF0F0`)

---

## 3. Checklist Verifikasi Sebelum Menyatakan Selesai
- [ ] Apakah desain persis mengikuti tokens di `docs/design/` (`code.html` & `screen.png`)?
- [ ] **Apakah setiap file yang dibuat/dimodifikasi TIDAK MELEBIHI 100 BARIS?** (Wajib split menjadi sub-komponen / partials jika > 100 baris).
- [ ] Apakah seluruh interaksi form mempertahankan state (`old_inputs`) dan aman dari CSRF & XSS?
- [ ] Apakah seluruh query database menggunakan PDO parameter binding?
- [ ] Apakah copywriting sudah menggunakan Bahasa Indonesia yang manusiawi, informatif, dan jelas?
