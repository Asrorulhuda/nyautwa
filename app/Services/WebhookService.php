<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class WebhookService {
    public function validateUrl(?string $url): bool {
        if (!$url) return true;
        $parsed = parse_url($url);
        if (!isset($parsed['scheme'], $parsed['host']) || !in_array(strtolower($parsed['scheme']), ['http', 'https'], true)) {
            return false;
        }
        $host = $parsed['host'];
        $ip = filter_var($host, FILTER_VALIDATE_IP) ? $host : gethostbyname($host);
        if (!$ip) return false;

        // SSRF protection: block private, loopback, link-local, and cloud metadata
        return (bool) filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    public function dispatch(string $tenantId, string $deviceId, string $event, array $data): bool {
        $device = Database::fetchOne(
            "SELECT webhook_url, webhook_secret FROM devices WHERE id = :id AND tenant_id = :tid",
            ['id' => $deviceId, 'tid' => $tenantId]
        );
        $url = $device['webhook_url'] ?? null;
        if (!$url || !$this->validateUrl($url)) return false;

        $deliveryId = 'del_' . bin2hex(random_bytes(12));
        $payload = json_encode([
            'event' => $event,
            'device_id' => $deviceId,
            'data' => $data,
            'timestamp' => gmdate('Y-m-d\TH:i:s\Z')
        ], JSON_UNESCAPED_SLASHES);

        $secret = $device['webhook_secret'] ?? 'nyautwa_secret_default';
        $signature = 'sha256=' . hash_hmac('sha256', (string) $payload, $secret);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Signature: ' . $signature,
            'X-Event: ' . $event,
            'X-Delivery-Id: ' . $deliveryId
        ]);
        curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        Database::query(
            "INSERT INTO webhook_deliveries (id, tenant_id, device_id, event, payload, attempts, last_status, created_at) VALUES (:id, :tid, :did, :ev, :pl, 1, :st, CURRENT_TIMESTAMP)",
            ['id' => $deliveryId, 'tid' => $tenantId, 'did' => $deviceId, 'ev' => $event, 'pl' => $payload, 'st' => $status]
        );
        return $status >= 200 && $status < 300;
    }
}
