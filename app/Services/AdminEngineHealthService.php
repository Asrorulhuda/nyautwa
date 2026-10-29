<?php

declare(strict_types=1);

namespace App\Services;

class AdminEngineHealthService {
    public function getHealth(): array {
        $port = $_ENV['ENGINE_PORT'] ?? '3000';
        $url = 'http://127.0.0.1:' . $port . '/health';
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT_MS => 600,
            CURLOPT_CONNECTTIMEOUT_MS => 300,
        ]);
        $start = microtime(true);
        $raw = curl_exec($ch);
        $latencyMs = round((microtime(true) - $start) * 1000);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw && $code === 200) {
            $data = json_decode((string)$raw, true);
            return [
                'online' => true,
                'name' => $data['engine'] ?? 'NyautWa Baileys Live Engine',
                'latency' => $latencyMs . 'ms',
                'uptime' => 'Aktif (Node.js Live)',
                'time' => $data['time'] ?? date('c'),
            ];
        }

        return [
            'online' => false,
            'name' => 'Baileys Engine (Offline)',
            'latency' => '-',
            'uptime' => 'Terputus (0%)',
            'time' => null,
        ];
    }
}
