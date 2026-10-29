<?php

declare(strict_types=1);

namespace App\Services;

use ZipArchive;

class ExcelParserService {
    public static function parse(string $filePath): array {
        if (!file_exists($filePath)) return [];
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return $ext === 'xlsx' ? self::parseXlsx($filePath) : self::parseCsv($filePath);
    }

    private static function parseXlsx(string $path): array {
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) return [];

        $shared = [];
        if ($strXml = $zip->getFromName('xl/sharedStrings.xml')) {
            $xml = @simplexml_load_string($strXml);
            if ($xml) {
                foreach ($xml->si as $si) {
                    $t = '';
                    if (isset($si->t)) $t = (string) $si->t;
                    elseif (isset($si->r)) { foreach ($si->r as $r) $t .= (string) $r->t; }
                    $shared[] = $t;
                }
            }
        }

        $rows = [];
        if ($sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml')) {
            $xml = @simplexml_load_string($sheetXml);
            if ($xml && isset($xml->sheetData->row)) {
                foreach ($xml->sheetData->row as $row) {
                    $r = [];
                    foreach ($row->c as $c) {
                        $colIdx = self::colLetterToIndex((string) $c['r']);
                        $val = isset($c->v) ? (string) $c->v : '';
                        if (isset($c['t']) && (string) $c['t'] === 's' && isset($shared[(int) $val])) {
                            $val = $shared[(int) $val];
                        }
                        $r[$colIdx] = $val;
                    }
                    if (!empty($r)) {
                        ksort($r);
                        $maxKey = max(array_keys($r));
                        $rowPadded = [];
                        for ($i = 0; $i <= $maxKey; $i++) $rowPadded[$i] = $r[$i] ?? '';
                        $rows[] = $rowPadded;
                    }
                }
            }
        }
        $zip->close();
        return $rows;
    }

    private static function colLetterToIndex(string $cellRef): int {
        if (preg_match('/^([A-Z]+)/i', $cellRef, $m)) {
            $letters = strtoupper($m[1]);
            $idx = 0;
            for ($i = 0; $i < strlen($letters); $i++) {
                $idx = $idx * 26 + (ord($letters[$i]) - ord('A') + 1);
            }
            return $idx - 1;
        }
        return 0;
    }

    private static function parseCsv(string $path): array {
        $handle = fopen($path, 'r');
        if (!$handle) return [];

        $firstLine = fgets($handle);
        $delimiter = str_contains($firstLine, ';') ? ';' : (str_contains($firstLine, "\t") ? "\t" : ',');
        rewind($handle);

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") rewind($handle);

        $rows = [];
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = $data;
        }
        fclose($handle);
        return $rows;
    }
}
