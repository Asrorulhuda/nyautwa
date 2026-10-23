<?php

declare(strict_types=1);

namespace App\Core;

class Response {
    public static function json(array $data, int $status = 200, array $headers = []): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        foreach ($headers as $key => $val) {
            header("$key: $val");
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public static function redirect(string $url, int $status = 302): void {
        http_response_code($status);
        header("Location: $url");
        exit;
    }

    public static function withFlash(string $type, string $message, string $redirectUrl, ?array $oldInputs = null): void {
        $_SESSION["flash_$type"] = $message;
        if ($oldInputs !== null) {
            // Remove sensitive fields before retaining
            unset($oldInputs['password'], $oldInputs['password_confirmation'], $oldInputs['_csrf_token']);
            $_SESSION['old_inputs'] = $oldInputs;
        }
        self::redirect($redirectUrl);
    }
}
