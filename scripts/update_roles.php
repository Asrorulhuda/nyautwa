<?php
declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

Database::query("UPDATE users SET role = 'client' WHERE email != 'admin@nyautwa.test'");
$users = Database::fetchAll("SELECT id, name, email, role, tenant_id FROM users");
echo "Users updated successfully:\n";
foreach ($users as $u) {
    echo "- {$u['email']}: role = {$u['role']} (tenant: {$u['tenant_id']})\n";
}
