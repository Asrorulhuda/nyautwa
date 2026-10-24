<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ContactService {
    public function getContacts(string $tenantId, ?string $tagId = null): array {
        $sql = "SELECT c.*, t.name as tag_name, t.color as tag_color 
                FROM contacts c 
                LEFT JOIN tags t ON c.tag_id = t.id 
                WHERE c.tenant_id = :tenant_id";
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
        return Database::execute(
            "INSERT INTO tags (id, tenant_id, name, color) VALUES (:id, :tenant_id, :name, :color)",
            ['id' => $id, 'tenant_id' => $tenantId, 'name' => trim($name), 'color' => $color]
        );
    }

    public function createContact(string $tenantId, array $data): bool {
        $id = 'cnt_' . bin2hex(random_bytes(6));
        return Database::execute(
            "INSERT INTO contacts (id, tenant_id, tag_id, name, phone, email, notes) 
             VALUES (:id, :tenant_id, :tag_id, :name, :phone, :email, :notes)",
            [
                'id' => $id,
                'tenant_id' => $tenantId,
                'tag_id' => !empty($data['tag_id']) ? $data['tag_id'] : null,
                'name' => trim($data['name']),
                'phone' => trim($data['phone']),
                'email' => !empty($data['email']) ? trim($data['email']) : null,
                'notes' => !empty($data['notes']) ? trim($data['notes']) : null,
            ]
        );
    }

    public function deleteContact(string $id, string $tenantId): bool {
        return Database::execute("DELETE FROM contacts WHERE id = :id AND tenant_id = :tenant_id", ['id' => $id, 'tenant_id' => $tenantId]);
    }
}
