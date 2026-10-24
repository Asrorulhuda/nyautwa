<?php
require __DIR__ . '/../config/bootstrap.php';
$admin = require_admin(); // 403 bila bukan admin (dicek dari database, bukan dari input client)
?>
<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Admin</title></head><body>
<h1>Panel Admin</h1>
<p>Login sebagai <?= e($admin['email']) ?></p>
</body></html>
