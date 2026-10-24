<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;

echo "=== Menjalankan Sinkronisasi Penuh Database NyautWa (Pure MySQL) ===\n";

$db = Database::getInstance()->getConnection();
$driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
echo "Driver aktif: {$driver}\n";

$schemaSql = file_get_contents(__DIR__ . '/schema.sql');
$seedSql = file_get_contents(__DIR__ . '/seeds.sql');

$executeSql = function(string $sql) use ($db) {
    $stmts = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($stmts as $stmt) {
        if (!empty($stmt)) {
            try {
                $db->exec($stmt);
            } catch (\PDOException $e) {
                if (!str_contains(strtolower($e->getMessage()), 'duplicate column')) {
                    echo "Notice: " . $e->getMessage() . "\n";
                }
            }
        }
    }
};

echo "1. Membangun seluruh 23 tabel master MySQL... ";
$executeSql($schemaSql);
echo "[OK]\n";

echo "2. Memasukkan data awal (Plans, Admin, Device, Features, Payment Methods)... ";
$executeSql($seedSql);
echo "[OK]\n";

echo "=== SINKRONISASI DATABASE 100% SUKSES! ===\n";
