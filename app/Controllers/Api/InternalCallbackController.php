<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Services\EngineService;

class InternalCallbackController {
    public function handle(Request $request): void {
        $secret = $_SERVER['HTTP_X_ENGINE_SECRET'] ?? '';
        $expected = $_ENV['ENGINE_SECRET'] ?? 'nyautwa_engine_internal_secret_994821';
        if ($secret !== $expected) {
            Response::json(['error' => 'Akses ditolak'], 403);
            return;
        }

        $event = (string) $request->input('event');
        $data = (array) $request->input('data', []);
        $sessionRef = $data['session_ref'] ?? '';

        if ($event === 'connection.connected') {
            Database::query(
                "UPDATE devices SET status = 'connected', phone = :phone, qr_code = NULL, updated_at = CURRENT_TIMESTAMP WHERE session_ref = :ref",
                ['phone' => $data['phone'] ?? null, 'ref' => $sessionRef]
            );
        } elseif ($event === 'connection.disconnected') {
            Database::query(
                "UPDATE devices SET status = 'disconnected', qr_code = NULL, updated_at = CURRENT_TIMESTAMP WHERE session_ref = :ref",
                ['ref' => $sessionRef]
            );
        } elseif ($event === 'connection.qr') {
            Database::query(
                "UPDATE devices SET qr_code = :qr, status = 'pending_qr', updated_at = CURRENT_TIMESTAMP WHERE session_ref = :ref",
                ['qr' => $data['qr'] ?? null, 'ref' => $sessionRef]
            );
        } elseif ($event === 'messages.incoming') {
            $this->handleIncomingMessage($sessionRef, $data);
        }

        Response::json(['success' => true]);
    }

    private function handleIncomingMessage(string $sessionRef, array $data): void {
        $device = Database::fetchOne("SELECT * FROM devices WHERE session_ref = :ref", ['ref' => $sessionRef]);
        if (!$device) return;

        $sender = (string) ($data['sender'] ?? '');
        $text = trim((string) ($data['text'] ?? ''));
        if (empty($sender) || empty($text)) return;

        // Auto-reply matcher
        $reply = Database::fetchOne(
            "SELECT * FROM autoreplies WHERE tenant_id = :tid AND status = 'active' AND (
                (match_type = 'exact' AND LOWER(keyword) = LOWER(:text)) OR 
                (match_type = 'contain' AND LOWER(:text) LIKE LOWER(CONCAT('%', keyword, '%')))
             ) LIMIT 1",
            ['tid' => $device['tenant_id'], 'text' => $text]
        );

        if ($reply) {
            $engine = new EngineService();
            $engine->sendMessage($sessionRef, $sender, [
                'type' => $reply['type'] ?? 'text',
                'message' => $reply['response'],
                'url' => $reply['media_url'] ?? null,
            ]);
        }
    }
}
