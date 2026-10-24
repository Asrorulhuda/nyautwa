<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\RateLimitService;

class AuthController {
    private AuthService $auth;
    private RateLimitService $rateLimit;

    public function __construct() {
        $this->auth = new AuthService();
        $this->rateLimit = new RateLimitService();
    }

    public function showLogin(Request $request): void {
        if ($this->auth->check()) { Response::redirect('/dashboard'); return; }
        View::render('auth/login', ['title' => 'Masuk ke NyautWa'], 'auth');
    }

    public function login(Request $request): void {
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa. Silakan muat ulang.', '/login'); return;
        }
        $email = strtolower(trim((string) $request->input('email', '')));
        $password = (string) $request->input('password', '');
        $ip = $request->ip();

        if (empty($email) || empty($password)) {
            Response::withFlash('error', 'Email dan kata sandi wajib diisi.', '/login', ['email' => $email]); return;
        }
        if ($this->rateLimit->tooManyAttempts($email, $ip)) {
            Response::withFlash('error', 'Terlalu banyak percobaan masuk yang gagal. Silakan coba lagi dalam 15 menit.', '/login', ['email' => $email]); return;
        }
        if ($this->auth->attempt($email, $password)) {
            $this->rateLimit->clearAttempts($email, $ip);
            Response::withFlash('success', 'Selamat datang kembali! Anda berhasil masuk.', '/dashboard'); return;
        }
        $this->rateLimit->recordFailedAttempt($email, $ip);
        Response::withFlash('error', 'Email atau kata sandi tidak cocok. Silakan periksa kembali.', '/login', ['email' => $email]);
    }

    public function showRegister(Request $request): void {
        if ($this->auth->check()) { Response::redirect('/dashboard'); return; }
        View::render('auth/register', [
            'title' => 'Daftar Akun Baru NyautWa',
            'selectedPlan' => (string) $request->input('plan', 'starter'),
        ], 'auth');
    }

    public function register(Request $request): void {
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa. Silakan muat ulang.', '/register'); return;
        }
        $company = trim((string) $request->input('company', ''));
        $name = trim((string) $request->input('name', ''));
        $email = strtolower(trim((string) $request->input('email', '')));
        $password = (string) $request->input('password', '');
        $confirm = (string) $request->input('password_confirmation', '');
        $plan = (string) $request->input('plan', 'starter');
        $old = ['company' => $company, 'name' => $name, 'email' => $email, 'plan' => $plan];

        if (empty($company) || empty($name) || empty($email) || empty($password)) {
            Response::withFlash('error', 'Seluruh kolom pendaftaran wajib diisi dengan lengkap.', '/register', $old); return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
            Response::withFlash('error', 'Format alamat email tidak valid.', '/register', $old); return;
        }
        if (strlen($password) < 12 || strlen($password) > 128) {
            Response::withFlash('error', 'Kata sandi minimal 12 karakter dan maksimal 128 karakter.', '/register', $old); return;
        }
        if ($password !== $confirm) {
            Response::withFlash('error', 'Konfirmasi kata sandi tidak cocok. Silakan ketik ulang.', '/register', $old); return;
        }

        $validPlan = in_array($plan, ['starter', 'pro', 'enterprise'], true) ? $plan : 'starter';
        $error = $this->auth->register($company, $name, $email, $password, $validPlan);
        if ($error) { Response::withFlash('error', $error, '/register', $old); return; }
        Response::withFlash('success', 'Pendaftaran akun berhasil! Selamat datang di NyautWa.', '/dashboard');
    }

    public function logout(Request $request): void {
        if ($request->validateCsrf()) { $this->auth->logout(); }
        Response::withFlash('success', 'Anda telah berhasil keluar dari akun.', '/login');
    }
}
