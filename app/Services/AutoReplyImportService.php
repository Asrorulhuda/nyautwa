<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class AutoReplyImportService {
    public function import(string $tenantId, ?string $deviceId, string $filePath): array {
        $rows = ExcelParserService::parse($filePath);
        if (count($rows) < 2) {
            return ['success' => false, 'message' => 'Berkas kosong atau tidak memiliki baris data.'];
        }

        $col = $this->mapColumns($rows[0]);
        $imported = 0; $updated = 0; $errors = [];

        for ($i = 1; $i < count($rows); $i++) {
            $r = $rows[$i];
            $kw = trim((string) ($r[$col['kw']] ?? ''));
            $resp = trim((string) ($r[$col['resp']] ?? ''));
            if ($kw === '' || $resp === '') {
                if ($kw !== '' || $resp !== '') $errors[] = "Baris " . ($i + 1) . ": Kata kunci dan pesan wajib diisi.";
                continue;
            }

            $match = str_contains(strtolower((string) ($r[$col['match']] ?? '')), 'exact') ? 'exact' : 'contain';
            $type = $this->resolveType((string) ($r[$col['type']] ?? 'text'));
            $opts = $this->parseOptions($type, (string) ($r[$col['opts']] ?? ''));
            $delay = max(0, (int) ($r[$col['delay']] ?? 1));

            $saved = $this->saveRule($tenantId, $deviceId, $kw, $match, $type, $resp, $opts, $delay);
            if ($saved === 'updated') $updated++; else $imported++;
        }

        return ['success' => true, 'imported' => $imported, 'updated' => $updated, 'errors' => $errors];
    }

    private function mapColumns(array $h): array {
        $m = ['kw' => 0, 'match' => 1, 'type' => 2, 'resp' => 3, 'opts' => 4, 'delay' => 5];
        foreach ($h as $idx => $name) {
            $n = strtolower(trim((string) $name));
            if (str_contains($n, 'kunci') || str_contains($n, 'keyword')) $m['kw'] = $idx;
            elseif (str_contains($n, 'cocok') || str_contains($n, 'match')) $m['match'] = $idx;
            elseif (str_contains($n, 'tipe') || str_contains($n, 'type')) $m['type'] = $idx;
            elseif (str_contains($n, 'pesan') || str_contains($n, 'balas') || str_contains($n, 'resp')) $m['resp'] = $idx;
            elseif (str_contains($n, 'menu') || str_contains($n, 'pilih') || str_contains($n, 'opt')) $m['opts'] = $idx;
            elseif (str_contains($n, 'jeda') || str_contains($n, 'delay')) $m['delay'] = $idx;
        }
        return $m;
    }

    private function resolveType(string $raw): string {
        $t = strtolower(trim($raw));
        if (str_contains($t, 'button') || str_contains($t, 'tombol') || str_contains($t, 'menu')) return 'button';
        if (str_contains($t, 'poll')) return 'poll';
        if (str_contains($t, 'image') || str_contains($t, 'gambar')) return 'image';
        if (str_contains($t, 'doc') || str_contains($t, 'berkas')) return 'document';
        return 'text';
    }

    private function parseOptions(string $type, string $raw): ?string {
        if (empty(trim($raw))) return null;
        if ($type === 'poll') {
            $items = array_values(array_filter(array_map('trim', preg_split('/[\n\|\,]+/', $raw))));
            return !empty($items) ? json_encode($items) : null;
        }
        if ($type === 'button') {
            $items = array_values(array_filter(array_map('trim', preg_split('/[\n\|]+/', $raw))));
            $res = [];
            foreach ($items as $idx => $line) {
                if (preg_match('/^([0-9a-zA-Z]+)[\:\.\-\)]\s*([^:\(\)]+)(?:[\:\(]([^:\)]+)[\)]?)?$/', $line, $p)) {
                    $res[] = ['key' => trim($p[1]), 'label' => trim($p[2]), 'keyword' => !empty($p[3]) ? trim($p[3]) : trim($p[2])];
                } else {
                    $res[] = ['key' => (string) ($idx + 1), 'label' => $line, 'keyword' => $line];
                }
            }
            return !empty($res) ? json_encode($res) : null;
        }
        return null;
    }

    private function saveRule(string $tid, ?string $did, string $kw, string $match, string $type, string $resp, ?string $opts, int $delay): string {
        $sql = "SELECT id FROM autoreplies WHERE tenant_id = :tid AND keyword = :kw AND (device_id = :did OR (device_id IS NULL AND :did2 IS NULL)) LIMIT 1";
        $existing = Database::fetchOne($sql, ['tid' => $tid, 'kw' => $kw, 'did' => $did, 'did2' => $did]);
        if ($existing) {
            Database::execute("UPDATE autoreplies SET match_type = :match, type = :type, response = :resp, options = :opts, delay_seconds = :delay WHERE id = :id", [
                'id' => $existing['id'], 'match' => $match, 'type' => $type, 'resp' => $resp, 'opts' => $opts, 'delay' => $delay
            ]);
            return 'updated';
        }
        Database::execute("INSERT INTO autoreplies (id, tenant_id, device_id, keyword, match_type, type, response, options, delay_seconds, status) VALUES (:id, :tid, :did, :kw, :match, :type, :resp, :opts, :delay, 'active')", [
            'id' => 'rep_' . bin2hex(random_bytes(6)), 'tid' => $tid, 'did' => $did, 'kw' => $kw, 'match' => $match, 'type' => $type, 'resp' => $resp, 'opts' => $opts, 'delay' => $delay
        ]);
        return 'created';
    }
}
