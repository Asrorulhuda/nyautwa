<?php
require __DIR__ . '/../config/bootstrap.php';
$user = require_login();
require_post();

const MAX_SIZE = 2 * 1024 * 1024;
const ALLOWED = [
    'image/jpeg'      => 'jpg',
    'image/png'       => 'png',
    'image/webp'      => 'webp',
    'application/pdf' => 'pdf',
];

$f = $_FILES['file'] ?? null;
if (!$f || $f['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) {
    exit('Upload gagal.');
}
if ($f['size'] > MAX_SIZE) {
    exit('File terlalu besar (maks. 2 MB).');
}

// Cek tipe dari ISI file, bukan dari ekstensi / header kiriman client
$mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
if (!isset(ALLOWED[$mime])) {
    exit('Tipe file tidak diizinkan.');
}
// Untuk gambar, pastikan benar-benar gambar valid
if (str_starts_with($mime, 'image/') && @getimagesize($f['tmp_name']) === false) {
    exit('File gambar tidak valid.');
}

// Nama acak + simpan di luar document root
$stored = bin2hex(random_bytes(16)) . '.' . ALLOWED[$mime];
if (!move_uploaded_file($f['tmp_name'], BASE_PATH . '/storage/uploads/' . $stored)) {
    exit('Gagal menyimpan file.');
}
// TODO (opsional): scan dengan ClamAV, mis. exec('clamscan --no-summary ' . escapeshellarg($path))

$orig = mb_substr(basename((string) $f['name']), 0, 200);
db()->prepare('INSERT INTO files (user_id, stored_name, original_name, mime) VALUES (:u, :s, :o, :m)')
    ->execute([':u' => $user['id'], ':s' => $stored, ':o' => $orig, ':m' => $mime]);

header('Location: /dashboard.php');
exit;
