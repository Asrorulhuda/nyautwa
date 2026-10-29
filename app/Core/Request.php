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
        $path = parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $base = $this->getBasePath();
        if ($base !== '' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base));
            $path = ($path === '' || !str_starts_with($path, '/')) ? '/' . $path : $path;
        }
        if (str_starts_with($path, '/public/')) {
            $path = substr($path, 7);
        } elseif ($path === '/public') {
            $path = '/';
        }
        $path = preg_replace('#/{2,}#', '/', (string)$path);
        return ($path !== '/' && str_ends_with($path, '/')) ? rtrim($path, '/') : $path;
    }

    public function getBasePath(): string {
        $script = str_replace('\\', '/', $this->server['SCRIPT_NAME'] ?? '');
        $dir = dirname($script);
        if ($dir !== '/' && $dir !== '\\' && $dir !== '.') {
            return rtrim(preg_replace('#/public$#', '', $dir), '/');
        }
        $conf = parse_url((string) env('APP_URL', ''), PHP_URL_PATH);
        return ($conf && $conf !== '/') ? rtrim($conf, '/') : '';
    }

    public function get(string $key, mixed $default = null): mixed { return $this->get[$key] ?? $default; }
    public function post(string $key, mixed $default = null): mixed { return $this->post[$key] ?? $default; }
    public function input(string $key, mixed $default = null): mixed { return $this->all()[$key] ?? $default; }
    public function ip(): string { return (string) ($this->server['REMOTE_ADDR'] ?? '127.0.0.1'); }
    public function all(): array { return array_merge($this->get, $this->post, $this->json()); }
    public function isJson(): bool { return str_contains(strtolower($this->header('content-type') ?? ''), 'application/json'); }

    public function json(): array {
        if ($this->json === null) {
            $decoded = json_decode(file_get_contents('php://input'), true);
            $this->json = is_array($decoded) ? $decoded : [];
        }
        return $this->json;
    }

    public function header(string $name, ?string $default = null): ?string {
        return $this->headers[strtolower(str_replace('_', '-', $name))] ?? $default;
    }

    public function bearerToken(): ?string {
        $auth = $this->header('authorization');
        if ($auth && preg_match('/Bearer\s+(\S+)/i', $auth, $m)) return $m[1];
        $alt = $this->header('x-api-key') ?? $this->input('api_key') ?? $this->input('token');
        return (!empty($alt) && is_string($alt)) ? trim($alt) : null;
    }

    public function validateCsrf(): bool {
        if (in_array($this->getMethod(), ['GET', 'HEAD', 'OPTIONS'], true)) return true;
        $t = $this->input('_csrf_token') ?? $this->input('csrf_token') ?? $this->header('x-csrf-token');
        return Csrf::validate(is_string($t) ? $t : null);
    }

    public static function csrfToken(): string { return Csrf::token(); }
    public static function csrfField(): string { return Csrf::field(); }

    private function extractHeaders(): array {
        $h = [];
        foreach ($this->server as $k => $v) {
            if (str_starts_with($k, 'HTTP_')) {
                $h[strtolower(str_replace('_', '-', substr($k, 5)))] = (string) $v;
            } elseif (in_array($k, ['CONTENT_TYPE', 'CONTENT_LENGTH'], true)) {
                $h[strtolower(str_replace('_', '-', $k))] = (string) $v;
            }
        }
        return $h;
    }
}
