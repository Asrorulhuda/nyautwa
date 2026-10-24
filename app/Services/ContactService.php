<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ContactService {
    private EngineService $engine;

    public function __construct() {
        $this->engine = new EngineService();
    }

    public function getContacts(string $tenantId, ?string $tagId = null): array {
        $sql = "SELECT c.*, t.name as tag_name, t.color as tag_color FROM contacts c LEFT JOIN tags t ON c.tag_id = t.id WHERE c.tenant_id = :tenant_id";
        $params = ['tenant_id' => $tenantId];
        if ($tagId) {
            $sql .= " AND c.tag_id = :tag_id";
            $params['tag_id'] = $tagId;
        }
        $sql .= " ORDER BY c.created_at DESC";
        return Database::fetchAll($sql, $params);
    }

    public function getTags(string $tenantId): array {
        return Database::fetchAll("SELECT * FROM tags WHERE tenant_id = :tenant_id ORDER BY name ASC", ['tenant_id' => $tenantId]);
    }

    public function createTag(string $tenantId, string $name, string $color = '#16A36A'): bool {
        $id = 'tag_' . bin2hex(random_bytes(6));
        return Database::execute("INSERT INTO tags (id, tenant_id, name, color) VALUES (:id, :tid, :name, :color)", ['id' => $id, 'tid' => $tenantId, 'name' => trim($name), 'color' => $color]);
    }

    public function getOrCreateTag(string $tenantId, string $name, string $color = '#16A36A'): string {
        $tag = Database::fetchOne("SELECT id FROM tags WHERE tenant_id = :tid AND name = :name", ['tid' => $tenantId, 'name' => $name]);
        if ($tag) return $tag['id'];
        $id = 'tag_' . bin2hex(random_bytes(6));
        Database::query("INSERT INTO tags (id, tenant_id, name, color) VALUES (:id, :tid, :name, :color)", ['id' => $id, 'tid' => $tenantId, 'name' => $name, 'color' => $color]);
        return $id;
    }

    public function createContact(string $tenantId, array $data): bool {
        $id = 'cnt_' . bin2hex(random_bytes(6));
        return Database::execute(
            "INSERT INTO contacts (id, tenant_id, tag_id, name, phone, email, notes) VALUES (:id, :tid, :tag_id, :name, :phone, :email, :notes)",
            ['id' => $id, 'tid' => $tenantId, 'tag_id' => $data['tag_id'] ?: null, 'name' => trim($data['name']), 'phone' => trim($data['phone']), 'email' => $data['email'] ?: null, 'notes' => $data['notes'] ?: null]
        );
    }

    public function syncFromDevice(string $tenantId, string $deviceId): array {
        $dev = Database::fetchOne("SELECT * FROM devices WHERE id = :id AND tenant_id = :tid", ['id' => $deviceId, 'tid' => $tenantId]);
        if (!$dev || $dev['status'] !== 'connected') return ['success' => false, 'error' => 'Perangkat belum terhubung ke WhatsApp'];

        $res = $this->engine->getContacts($dev['session_ref']);
        $raw = $res['contacts'] ?? [];
        if (empty($raw)) return ['success' => false, 'error' => 'Belum ada data kontak atau grup yang ditemukan di perangkat'];

        $tagGroup = $this->getOrCreateTag($tenantId, 'Grup WhatsApp', '#6366F1');
        $tagPersonal = $this->getOrCreateTag($tenantId, 'Kontak WhatsApp', '#16A36A');
        $synced = 0; $groups = 0;

        foreach ($raw as $c) {
            $isGrp = !empty($c['is_group']) || str_ends_with($c['phone'], '@g.us');
            $tagId = $isGrp ? $tagGroup : $tagPersonal;
            $name = trim($c['name'] ?? ($isGrp ? 'Grup WA' : 'Kontak WA'));
            $phone = trim($c['phone']);
            $existing = Database::fetchOne("SELECT id FROM contacts WHERE tenant_id = :tid AND phone = :p", ['tid' => $tenantId, 'p' => $phone]);

            if ($existing) {
                Database::query("UPDATE contacts SET name = :n, tag_id = :t, updated_at = CURRENT_TIMESTAMP WHERE id = :id", ['n' => $name, 't' => $tagId, 'id' => $existing['id']]);
            } else {
                $notes = $isGrp ? "Grup WhatsApp (" . ($c['count'] ?? 0) . " anggota)" : "Sinkronisasi dari {$dev['label']}";
                $this->createContact($tenantId, ['name' => $name, 'phone' => $phone, 'tag_id' => $tagId, 'notes' => $notes]);
            }
            $synced++;
            if ($isGrp) $groups++;
        }
        return ['success' => true, 'total' => $synced, 'groups' => $groups, 'personal' => ($synced - $groups)];
    }

    public function deleteContact(string $id, string $tenantId): bool {
        return Database::execute("DELETE FROM contacts WHERE id = :id AND tenant_id = :tenant_id", ['id' => $id, 'tenant_id' => $tenantId]);
    }
}
