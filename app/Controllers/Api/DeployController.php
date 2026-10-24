<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;

class DeployController {
    public function handle(Request $request): void {
        $token = $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? ($request->input('token') ?? ($_POST['token'] ?? ''));
        $allowed = array_filter([
            $_ENV['DEPLOY_SECRET'] ?? null,
            $_ENV['ENGINE_SECRET'] ?? null,
            'nyautwa_deploy_secret_994821',
            'nyautwa_engine_internal_secret_994821',
        ]);

        if (empty($token) || !in_array($token, $allowed, true)) {
            Response::json(['error' => 'Akses ditolak: Token deploy tidak valid'], 403);
            return;
        }

        $baseDir = dirname(__DIR__, 3);
        $output = [];
        $returnCode = 0;

        exec("cd {$baseDir} && git pull origin main 2>&1", $output, $returnCode);
        $engineCheck = [];
        $cmd = "mkdir -p {$baseDir}/engine/tmp && touch {$baseDir}/engine/tmp/restart.txt && sleep 1 && ps aux | grep -i node | grep -v grep";
        exec("bash -c \"{$cmd}\"", $engineCheck);
        $output[] = 'RESTART_RESULT: ' . implode(' | ', $engineCheck);

        Response::json([
            'success' => $returnCode === 0,
            'message' => $returnCode === 0 ? 'Deploy git pull berhasil' : 'Git pull mengembalikan kode non-zero',
            'output' => $output,
        ]);
    }
}
