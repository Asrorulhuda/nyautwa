<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;

class DeployController {
    public function handle(Request $request): void {
        $token = $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? ($request->input('token') ?? '');
        $secret = $_ENV['DEPLOY_SECRET'] ?? ($_ENV['ENGINE_SECRET'] ?? 'nyautwa_deploy_secret_994821');

        if (empty($token) || $token !== $secret) {
            Response::json(['error' => 'Akses ditolak: Token deploy tidak valid'], 403);
            return;
        }

        $baseDir = dirname(__DIR__, 3);
        $output = [];
        $returnCode = 0;

        exec("cd {$baseDir} && git pull origin main 2>&1", $output, $returnCode);

        Response::json([
            'success' => $returnCode === 0,
            'message' => $returnCode === 0 ? 'Deploy git pull berhasil' : 'Git pull mengembalikan kode non-zero',
            'output' => $output,
        ]);
    }
}
