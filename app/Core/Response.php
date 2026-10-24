<?php

declare(strict_types=1);

namespace App\Core;

class Response {
    public static bool $preventExit = false;

    public static function json(array $data, int $status = 200, array $headers = []): void {
        if (!headers_sent()) {
            http_response_code($status);
            header('Content-Type: application/json; charset=UTF-8');
            foreach ($headers as $key => $val) { header("$key: $val"); }
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if (!self::$preventExit) { exit; }
    }

    public static function apiError(string $code, string $message, int $status = 400, array $headers = []): void {
        self::json(['error' => ['code' => $code, 'message' => $message]], $status, $headers);
    }

    public static function redirect(string $url, int $status = 302): void {
        if (str_starts_with($url, '/') && !str_starts_with($url, '//')) {
            $url = url($url);
        }
        if (!headers_sent()) {
            http_response_code($status);
            header("Location: $url");
        }
        if (!self::$preventExit) { exit; }
    }

    public static function withFlash(string $type, string $message, string $redirectUrl, ?array $oldInputs = null): void {
        $_SESSION["flash_$type"] = $message;
        if ($oldInputs !== null) {
            unset($oldInputs['password'], $oldInputs['password_confirmation'], $oldInputs['_csrf_token']);
            $_SESSION['old_inputs'] = $oldInputs;
        }
        self::redirect($redirectUrl);
    }
}
