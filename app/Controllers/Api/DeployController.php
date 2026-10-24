<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Request;
use App\Core\Response;

class DeployController {
    public function handle(Request $request): void {
        $secret = (string) env('DEPLOY_SECRET', 'nyautwa_deploy_secret_994821');
        $rawPayload = file_get_contents('php://input') ?: '';
        
        $token = $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? ($request->input('token') ?? ($_POST['token'] ?? ''));
        $hubSig = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

        $isTokenValid = hash_equals($secret, (string) $token);
        $isSigValid = false;

        if (!empty($hubSig) && str_starts_with($hubSig, 'sha256=')) {
            $expectedSig = 'sha256=' . hash_hmac('sha256', $rawPayload, $secret);
            $isSigValid = hash_equals($expectedSig, $hubSig);
        }

        if (!$isTokenValid && !$isSigValid) {
            Response::json(['error' => 'Akses ditolak: Secret token atau signature GitHub webhook tidak valid'], 403);
            return;
        }

        $projectRoot = dirname(__DIR__, 3);
        $cmd = "cd " . escapeshellarg($projectRoot) . " && git fetch origin main 2>&1 && git reset --hard origin/main 2>&1";
        
        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        $outText = implode("\n", $output);
        error_log("GitHub Webhook Deploy Executed [Exit: {$returnCode}]: " . $outText);

        Response::json([
            'success' => ($returnCode === 0),
            'message' => ($returnCode === 0) ? 'Auto deploy berhasil disinkronkan' : 'Proses auto deploy mengalami kendala',
            'output' => $output,
            'timestamp' => date('Y-m-d H:i:s'),
        ], ($returnCode === 0 ? 200 : 500));
    }
}
