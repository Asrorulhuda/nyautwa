<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class RateLimitService {
    public const MAX_ATTEMPTS = 5;
    public const DECAY_MINUTES = 15;

    public function tooManyAttempts(string $email, string $ip): bool {
        $threshold = date('Y-m-d H:i:s', time() - (self::DECAY_MINUTES * 60));
        $row = Database::fetchOne(
            "SELECT COUNT(*) as total FROM login_attempts WHERE email = :email AND ip = :ip AND created_at >= :threshold",
            [
                'email' => strtolower(trim($email)),
                'ip' => $ip,
                'threshold' => $threshold,
            ]
        );
        return ((int) ($row['total'] ?? 0)) >= self::MAX_ATTEMPTS;
    }

    public function recordFailedAttempt(string $email, string $ip): void {
        Database::query(
            "INSERT INTO login_attempts (email, ip, created_at) VALUES (:email, :ip, :created_at)",
            [
                'email' => strtolower(trim($email)),
                'ip' => $ip,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        );
    }

    public function clearAttempts(string $email, string $ip): void {
        Database::query(
            "DELETE FROM login_attempts WHERE email = :email AND ip = :ip",
            [
                'email' => strtolower(trim($email)),
                'ip' => $ip,
            ]
        );
    }
}
