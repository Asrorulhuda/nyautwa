<?php

declare(strict_types=1);

namespace App\Controllers\Concerns;

use App\Core\Request;
use App\Services\AutoReplyMediaService;

trait ParsesAutoReplyInput {
    protected function parsePayload(Request $req, string $type, bool $isUpdate = false, ?string $currentMedia = null): array {
        $mediaUrl = $currentMedia;
        $options = null;

        if (in_array($type, ['image', 'document'], true)) {
            $hasFile = isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK;
            if ($hasFile) {
                $upload = AutoReplyMediaService::upload($_FILES['media_file'], $type);
                if (!$upload) throw new \InvalidArgumentException("Gagal mengunggah berkas {$type}.");
                $mediaUrl = $upload['url'];
            } elseif (!$isUpdate && empty($mediaUrl)) {
                $label = $type === 'image' ? 'gambar' : 'dokumen';
                throw new \InvalidArgumentException("Silakan pilih berkas {$label} untuk diunggah.");
            }
        } elseif ($type === 'poll') {
            $text = (string) ($req->input('poll_options_text') ?? '');
            $items = array_values(array_filter(array_map('trim', explode("\n", $text))));
            $options = count($items) >= 2 ? $items : ['Pilihan 1', 'Pilihan 2'];
        } elseif ($type === 'button') {
            $options = $this->extractButtonOptions($req);
        }

        $res = ['options' => $options];
        if (in_array($type, ['image', 'document'], true) || $mediaUrl !== null) {
            $res['media_url'] = $mediaUrl;
        }
        return $res;
    }

    private function extractButtonOptions(Request $req): array {
        $keys = (array) ($req->input('menu_keys') ?? []);
        $labels = (array) ($req->input('menu_labels') ?? []);
        $kws = (array) ($req->input('menu_keywords') ?? []);
        $result = [];

        foreach ($keys as $i => $k) {
            $key = trim((string) $k);
            $lbl = trim((string) ($labels[$i] ?? ''));
            $target = trim((string) ($kws[$i] ?? ''));
            if (!empty($lbl) || !empty($target)) {
                $result[] = [
                    'key' => !empty($key) ? $key : (string) ($i + 1),
                    'label' => !empty($lbl) ? $lbl : $target,
                    'keyword' => !empty($target) ? $target : $lbl
                ];
            }
        }
        if (!empty($result)) return $result;

        $text = (string) ($req->input('button_options_text') ?? '');
        $lines = array_values(array_filter(array_map('trim', explode("\n", $text))));
        return !empty($lines) ? $this->parseMenuOptions($lines) : [['key' => '1', 'label' => 'Opsi 1', 'keyword' => 'opsi_1']];
    }

    private function parseMenuOptions(array $lines): array {
        $result = [];
        foreach ($lines as $i => $line) {
            if (str_contains($line, '|')) {
                $parts = array_map('trim', explode('|', $line));
                if (count($parts) >= 3) {
                    $result[] = ['key' => $parts[0], 'label' => $parts[1], 'keyword' => $parts[2]];
                } else {
                    $isKey = ctype_alnum($parts[0]) && strlen($parts[0]) <= 3;
                    $key = $isKey ? $parts[0] : (string) ($i + 1);
                    $result[] = ['key' => $key, 'label' => $isKey ? $parts[1] : $parts[0], 'keyword' => $parts[1]];
                }
            } elseif (preg_match('/^([0-9a-zA-Z]+)[\.\-\:\)]\s*(.+)$/', $line, $m)) {
                $result[] = ['key' => trim($m[1]), 'label' => trim($m[2]), 'keyword' => trim($m[2])];
            } else {
                $result[] = ['key' => (string) ($i + 1), 'label' => $line, 'keyword' => $line];
            }
        }
        return $result;
    }
}
