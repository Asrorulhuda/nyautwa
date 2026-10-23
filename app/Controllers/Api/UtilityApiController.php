<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;
use App\Services\ApiKeyService;
use App\Services\MessageService;
use App\Services\QuotaService;

class UtilityApiController {
    private ApiKeyService $apiKeys;
    private QuotaService $quota;
    private MessageService $messages;

    public function __construct() {
        $this->apiKeys = new ApiKeyService();
        $this->quota = new QuotaService();
        $this->messages = new MessageService();
    }

    private function authenticate(Request $request): array {
        $token = $request->bearerToken();
        if (!$token) {
            Response::apiError('unauthorized', 'Header Authorization Bearer token wajib disertakan.', 401);
        }
        $tenant = $this->apiKeys->validateRawKey($token);
        if (!$tenant) {
            Response::apiError('invalid_api_key', 'API Key tidak valid atau telah dicabut.', 401);
        }
        $this->quota->recordUsage($tenant['id'], 0, 1);
        return $tenant;
    }

    public function usage(Request $request): void {
        $tenant = $this->authenticate($request);
        $qc = $this->quota->checkQuota($tenant['id']);
        $rl = $this->quota->getRateLimitInfo($tenant['id']);
        $headers = [
            'X-RateLimit-Limit' => (string) $rl['limit'],
            'X-RateLimit-Remaining' => (string) $rl['remaining'],
            'X-RateLimit-Reset' => (string) $rl['reset'],
        ];

        Response::json([
            'plan' => $qc['plan_id'],
            'monthly_limit' => $qc['monthly_limit'],
            'sent_month' => $qc['sent_month'],
            'remaining_month' => $qc['remaining_month'],
            'daily_limit' => $qc['daily_limit'],
            'sent_today' => $qc['sent_today'],
            'remaining_today' => $qc['remaining_today'],
        ], 200, $headers);
    }

    public function checkNumber(Request $request): void {
        $tenant = $this->authenticate($request);
        $rl = $this->quota->getRateLimitInfo($tenant['id']);
        $headers = [
            'X-RateLimit-Limit' => (string) $rl['limit'],
            'X-RateLimit-Remaining' => (string) $rl['remaining'],
            'X-RateLimit-Reset' => (string) $rl['reset'],
        ];

        $data = $request->all();
        $raw = trim((string) ($data['number'] ?? $data['phone'] ?? ''));
        if (empty($raw)) {
            Response::apiError('validation_error', 'Field number wajib disertakan.', 422, $headers);
        }

        $normalized = ltrim($this->messages->normalizePhone($raw), '+');
        $validPrefixes = ['628', '621', '622'];
        $isValidWa = strlen($normalized) >= 10 && strlen($normalized) <= 15;

        Response::json([
            'number' => $normalized,
            'exists' => $isValidWa,
            'jid' => $isValidWa ? "{$normalized}@s.whatsapp.net" : null,
        ], 200, $headers);
    }
}
