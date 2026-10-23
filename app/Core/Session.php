<?php

declare(strict_types=1);

namespace App\Core;

class Session {
    public static function get(string $key, mixed $default = null): mixed {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return $_SESSION[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        unset($_SESSION[$key]);
    }
}
