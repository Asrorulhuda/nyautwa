<?php

declare(strict_types=1);

$baseDir = dirname(__DIR__);
$targetDirs = ['app', 'config', 'routes'];
$violations = [];

foreach ($targetDirs as $relDir) {
    $fullDir = $baseDir . DIRECTORY_SEPARATOR . $relDir;
    if (!is_dir($fullDir)) {
        continue;
    }

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($fullDir));
    foreach ($iterator as $item) {
        if ($item->isFile() && $item->getExtension() === 'php') {
            $lines = count(file($item->getPathname()));
            if ($lines > 100) {
                $violations[] = [
                    'file' => str_replace($baseDir . DIRECTORY_SEPARATOR, '', $item->getPathname()),
                    'lines' => $lines,
                ];
            }
        }
    }
}

if (empty($violations)) {
    echo "SUCCESS: All scanned PHP files are <= 100 lines!\n";
    exit(0);
}

echo "FOUND " . count($violations) . " FILES EXCEEDING 100 LINES:\n";
foreach ($violations as $v) {
    echo " - {$v['file']}: {$v['lines']} lines\n";
}
exit(1);
