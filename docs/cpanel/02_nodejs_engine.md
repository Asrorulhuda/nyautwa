# Langkah 2 — Setup Node.js App (Baileys Engine) di cPanel

cPanel modern (CloudLinux) menyediakan fitur bawaan **Setup Node.js App** yang memungkinkan engine Baileys berjalan 24/7 tanpa perlu VPS.

---

### 1. Buka Menu "Setup Node.js App"
1. Masuk ke dashboard **cPanel**.
2. Ketik pada bilah pencarian: **Setup Node.js App** dan klik menu tersebut.
3. Klik tombol **Create Application** di pojok kanan atas.

---

### 2. Isi Formulir Node.js Application
Isi bidang konfigurasi dengan nilai berikut:
- **Node.js version:** Pilih versi **20.x** (LTS) atau versi terbaru yang tersedia.
- **Application mode:** Pilih **Production**.
- **Application root:** Masukkan `public_html/engine` (atau `nyautwa/engine` jika di subfolder).
- **Application URL:** Biarkan default atau pilih port internal.
- **Application startup file:** Masukkan `server.js`.

Klik tombol **CREATE** di kanan atas.

---

### 3. Install Dependensi Node.js
Setelah aplikasi dibuat:
1. Klik tombol **Run NPM Install** pada panel aplikasi Node.js cPanel.
2. Tunggu beberapa detik hingga modul Baileys, QRCode, dan Express selesai terpasang.
3. Klik tombol **START APPLICATION** (atau Restart).

---

### 4. Verifikasi Status Engine
Periksa apakah engine telah berjalan dengan membuka terminal cPanel:
```bash
curl -I http://127.0.0.1:3000/health
```
Jika mengembalikan respons `HTTP/1.1 200 OK`, engine Baileys Anda telah aktif di server cPanel dan siap menangani koneksi WhatsApp fisik!
