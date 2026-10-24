# Langkah 3 — Konfigurasi CI/CD Auto-Deploy via GitHub Actions

Workflow auto-deploy telah disiapkan di `.github/workflows/deploy-cpanel.yml`. Agar perubahan dari komputer lokal otomatis terunggah ke cPanel saat `git push`, lakukan langkah berikut:

---

### 1. Dapatkan Akun FTP cPanel
1. Masuk ke **cPanel** > menu **FTP Accounts**.
2. Anda bisa memakai akun FTP utama cPanel (nama domain dan password cPanel), atau membuat akun FTP khusus dengan folder tujuan `public_html/`.

---

### 2. Pasang Secrets di Repositori GitHub
Buka repositori GitHub Anda: **https://github.com/Asrorulhuda/nyautwa**
1. Klik menu **Settings** > bilah samping **Secrets and variables** > pilih **Actions**.
2. Klik tombol **New repository secret**.
3. Tambahkan 3 secret berikut:

| Nama Secret | Nilai / Contoh |
| :--- | :--- |
| `CPANEL_FTP_SERVER` | IP server cPanel atau `ftp.domainanda.com` |
| `CPANEL_FTP_USERNAME` | Username FTP cPanel Anda (contoh: `user@domainanda.com` atau `usercpanel`) |
| `CPANEL_FTP_PASSWORD` | Kata sandi akun FTP cPanel Anda |
| `CPANEL_FTP_TARGET_DIR` | *(Opsional)* `public_html/` |

---

### 3. Uji Coba Auto-Deploy
Setiap kali Anda mengetik perintah berikut di komputer lokal:
```bash
git add .
git commit -m "Update fitur atau tampilan baru"
git push origin main
```
1. GitHub Actions akan otomatis aktif dan memeriksa integritas kode (`tests/check_line_counts.php` & pengujian).
2. Bila lolos, seluruh file yang dimodifikasi akan otomatis diunggah ke hosting cPanel Anda melalui FTP terenkripsi.
3. Anda dapat memantau proses deployment secara langsung di tab **Actions** di GitHub.
