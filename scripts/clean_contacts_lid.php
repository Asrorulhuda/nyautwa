<?php
require dirname(__DIR__) . '/bootstrap.php';
use App\Core\Database;

echo "=== CLEANING UP BOGUS LID CONTACTS & NORMALIZING PHONES ===\n";

// 1. Delete raw LID contacts (non-group, length >= 14 and not starting with 62)
$deleted = Database::query("DELETE FROM contacts WHERE phone NOT LIKE '%@g.us' AND (phone LIKE '%@lid' OR (LENGTH(phone) >= 14 AND phone NOT LIKE '62%'))")->rowCount();
echo "Deleted {$deleted} invalid LID contacts.\n";

// 2. Normalize 08... to 628... in contacts
$rows = Database::fetchAll("SELECT id, phone FROM contacts WHERE phone LIKE '08%'");
$updated = 0;
foreach ($rows as $r) {
    $newPhone = '628' . substr($r['phone'], 2);
    Database::query("UPDATE contacts SET phone = :p WHERE id = :id", ['p' => $newPhone, 'id' => $r['id']]);
    $updated++;
}
echo "Normalized {$updated} contacts from 08 to 628.\n";

// 3. Normalize 08... in messages to_from
$msgRows = Database::fetchAll("SELECT id, to_from FROM messages WHERE to_from LIKE '08%'");
$msgUpdated = 0;
foreach ($msgRows as $mr) {
    $newTo = '628' . substr($mr['to_from'], 2);
    Database::query("UPDATE messages SET to_from = :to WHERE id = :id", ['to' => $newTo, 'id' => $mr['id']]);
    $msgUpdated++;
}
echo "Normalized {$msgUpdated} messages to_from.\n";

echo "Remaining Non-Group Contacts:\n";
$rem = Database::fetchAll("SELECT id, name, phone FROM contacts WHERE phone NOT LIKE '%@g.us'");
foreach ($rem as $c) {
    echo "  - {$c['name']}: {$c['phone']}\n";
}
