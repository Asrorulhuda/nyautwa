<?php
require __DIR__ . '/../config/bootstrap.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    if (too_many_attempts($email, $ip)) {
        $error = 'Terlalu banyak percobaan. Coba lagi dalam 15 menit.';
    } else {
        $st = db()->prepare('SELECT id, password_hash FROM users WHERE email = :e LIMIT 1');
        $st->execute([':e' => $email]);
        $user = $st->fetch();

        $valid = password_verify($password, $user['password_hash'] ?? DUMMY_HASH) && $user;

        if ($valid) {
            clear_attempts($email, $ip);
            session_regenerate_id(true); // cegah session fixation
            $_SESSION['user_id'] = (int) $user['id'];

            // Upgrade hash otomatis jika algoritma default PHP berubah
            if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
                db()->prepare('UPDATE users SET password_hash = :h WHERE id = :id')
                    ->execute([':h' => password_hash($password, PASSWORD_DEFAULT), ':id' => $user['id']]);
            }
            header('Location: /dashboard.php');
            exit;
        }
        record_failed_attempt($email, $ip);
        $error = 'Email atau password salah.'; // pesan sama untuk semua kasus
    }
}
?>
<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Login</title></head><body>
<h1>Login</h1>
<?php if (isset($_GET['registered'])): ?><p>Pendaftaran berhasil, silakan login.</p><?php endif; ?>
<?php if ($error): ?><p style="color:red"><?= e($error) ?></p><?php endif; ?>
<form method="post">
  <?= csrf_field() ?>
  <label>Email <input type="email" name="email" required></label><br>
  <label>Password <input type="password" name="password" required autocomplete="current-password"></label><br>
  <button>Masuk</button>
</form>
</body></html>
