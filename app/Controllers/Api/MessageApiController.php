<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\{Database, Request, Response};
use App\Services\{ApiKeyService, DeviceService, MessageService, QuotaService};

class MessageApiController {
    public function __construct(
        private ApiKeyService $apiKeys = new ApiKeyService(),
        private DeviceService $devices = new DeviceService(),
        private MessageService $messages = new MessageService(),
        private QuotaService $quota = new QuotaService()
    ) {}

    private function auth(Request $request): array {
        $token = $request->bearerToken();
        if (!$token) Response::apiError('unauthorized', 'Token Bearer wajib disertakan.', 401);
        $t = $this->apiKeys->validateRawKey($token);
        if (!$t) Response::apiError('invalid_api_key', 'API Key tidak valid atau dicabut.', 401);
        return $t;
    }

    private function headers(string $tid): array {
        $rl = $this->quota->getRateLimitInfo($tid);
        return ['X-RateLimit-Limit' => (string) $rl['limit'], 'X-RateLimit-Remaining' => (string) $rl['remaining'], 'X-RateLimit-Reset' => (string) $rl['reset']];
    }

    private function resolveDev(string $tid, string $reqId): string {
        $devs = $this->devices->getDevices($tid);
        foreach ($devs as $d) {
            if ($reqId !== '' && ($d['id'] === $reqId || ($d['phone_number'] ?? '') === $reqId)) return $d['id'];
        }
        foreach ($devs as $d) { if ($d['status'] === 'connected') return $d['id']; }
        if (!empty($devs[0]['id'])) return (string) $devs[0]['id'];
        Response::apiError('no_device', 'Tenant belum memiliki perangkat.', 400);
        return '';
    }

    public function send(Request $request): void {
        $t = $this->auth($request);
        $h = $this->headers($t['id']);
        if (!$this->quota->checkQuota($t['id'])['allowed']) Response::apiError('quota_exceeded', 'Kuota pesan bulan ini habis.', 402, $h);

        $d = $request->all();
        $to = trim((string) ($d['to'] ?? $d['phone'] ?? $d['number'] ?? $d['target'] ?? ''));
        $body = trim((string) ($d['text'] ?? $d['message'] ?? $d['body'] ?? $d['caption'] ?? ''));
        $mediaUrl = trim((string) ($d['url'] ?? $d['media_url'] ?? ''));
        if (!$to || (!$body && !$mediaUrl)) Response::apiError('validation_error', 'Field to/number dan text/message wajib diisi.', 422, $h);

        $type = !empty($mediaUrl) ? (string) ($d['media_type'] ?? 'image') : 'text';
        $extra = !empty($mediaUrl) ? ['media_url' => $mediaUrl, 'url' => $mediaUrl] : [];
        $devId = $this->resolveDev($t['id'], (string) ($d['device_id'] ?? $d['sender'] ?? ''));
        $msg = $this->messages->queueMessage($t['id'], $devId, $to, $body ?: $mediaUrl, $type, $extra, $d['idempotency_key'] ?? null);
        $this->quota->recordUsage($t['id'], 0, 1);
        Response::json(['id' => $msg['id'], 'status' => 'queued', 'success' => true], 202, $h);
    }

    public function bulk(Request $request): void {
        $t = $this->auth($request);
        $h = $this->headers($t['id']);
        if (!$this->quota->checkQuota($t['id'])['allowed']) Response::apiError('quota_exceeded', 'Kuota pesan bulan ini habis.', 402, $h);
        $d = $request->all();
        $msgs = $d['messages'] ?? [];
        if (!is_array($msgs) || empty($msgs)) Response::apiError('validation_error', 'Array messages wajib diisi.', 422, $h);

        $devId = $this->resolveDev($t['id'], (string) ($d['device_id'] ?? $d['sender'] ?? ''));
        $queued = 0;
        foreach ($msgs as $m) {
            $to = trim((string) ($m['to'] ?? $m['phone'] ?? $m['number'] ?? ''));
            $txt = trim((string) ($m['text'] ?? $m['message'] ?? ''));
            if ($to && $txt && ++$queued) $this->messages->queueMessage($t['id'], $devId, $to, $txt, 'text', [], $m['idempotency_key'] ?? null);
        }
        $this->quota->recordUsage($t['id'], 0, $queued);
        Response::json(['queued_count' => $queued, 'status' => 'queued', 'success' => true], 202, $h);
    }

    public function show(Request $request, string $id): void {
        $t = $this->auth($request);
        $h = $this->headers($t['id']);
        $msg = Database::fetchOne("SELECT * FROM messages WHERE id = :id AND tenant_id = :tid", ['id' => $id, 'tid' => $t['id']]);
        if (!$msg) Response::apiError('not_found', 'Pesan tidak ditemukan.', 404, $h);
        $events = Database::fetchAll("SELECT status, occurred_at FROM message_events WHERE message_id = :id ORDER BY occurred_at ASC", ['id' => $id]);
        Response::json(array_merge($msg, ['events' => $events]), 200, $h);
    }

    public function index(Request $request): void {
        $t = $this->auth($request);
        $list = $this->messages->getMessages($t['id'], $request->get('status'), $request->get('q'), min(100, max(1, (int) ($request->get('limit', 50)))));
        Response::json(['data' => $list], 200, $this->headers($t['id']));
    }
}

