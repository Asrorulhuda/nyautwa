<?php

declare(strict_types=1);

namespace App\Core;

class Request {
    private array $get;
    private array $post;
    private array $server;
    private array $headers;
    private ?array $json = null;

    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->headers = $this->extractHeaders();
    }

    public function getMethod(): string {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function getPath(): string {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        // Normalize trailing slash (except root)
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }
        return $path;
    }

    public function input(string $key, mixed $default = null): mixed {
        $all = $this->all();
        return $all[$key] ?? $default;
    }

    public function all(): array {
        $data = array_merge($this->get, $this->post);
        $jsonData = $this->json();
        if (!empty($jsonData)) {
            $data = array_merge($data, $jsonData);
        }
        return $data;
    }

    public function isJson(): bool {
        $contentType = $this->header('content-type') ?? '';
        return str_contains(strtolower($contentType), 'application/json');
    }

    public function json(): array {
        if ($this->json === null) {
            $raw = file_get_contents('php://input');
            $decoded = json_decode($raw, true);
            $this->json = is_array($decoded) ? $decoded : [];
        }
        return $this->json;
    }

    public function header(string $name, ?string $default = null): ?string {
        $normalized = strtolower(str_replace('_', '-', $name));
        return $this->headers[$normalized] ?? $default;
    }

    public function bearerToken(): ?string {
        $auth = $this->header('authorization');
        if ($auth && preg_match('/Bearer\s+(\S+)/i', $auth, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function validateCsrf(): bool {
        if (in_array($this->getMethod(), ['GET', 'HEAD', 'OPTIONS'], true)) {
            return true;
        }
        $token = $this->input('_csrf_token') ?? $this->header('x-csrf-token');
        $sessionToken = $_SESSION['_csrf_token'] ?? null;
        return $token && $sessionToken && hash_equals($sessionToken, (string) $token);
    }

    public static function csrfToken(): string {
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    public static function csrfField(): string {
        $token = self::csrfToken();
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    private function extractHeaders(): array {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = strtolower(str_replace('_', '-', substr($key, 5)));
                $headers[$name] = (string) $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH'], true)) {
                $name = strtolower(str_replace('_', '-', $key));
                $headers[$name] = (string) $value;
            }
        }
        return $headers;
    }
}
