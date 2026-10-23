<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;

class CallbackApiController {
    public function handle(Request $request): void {
        $secret = $request->header('x-engine-secret');
        $expectedSecret = env('ENGINE_SECRET', 'nyautwa_engine_internal_secret_994821');

        if (!$secret || !hash_equals((string) $expectedSecret, (string) $secret)) {
            Response::json(['error' => 'Unauthorized engine access'], 403);
        }

        $payload = $request->json();
        $event = $payload['event'] ?? '';
        $data = $payload['data'] ?? [];

        switch ($event) {
            case 'connection.update':
                $sessionRef = $data['session_ref'] ?? '';
                $status = $data['status'] ?? 'disconnected';
                $phone = $data['phone'] ?? null;
                $qr = $data['qr'] ?? null;

                $params = ['status' => $status, 'session_ref' => $sessionRef];
                $sql = "UPDATE devices SET status = :status";
                if ($phone) {
                    $sql .= ", phone = :phone";
                    $params['phone'] = $phone;
                }
                if ($qr) {
                    $sql .= ", qr_code = :qr";
                    $params['qr'] = $qr;
                }
                $sql .= " WHERE session_ref = :session_ref";
                Database::query($sql, $params);
                break;

            case 'messages.ack':
                $wamid = $data['wa_message_id'] ?? '';
                $status = $data['status'] ?? 'delivered';
                if ($wamid) {
                    Database::query(
                        "UPDATE messages SET status = :status WHERE wa_message_id = :wamid",
                        ['status' => $status, 'wamid' => $wamid]
                    );
                }
                break;

            case 'messages.upsert':
                // Inbound message received from WhatsApp
                $sessionRef = $data['session_ref'] ?? '';
                $sender = $data['sender'] ?? '';
                $body = $data['body'] ?? '';
                $wamid = $data['id'] ?? '';

                $device = Database::fetchOne("SELECT * FROM devices WHERE session_ref = :ref", ['ref' => $sessionRef]);
                if ($device) {
                    $msgId = 'msg_in_' . bin2hex(random_bytes(6));
                    Database::query(
                        "INSERT INTO messages (id, tenant_id, device_id, direction, to_from, type, body, status, wa_message_id, created_at) 
                         VALUES (:id, :tenant_id, :device_id, 'inbound', :sender, 'text', :body, 'delivered', :wamid, CURRENT_TIMESTAMP)",
                        [
                            'id' => $msgId,
                            'tenant_id' => $device['tenant_id'],
                            'device_id' => $device['id'],
                            'sender' => $sender,
                            'body' => $body,
                            'wamid' => $wamid,
                        ]
                    );
                }
                break;
        }

        Response::json(['success' => true, 'event' => $event]);
    }
}
