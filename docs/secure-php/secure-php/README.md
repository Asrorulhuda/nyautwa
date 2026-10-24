# Starter Kit PHP Native Aman

## Struktur
```
config/bootstrap.php   <- dimuat di semua halaman (header, session, error handling)
includes/              <- db.php (PDO), security.php (CSRF, auth, rate limit, e())
public/                <- SATU-SATUNYA folder yang boleh diakses web (document root)
storage/               <- log & upload, di luar public
.env                   <- rahasia (salin dari .env.example, jangan di-commit)
```

## Setup
1. Atur **document root** server ke folder `public/`.
2. `cp .env.example .env`, isi kredensial database.
3. Jalankan `schema.sql`, lalu buat user DB khusus dengan hak minimal.
4. `chmod 640 .env` dan pastikan `storage/` bisa ditulis oleh PHP.
5. Buat admin pertama lewat SQL: `UPDATE users SET role='admin' WHERE email='anda@contoh.com';`
6. Pasang SSL (Let's Encrypt), lalu tes di securityheaders.com.

## Aturan emas saat menambah halaman baru
- Awali dengan `require __DIR__.'/../config/bootstrap.php';`
- Query: **selalu** `prepare()` + parameter. Jangan pernah menyambung variabel ke SQL.
- Output: **selalu** `<?= e($data) ?>`.
- Form POST: sertakan `<?= csrf_field() ?>` dan panggil `csrf_verify()`.
- Halaman privat: `require_login()` / `require_admin()`.
- Akses data per-user: tambahkan `AND user_id = :uid` di query.

## Reset password (belum disertakan, ikuti pola ini)
Buat token `bin2hex(random_bytes(32))`, simpan **hash**-nya (`hash('sha256', $token)`) beserta waktu kedaluwarsa 30 menit,
kirim token via email, tandai terpakai setelah dipakai, dan hapus semua session user setelah password diganti.
