<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Services\ApiKeyService;
use App\Services\DeviceService;
use App\Services\MessageService;
use App\Services\QuotaService;

class MessageApiController {
    private ApiKeyService $apiKeys;
    private DeviceService $devices;
    private MessageService $messages;
    private QuotaService $quota;

    public function __construct() {
        $this->apiKeys = new ApiKeyService();
        $this->devices = new DeviceService();
        $this->messages = new MessageService();
        $this->quota = new QuotaService();
    }

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
        if (!empty($reqId)) return $reqId;
        $devs = $this->devices->getDevices($tid);
        foreach ($devs as $d) { if ($d['status'] === 'connected') return $d['id']; }
        return $devs[0]['id'] ?? Response::apiError('no_device', 'Tenant belum memiliki perangkat.', 400);
    }

    public function send(Request $request): void {
        $t = $this->auth($request);
        $h = $this->headers($t['id']);
        if (!$this->quota->checkQuota($t['id'])['allowed']) Response::apiError('quota_exceeded', 'Kuota pesan bulan ini habis.', 402, $h);

        $d = $request->all();
        $to = trim((string) ($d['to'] ?? $d['phone'] ?? ''));
        $body = trim((string) ($d['text'] ?? $d['message'] ?? $d['body'] ?? ''));
        if (!$to || !$body) Response::apiError('validation_error', 'Field to dan text wajib diisi.', 422, $h);

        $msg = $this->messages->queueMessage($t['id'], $this->resolveDev($t['id'], (string) ($d['device_id'] ?? '')), $to, $body, $d['idempotency_key'] ?? null);
        $this->quota->recordUsage($t['id'], 1, 1);
        Response::json(['id' => $msg['id'], 'status' => 'queued'], 202, $h);
    }

    public function bulk(Request $request): void {
        $t = $this->auth($request);
        $h = $this->headers($t['id']);
        $d = $request->all();
        $msgs = $d['messages'] ?? [];
        if (!is_array($msgs) || empty($msgs)) Response::apiError('validation_error', 'Array messages wajib diisi.', 422, $h);

        $devId = $this->resolveDev($t['id'], (string) ($d['device_id'] ?? ''));
        $queued = 0;
        foreach ($msgs as $m) {
            $to = trim((string) ($m['to'] ?? ''));
            $txt = trim((string) ($m['text'] ?? $m['message'] ?? ''));
            if ($to && $txt) {
                $this->messages->queueMessage($t['id'], $devId, $to, $txt, $m['idempotency_key'] ?? null);
                $queued++;
            }
        }
        $this->quota->recordUsage($t['id'], $queued, 1);
        Response::json(['queued_count' => $queued, 'status' => 'queued'], 202, $h);
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
