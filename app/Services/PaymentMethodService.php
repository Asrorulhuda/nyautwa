<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class PaymentMethodService {
    public function getAll(): array {
        return Database::fetchAll("SELECT * FROM payment_methods ORDER BY created_at ASC");
    }

    public function getActive(): array {
        return Database::fetchAll("SELECT * FROM payment_methods WHERE is_active = 1 ORDER BY created_at ASC");
    }

    public function save(array $d): void {
        $id = !empty($d['id']) ? trim($d['id']) : 'pm_' . bin2hex(random_bytes(4));
        $exists = Database::fetchOne("SELECT id FROM payment_methods WHERE id = :id", ['id' => $id]);
        $params = [
            'id' => $id, 'name' => trim($d['name'] ?? 'Bank Transfer'),
            'acc_no' => trim($d['account_number'] ?? ''), 'acc_name' => trim($d['account_name'] ?? ''),
            'type' => $d['type'] ?? 'bank_transfer', 'act' => isset($d['is_active']) ? (int)$d['is_active'] : 1
        ];
        if ($exists) {
            Database::query("UPDATE payment_methods SET name = :name, account_number = :acc_no, account_name = :acc_name, type = :type, is_active = :act WHERE id = :id", $params);
        } else {
            Database::query("INSERT INTO payment_methods (id, name, account_number, account_name, type, is_active) VALUES (:id, :name, :acc_no, :acc_name, :type, :act)", $params);
        }
    }

    public function toggle(string $id): void {
        Database::query("UPDATE payment_methods SET is_active = (CASE WHEN is_active = 1 THEN 0 ELSE 1 END) WHERE id = :id", ['id' => $id]);
    }

    public function delete(string $id): void {
        Database::query("DELETE FROM payment_methods WHERE id = :id", ['id' => $id]);
    }
}
