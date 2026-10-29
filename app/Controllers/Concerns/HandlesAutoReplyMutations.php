<?php

declare(strict_types=1);

namespace App\Controllers\Concerns;

use App\Core\Request;
use App\Core\Response;

trait HandlesAutoReplyMutations {
    use ParsesAutoReplyInput;

    public function create(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi tidak sah atau kedaluwarsa.', '/autoreplies');
            return;
        }

        $kw = trim((string) $request->input('keyword', ''));
        $resp = trim((string) $request->input('response', ''));
        if (empty($kw) || empty($resp)) {
            Response::withFlash('error', 'Kata kunci dan pesan balasan wajib diisi.', '/autoreplies');
            return;
        }

        $type = (string) $request->input('type', 'text');
        try {
            $parsed = $this->parsePayload($request, $type);
        } catch (\Throwable $e) {
            Response::withFlash('error', $e->getMessage(), '/autoreplies');
            return;
        }

        $this->service->create($tenantId, [
            'device_id' => $request->input('device_id') ?: null, 'keyword' => $kw,
            'match_type' => $request->input('match_type', 'contain'), 'type' => $type,
            'response' => $resp, 'media_url' => $parsed['media_url'] ?? null,
            'options' => $parsed['options'], 'delay_seconds' => (int) $request->input('delay_seconds', 1),
        ]);
        Response::withFlash('success', 'Aturan balas otomatis berhasil ditambahkan.', '/autoreplies');
    }

    public function update(Request $request, string $id): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi kedaluwarsa.', '/autoreplies');
            return;
        }

        $item = $this->service->find($id, $tenantId);
        if (!$item) {
            Response::withFlash('error', 'Aturan tidak ditemukan.', '/autoreplies');
            return;
        }

        $kw = trim((string) $request->input('keyword', ''));
        $resp = trim((string) $request->input('response', ''));
        $type = (string) $request->input('type', $item['type'] ?? 'text');

        try {
            $parsed = $this->parsePayload($request, $type, true, $item['media_url']);
        } catch (\Throwable $e) {
            Response::withFlash('error', $e->getMessage(), '/autoreplies');
            return;
        }

        $data = [
            'device_id' => $request->input('device_id') ?: null,
            'keyword' => !empty($kw) ? $kw : $item['keyword'],
            'match_type' => $request->input('match_type', $item['match_type']),
            'type' => $type, 'response' => !empty($resp) ? $resp : $item['response'],
            'options' => $parsed['options'], 'delay_seconds' => (int) $request->input('delay_seconds', 1),
        ];
        if (array_key_exists('media_url', $parsed)) $data['media_url'] = $parsed['media_url'];

        $this->service->update($id, $tenantId, $data);
        Response::withFlash('success', 'Aturan balas otomatis berhasil diperbarui.', '/autoreplies');
    }
}
