<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class AuthService {
    public const DUMMY_HASH = '$2y$10$1aanRZUMz16bQwgn1BkT8eNmCfs8TssP2TxBSgMp5iIuEs2X7pRCS';

    public function attempt(string $email, string $password): bool {
        $cleanEmail = strtolower(trim($email));
        $user = Database::fetchOne("SELECT * FROM users WHERE email = :email", ['email' => $cleanEmail]);
        $hash = $user['password_hash'] ?? self::DUMMY_HASH;
        $valid = password_verify($password, $hash) && ($user !== null);
        if (!$valid) {
            return false;
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            Database::query("UPDATE users SET password_hash = :h WHERE id = :id", [
                'h' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $user['id'],
            ]);
        }

        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $user['tenant_id']]);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['tenant_id'] = $user['tenant_id'];
        $_SESSION['tenant_name'] = $tenant['name'] ?? 'Akun Bisnis';
        $_SESSION['plan_id'] = $tenant['plan_id'] ?? 'starter';
        $_SESSION['user'] = $user;
        $_SESSION['tenant'] = $tenant;
        $_SESSION['last_activity'] = time();

        return true;
    }

    public function register(string $tenantName, string $userName, string $email, string $password, string $planId = 'starter'): ?string {
        $cleanEmail = strtolower(trim($email));
        $existing = Database::fetchOne("SELECT id FROM users WHERE email = :email", ['email' => $cleanEmail]);
        if ($existing) {
            return "Email tersebut sudah terdaftar. Silakan gunakan email lain atau masuk.";
        }

        $tenantId = 'tenant_' . bin2hex(random_bytes(6));
        $userId = 'usr_' . bin2hex(random_bytes(6));

        Database::query("INSERT INTO tenants (id, name, plan_id, status) VALUES (:id, :name, :plan, 'active')", [
            'id' => $tenantId,
            'name' => trim($tenantName),
            'plan' => $planId,
        ]);

        Database::query("INSERT INTO users (id, tenant_id, name, email, password_hash, role) VALUES (:id, :tenant_id, :name, :email, :pass, 'client')", [
            'id' => $userId,
            'tenant_id' => $tenantId,
            'name' => trim($userName),
            'email' => $cleanEmail,
            'pass' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $this->attempt($cleanEmail, $password);
        return null;
    }

    public function logout(): void {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    public function check(): bool {
        return !empty($_SESSION['user_id']);
    }

    public function tenantId(): string {
        return (string) ($_SESSION['tenant_id'] ?? '');
    }

    public function role(): string {
        return (string) ($_SESSION['user_role'] ?? 'client');
    }

    public function isAdmin(): bool {
        return in_array($_SESSION['user_role'] ?? '', ['admin', 'superadmin'], true);
    }
}
