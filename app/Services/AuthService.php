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

        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id(true);
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            Database::query("UPDATE users SET password_hash = :h WHERE id = :id", [
                'h' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $user['id'],
            ]);
        }

        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $user['tenant_id']]);
        if (!isset($_SESSION) || !is_array($_SESSION)) {
            $_SESSION = [];
        }
        $_SESSION = array_merge($_SESSION, [
            'user_id' => $user['id'], 'user_name' => $user['name'], 'user_email' => $user['email'],
            'user_role' => $user['role'], 'tenant_id' => $user['tenant_id'],
            'tenant_name' => $tenant['name'] ?? 'Akun Bisnis', 'plan_id' => $tenant['plan_id'] ?? 'starter',
            'user' => $user, 'tenant' => $tenant, 'last_activity' => time(),
        ]);

        return true;
    }

    public function register(string $tenantName, string $userName, string $email, string $password, string $planId = 'trial', ?string $logo = null, string $industry = 'Bisnis'): ?string {
        $cleanEmail = strtolower(trim($email));
        if (Database::fetchOne("SELECT id FROM users WHERE email = :email", ['email' => $cleanEmail])) {
            return "Email tersebut sudah terdaftar. Silakan gunakan email lain atau masuk.";
        }

        $tenantId = 'tenant_' . bin2hex(random_bytes(6));
        $userId = 'usr_' . bin2hex(random_bytes(6));
        $p = (new PlanService())->getPlan($planId) ?? [];
        $dur = (int)($p['duration_days'] ?? 7);
        $dlim = (int)($p['devices'] ?? 1);
        $mlim = (int)(preg_replace('/[^0-9]/', '', (string)($p['quota'] ?? '200')) ?: 200);
        $subEnd = date('Y-m-d H:i:s', strtotime("+{$dur} days"));

        Database::query("INSERT INTO tenants (id, name, logo, industry, plan_id, device_limit, message_limit, subscription_ends_at, status) VALUES (:id, :name, :logo, :ind, :plan, :d, :m, :end, 'active')", [
            'id' => $tenantId, 'name' => trim($tenantName), 'logo' => $logo, 'ind' => trim($industry) ?: 'Bisnis',
            'plan' => $planId, 'd' => $dlim, 'm' => $mlim, 'end' => $subEnd
        ]);

        Database::query("INSERT INTO users (id, tenant_id, name, email, password_hash, role) VALUES (:id, :tenant_id, :name, :email, :pass, 'client')", [
            'id' => $userId, 'tenant_id' => $tenantId, 'name' => trim($userName), 'email' => $cleanEmail, 'pass' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return $this->attempt($cleanEmail, $password) ? null : "Gagal masuk otomatis.";
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
