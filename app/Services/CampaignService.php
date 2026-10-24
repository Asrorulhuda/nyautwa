<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class CampaignService {
    private EngineService $engine;

    public function __construct() {
        $this->engine = new EngineService();
    }

    public function getCampaigns(string $tenantId): array {
        return Database::fetchAll(
            "SELECT c.*, d.label as device_label FROM campaigns c 
             LEFT JOIN devices d ON c.device_id = d.id 
             WHERE c.tenant_id = :tenant_id ORDER BY c.created_at DESC",
            ['tenant_id' => $tenantId]
        );
    }

    public function createCampaign(string $tenantId, array $data, array $receivers): string {
        $id = 'cmp_' . bin2hex(random_bytes(6));
        Database::query(
            "INSERT INTO campaigns (id, tenant_id, device_id, name, type, message, media_url, delay_min, delay_max, total_recipients, status) 
             VALUES (:id, :tenant_id, :device_id, :name, :type, :message, :media_url, :delay_min, :delay_max, :total, 'draft')",
            [
                'id' => $id,
                'tenant_id' => $tenantId,
                'device_id' => $data['device_id'],
                'name' => trim($data['name']),
                'type' => $data['type'] ?? 'text',
                'message' => trim($data['message']),
                'media_url' => $data['media_url'] ?? null,
                'delay_min' => (int) ($data['delay_min'] ?? 5),
                'delay_max' => (int) ($data['delay_max'] ?? 15),
                'total' => count($receivers),
            ]
        );

        foreach ($receivers as $r) {
            $rStr = trim((string) $r);
            $rClean = str_ends_with($rStr, '@g.us') ? $rStr : preg_replace('/[^0-9]/', '', $rStr);
            if (empty($rClean)) continue;
            Database::query(
                "INSERT INTO blasts (id, tenant_id, campaign_id, receiver, message, status) 
                 VALUES (:id, :tenant_id, :campaign_id, :receiver, :message, 'pending')",
                [
                    'id' => 'bls_' . bin2hex(random_bytes(6)),
                    'tenant_id' => $tenantId,
                    'campaign_id' => $id,
                    'receiver' => $rClean,
                    'message' => trim($data['message']),
                ]
            );
        }

        return $id;
    }

    public function executeBlast(string $campaignId, string $tenantId): array {
        $campaign = Database::fetchOne("SELECT * FROM campaigns WHERE id = :id AND tenant_id = :tid", ['id' => $campaignId, 'tid' => $tenantId]);
        $device = Database::fetchOne("SELECT * FROM devices WHERE id = :id", ['id' => $campaign['device_id'] ?? '']);
        if (!$campaign || !$device || $device['status'] !== 'connected') {
            return ['success' => false, 'error' => 'Perangkat pengirim belum terhubung ke WhatsApp'];
        }

        Database::query("UPDATE campaigns SET status = 'processing' WHERE id = :id", ['id' => $campaignId]);
        $blasts = Database::fetchAll("SELECT * FROM blasts WHERE campaign_id = :id AND status = 'pending' LIMIT 10", ['id' => $campaignId]);

        $sent = 0;
        foreach ($blasts as $b) {
            $res = $this->engine->sendMessage($device['session_ref'], $b['receiver'], [
                'type' => $campaign['type'] ?? 'text',
                'message' => $b['message'],
                'url' => $campaign['media_url'] ?? null,
            ]);
            $status = ($res['success'] ?? false) ? 'sent' : 'failed';
            Database::query("UPDATE blasts SET status = :status, sent_at = CURRENT_TIMESTAMP WHERE id = :id", ['status' => $status, 'id' => $b['id']]);
            $sent++;
        }

        $rem = (int) Database::fetchOne("SELECT COUNT(*) as c FROM blasts WHERE campaign_id = :id AND status = 'pending'", ['id' => $campaignId])['c'];
        if ($rem === 0) {
            Database::query("UPDATE campaigns SET status = 'completed' WHERE id = :id", ['id' => $campaignId]);
        }

        return ['success' => true, 'sent' => $sent, 'remaining' => $rem];
    }
}
