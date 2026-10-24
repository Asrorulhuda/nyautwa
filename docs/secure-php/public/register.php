<?php
require __DIR__ . '/../config/bootstrap.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
        $error = 'Email tidak valid.';
    } elseif (strlen($password) < 12 || strlen($password) > 128) {
        $error = 'Password minimal 12 karakter.';
    } else {
        try {
            // Role SELALU 'user' dari server, tidak pernah dari input client
            $st = db()->prepare("INSERT INTO users (email, password_hash, role) VALUES (:e, :h, 'user')");
            $st->execute([':e' => $email, ':h' => password_hash($password, PASSWORD_DEFAULT)]);
            header('Location: /login.php?registered=1');
            exit;
        } catch (PDOException $ex) {
            // Pesan generik: tidak membocorkan apakah email sudah terdaftar
            $error = 'Pendaftaran gagal. Periksa data Anda atau coba email lain.';
        }
    }
}
?>
<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Daftar</title></head><body>
<h1>Daftar</h1>
<?php if ($error): ?><p style="color:red"><?= e($error) ?></p><?php endif; ?>
<form method="post">
  <?= csrf_field() ?>
  <label>Email <input type="email" name="email" required maxlength="255"></label><br>
  <label>Password (min. 12 karakter) <input type="password" name="password" required minlength="12" maxlength="128" autocomplete="new-password"></label><br>
  <button>Daftar</button>
</form>
</body></html>
