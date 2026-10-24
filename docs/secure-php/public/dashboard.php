<?php
require __DIR__ . '/../config/bootstrap.php';
$user = require_login();

// Hanya ambil file milik user yang sedang login
$st = db()->prepare('SELECT id, original_name FROM files WHERE user_id = :uid ORDER BY id DESC');
$st->execute([':uid' => $user['id']]);
$files = $st->fetchAll();
?>
<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Dashboard</title></head><body>
<h1>Halo, <?= e($user['email']) ?></h1>

<h2>File saya</h2>
<ul>
<?php foreach ($files as $f): ?>
  <li><a href="/file.php?id=<?= (int) $f['id'] ?>"><?= e($f['original_name']) ?></a></li>
<?php endforeach; ?>
</ul>

<h2>Upload (JPG, PNG, WEBP, PDF; maks. 2 MB)</h2>
<form method="post" action="/upload.php" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <input type="file" name="file" required>
  <button>Upload</button>
</form>

<form method="post" action="/logout.php"><?= csrf_field() ?><button>Logout</button></form>
</body></html>
