<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class RateLimitService {
    public const MAX_ATTEMPTS = 5;
    public const DECAY_MINUTES = 15;

    public function tooManyAttempts(string $email, string $ip): bool {
        $threshold = date('Y-m-d H:i:s', time() - (self::DECAY_MINUTES * 60));
        try {
            $row = Database::fetchOne(
                "SELECT COUNT(*) as total FROM login_attempts WHERE email = :email AND (ip = :ip OR ip_address = :ip) AND (created_at >= :t OR last_attempt_at >= :t)",
                ['email' => strtolower(trim($email)), 'ip' => $ip, 't' => $threshold]
            );
            return ((int) ($row['total'] ?? 0)) >= self::MAX_ATTEMPTS;
        } catch (\Throwable) {
            // Fallback toleran jika kolom belum termigrasi sempurna
            try {
                $row = Database::fetchOne(
                    "SELECT COUNT(*) as total FROM login_attempts WHERE email = :email AND ip_address = :ip",
                    ['email' => strtolower(trim($email)), 'ip' => $ip]
                );
                return ((int) ($row['total'] ?? 0)) >= self::MAX_ATTEMPTS;
            } catch (\Throwable) {
                return false;
            }
        }
    }

    public function recordFailedAttempt(string $email, string $ip): void {
        $id = 'att_' . bin2hex(random_bytes(8));
        try {
            Database::query(
                "INSERT INTO login_attempts (id, email, ip, ip_address, created_at, last_attempt_at) 
                 VALUES (:id, :email, :ip, :ip, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
                ['id' => $id, 'email' => strtolower(trim($email)), 'ip' => $ip]
            );
        } catch (\Throwable) {
            try {
                Database::query(
                    "INSERT INTO login_attempts (id, email, ip_address, attempts, last_attempt_at) 
                     VALUES (:id, :email, :ip, 1, CURRENT_TIMESTAMP)",
                    ['id' => $id, 'email' => strtolower(trim($email)), 'ip' => $ip]
                );
            } catch (\Throwable) {}
        }
    }

    public function clearAttempts(string $email, string $ip): void {
        try {
            Database::query(
                "DELETE FROM login_attempts WHERE email = :email AND (ip = :ip OR ip_address = :ip)",
                ['email' => strtolower(trim($email)), 'ip' => $ip]
            );
        } catch (\Throwable) {
            try {
                Database::query(
                    "DELETE FROM login_attempts WHERE email = :email AND ip_address = :ip",
                    ['email' => strtolower(trim($email)), 'ip' => $ip]
                );
            } catch (\Throwable) {}
        }
    }
}
