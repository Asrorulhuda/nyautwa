<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

$period = date('Y-m');
Database::query(
    "UPDATE tenants t 
     LEFT JOIN usage_counters u ON t.id = u.tenant_id AND u.period = :p
     SET t.messages_used = COALESCE(u.messages_out, 0)",
    ['p' => $period]
);

$rows = Database::fetchAll("SELECT id, name, message_limit, messages_used FROM tenants");
print_r($rows);
