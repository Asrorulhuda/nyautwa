<?php

declare(strict_types=1);

namespace App\Controllers\Concerns;

use App\Core\Request;

trait InteractsWithMessagePayload {
    protected function buildExtraPayload(Request $req, string $type, string &$body): array {
        if ($type === 'image') return ['url' => trim((string)$req->input('media_url', '')), 'caption' => $body];
        if ($type === 'document') {
            return ['url' => trim((string)$req->input('doc_url', '')), 'filename' => trim((string)$req->input('filename', 'dokumen.pdf')), 'caption' => $body];
        }
        if ($type === 'poll') {
            $q = trim((string)$req->input('poll_question', $body));
            $body = $q;
            $opts = array_values(array_filter(array_map('trim', explode("\n", (string)$req->input('poll_options', '')))));
            return ['question' => $q, 'options' => count($opts) >= 2 ? $opts : ['Pilihan 1', 'Pilihan 2']];
        }
        if ($type === 'button') {
            $raw = array_values(array_filter(array_map('trim', explode("\n", (string)$req->input('buttons_list', '')))));
            return ['buttons' => count($raw) > 0 ? $raw : ['Pilihan Ya', 'Pilihan Tidak'], 'footer' => (string)$req->input('footer_text', 'NyautWa Gateway')];
        }
        return [];
    }
}
