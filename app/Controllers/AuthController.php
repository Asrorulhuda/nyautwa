<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;

class AuthController {
    private AuthService $auth;

    public function __construct() {
        $this->auth = new AuthService();
    }

    public function showLogin(Request $request): void {
        if ($this->auth->check()) {
            Response::redirect('/dashboard');
        }
        View::render('auth/login', ['title' => 'Masuk ke NyautWa'], 'auth');
    }

    public function login(Request $request): void {
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa. Silakan refresh dan coba lagi.', '/login');
        }

        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        if (empty($email) || empty($password)) {
            Response::withFlash('error', 'Email dan kata sandi wajib diisi.', '/login', $request->all());
        }

        if ($this->auth->attempt($email, $password)) {
            Response::withFlash('success', 'Selamat datang kembali! Anda berhasil masuk.', '/dashboard');
        }

        Response::withFlash('error', 'Kombinasi email atau kata sandi tidak cocok. Silakan periksa kembali.', '/login', $request->all());
    }

    public function showRegister(Request $request): void {
        if ($this->auth->check()) {
            Response::redirect('/dashboard');
        }
        $plan = $request->input('plan', 'starter');
        View::render('auth/register', [
            'title' => 'Daftar Akun Baru NyautWa',
            'selectedPlan' => $plan,
        ], 'auth');
    }

    public function register(Request $request): void {
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa. Silakan refresh dan coba lagi.', '/register');
        }

        $company = trim((string) $request->input('company', ''));
        $name = trim((string) $request->input('name', ''));
        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');
        $plan = (string) $request->input('plan', 'starter');

        if (empty($company) || empty($name) || empty($email) || empty($password)) {
            Response::withFlash('error', 'Seluruh kolom pendaftaran wajib diisi dengan lengkap.', '/register', $request->all());
        }

        if (strlen($password) < 6) {
            Response::withFlash('error', 'Kata sandi minimal terdiri dari 6 karakter demi keamanan akun Anda.', '/register', $request->all());
        }

        $error = $this->auth->register($company, $name, $email, $password, $plan);
        if ($error) {
            Response::withFlash('error', $error, '/register', $request->all());
        }

        Response::withFlash('success', 'Pendaftaran akun berhasil! Selamat datang di NyautWa.', '/dashboard');
    }

    public function logout(Request $request): void {
        if ($request->validateCsrf()) {
            $this->auth->logout();
        }
        Response::withFlash('success', 'Anda telah berhasil keluar dari akun.', '/login');
    }
}
