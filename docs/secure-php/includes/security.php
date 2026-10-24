<?php
declare(strict_types=1);

// Hash dummy agar waktu respon login sama untuk email yang tidak ada
const DUMMY_HASH = '$2y$10$1aanRZUMz16bQwgn1BkT8eNmCfs8TssP2TxBSgMp5iIuEs2X7pRCS';

/** Escape output HTML (anti XSS). Pakai di SETIAP echo data dinamis. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_verify(): void
{
    $sent = $_POST['csrf'] ?? '';
    if (!is_string($sent) || !hash_equals($_SESSION['csrf'] ?? '', $sent)) {
        http_response_code(403);
        exit('Permintaan tidak valid (CSRF).');
    }
}

function require_post(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Method tidak diizinkan.');
    }
    csrf_verify();
}

/* ---------- Auth & otorisasi (selalu cek di server) ---------- */
function current_user(): ?array
{
    static $user = false;
    if ($user === false) {
        $user = null;
        if (!empty($_SESSION['user_id'])) {
            $st = db()->prepare('SELECT id, email, role FROM users WHERE id = :id');
            $st->execute([':id' => $_SESSION['user_id']]);
            $user = $st->fetch() ?: null;
        }
    }
    return $user;
}

function require_login(): array
{
    $u = current_user();
    if (!$u) {
        header('Location: /login.php');
        exit;
    }
    return $u;
}

function require_admin(): array
{
    $u = require_login();
    if ($u['role'] !== 'admin') {
        http_response_code(403);
        exit('Akses ditolak.');
    }
    return $u;
}

/* ---------- Rate limiting login (5 gagal / 15 menit per email+IP) ---------- */
function too_many_attempts(string $email, string $ip): bool
{
    $st = db()->prepare('SELECT COUNT(*) FROM login_attempts WHERE email = :e AND ip = :ip AND created_at > (NOW() - INTERVAL 15 MINUTE)');
    $st->execute([':e' => $email, ':ip' => $ip]);
    return (int) $st->fetchColumn() >= 5;
}

function record_failed_attempt(string $email, string $ip): void
{
    db()->prepare('INSERT INTO login_attempts (email, ip) VALUES (:e, :ip)')->execute([':e' => $email, ':ip' => $ip]);
}

function clear_attempts(string $email, string $ip): void
{
    db()->prepare('DELETE FROM login_attempts WHERE email = :e AND ip = :ip')->execute([':e' => $email, ':ip' => $ip]);
}
