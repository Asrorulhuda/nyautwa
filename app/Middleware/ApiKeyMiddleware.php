<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Services\ApiKeyService;

class ApiKeyMiddleware {
    private ApiKeyService $apiKeys;

    public function __construct() {
        $this->apiKeys = new ApiKeyService();
    }

    public function handle(Request $request): bool {
        $token = $request->bearerToken();
        if (!$token) {
            Response::json([
                'success' => false,
                'error' => 'Header Authorization Bearer token wajib disertakan.',
            ], 401);
            return false;
        }

        $tenant = $this->apiKeys->validateRawKey($token);
        if (!$tenant) {
            Response::json([
                'success' => false,
                'error' => 'API Key tidak valid atau telah dicabut.',
            ], 401);
            return false;
        }

        // Attach tenant to global request state
        $GLOBALS['current_api_tenant'] = $tenant;
        return true;
    }
}
