<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

echo "=== Menjalankan Migrasi Database NyautWa ===\n";

$db = Database::getInstance()->getConnection();
$driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
echo "Driver Database aktif: {$driver}\n";

$migrationFiles = glob(__DIR__ . '/migrations/*.sql');
sort($migrationFiles);

foreach ($migrationFiles as $file) {
    $filename = basename($file);
    echo "Menjalankan {$filename}... ";
    $sql = file_get_contents($file);
    
    // Split statements for drivers like SQLite
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $stmt) {
        if (!empty($stmt)) {
            $db->exec($stmt);
        }
    }
    echo "OK\n";
}

echo "Migrasi selesai dengan sukses.\n";
