<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class AuthService {
    public function attempt(string $email, string $password): bool {
        $user = Database::fetchOne("SELECT * FROM users WHERE email = :email", ['email' => $email]);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        $tenant = Database::fetchOne("SELECT * FROM tenants WHERE id = :id", ['id' => $user['tenant_id']]);

        // Store user in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['tenant_id'] = $user['tenant_id'];
        $_SESSION['tenant_name'] = $tenant['name'] ?? 'Akun Bisnis';
        $_SESSION['plan_id'] = $tenant['plan_id'] ?? 'starter';
        $_SESSION['user'] = $user;
        $_SESSION['tenant'] = $tenant;

        return true;
    }

    public function register(string $tenantName, string $userName, string $email, string $password, string $planId = 'starter'): ?string {
        $existing = Database::fetchOne("SELECT id FROM users WHERE email = :email", ['email' => $email]);
        if ($existing) {
            return "Email tersebut sudah terdaftar. Silakan gunakan email lain atau masuk.";
        }

        $tenantId = 'tenant_' . bin2hex(random_bytes(6));
        $userId = 'usr_' . bin2hex(random_bytes(6));

        // Create tenant and user
        Database::query("INSERT INTO tenants (id, name, plan_id, status) VALUES (:id, :name, :plan, 'active')", [
            'id' => $tenantId,
            'name' => $tenantName,
            'plan' => $planId,
        ]);

        Database::query("INSERT INTO users (id, tenant_id, name, email, password_hash, role) VALUES (:id, :tenant_id, :name, :email, :pass, 'admin')", [
            'id' => $userId,
            'tenant_id' => $tenantId,
            'name' => $userName,
            'email' => $email,
            'pass' => password_hash($password, PASSWORD_BCRYPT),
        ]);

        // Auto login
        $this->attempt($email, $password);

        return null;
    }

    public function logout(): void {
        unset(
            $_SESSION['user_id'],
            $_SESSION['user_name'],
            $_SESSION['user_email'],
            $_SESSION['user_role'],
            $_SESSION['tenant_id'],
            $_SESSION['tenant_name'],
            $_SESSION['plan_id']
        );
    }

    public function check(): bool {
        return !empty($_SESSION['user_id']);
    }

    public function tenantId(): string {
        return $_SESSION['tenant_id'] ?? 'tenant_demo_01';
    }
}
