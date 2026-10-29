<?php

declare(strict_types=1);

$dirs = ['app', 'config', 'routes', 'workers', 'database'];
$over = [];
$total = 0;

function scanDirFiles(string $dir, array &$over, int &$total): void {
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            scanDirFiles($path, $over, $total);
        } elseif (preg_match('/\.(php|js|sql)$/', $item)) {
            $total++;
            $lines = count(file($path));
            if ($lines > 100) {
                $over[] = ['file' => $path, 'lines' => $lines];
            }
        }
    }
}

foreach ($dirs as $d) {
    $p = __DIR__ . '/../' . $d;
    if (is_dir($p)) scanDirFiles($p, $over, $total);
}

echo "=== Total file discan: {$total} ===\n";
if (!empty($over)) {
    echo "PERINGATAN: Ada " . count($over) . " file melebihi 100 baris:\n";
    foreach ($over as $o) {
        echo "- {$o['file']} : {$o['lines']} baris\n";
    }
    exit(1);
} else {
    echo "SUKSES: Seluruh {$total} file dalam repositori strictly <= 100 baris!\n";
    exit(0);
}
