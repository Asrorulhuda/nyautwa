<?php

declare(strict_types=1);

namespace App\Services;

class EngineService {
    private string $baseUrl;
    private string $secret;

    public function __construct() {
        $port = $_ENV['ENGINE_PORT'] ?? '3000';
        $this->baseUrl = rtrim($_ENV['ENGINE_URL'] ?? ('http://127.0.0.1:' . $port), '/');
        $this->secret = $_ENV['ENGINE_SECRET'] ?? 'nyautwa_engine_internal_secret_994821';
    }

    private function request(string $endpoint, array $data = []): array {
        $urls = array_unique([$this->baseUrl, 'https://nyautwa.asr-desain.my.id/engine', 'http://127.0.0.1:3000']);
        foreach ($urls as $base) {
            $ch = curl_init(rtrim($base, '/') . $endpoint);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_TIMEOUT => 8,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'X-Engine-Secret: ' . $this->secret],
            ]);
            $response = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($response && $code < 400) {
                return json_decode((string) $response, true) ?? ['success' => false];
            }
        }
        return ['success' => false, 'error' => 'Engine Baileys tidak merespons atau offline'];
    }

    public function startSession(string $sessionRef): array {
        return $this->request('/session/start', ['session_ref' => $sessionRef]);
    }

    public function requestPairingCode(string $sessionRef, string $phone): array {
        return $this->request('/session/pairing-code', ['session_ref' => $sessionRef, 'phone' => $phone]);
    }

    public function getStatus(string $sessionRef): array {
        return $this->request('/session/status', ['session_ref' => $sessionRef]);
    }

    public function logout(string $sessionRef): array {
        return $this->request('/session/logout', ['session_ref' => $sessionRef]);
    }

    public function sendMessage(string $sessionRef, string $phone, array $payload): array {
        $data = array_merge(['session_ref' => $sessionRef, 'phone' => $phone], $payload);
        return $this->request('/message/send', $data);
    }

    public function getContacts(string $sessionRef): array {
        return $this->request('/session/contacts', ['session_ref' => $sessionRef]);
    }
}
