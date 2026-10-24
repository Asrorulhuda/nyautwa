import QRCode from 'qrcode';
import { config } from './config.js';
import { isSessionLoggedOut } from './baileysSocket.js';

export async function sendCallbackToPhp(event, data) {
    try {
        await fetch(config.phpCallbackUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Engine-Secret': config.secret,
            },
            body: JSON.stringify({ event, data }),
        });
    } catch (err) {
        console.error(`[Callback] Gagal kirim (${event}):`, err.message);
    }
}

export function handleConnectionUpdate(session, update, sock, onRestart) {
    const { connection, lastDisconnect, qr } = update;

    if (qr) {
        QRCode.toDataURL(qr, { width: 320, margin: 2 }, (err, url) => {
            if (!err) {
                session.qr = url;
                session.status = 'qr_ready';
                sendCallbackToPhp('connection.qr', { session_ref: session.sessionRef, qr: url });
            }
        });
    }

    if (connection === 'close') {
        const shouldReconnect = !isSessionLoggedOut(lastDisconnect?.error);
        session.status = 'disconnected';
        session.qr = null;
        sendCallbackToPhp('connection.disconnected', {
            session_ref: session.sessionRef,
            reason: lastDisconnect?.error?.message || 'closed',
        });
        if (shouldReconnect && typeof onRestart === 'function') {
            setTimeout(onRestart, 5000);
        }
    } else if (connection === 'open') {
        session.status = 'connected';
        session.qr = null;
        const jid = sock.user?.id || '';
        const phone = jid.split(':')[0] || jid.split('@')[0];
        session.phone = phone;
        sendCallbackToPhp('connection.connected', {
            session_ref: session.sessionRef,
            phone,
            name: sock.user?.name || 'WhatsApp User',
        });
    }
}

export function handleMessagesUpsert(session, upsert) {
    if (upsert.type !== 'notify') return;
    for (const msg of upsert.messages) {
        if (!msg.key.fromMe && msg.message) {
            const sender = (msg.key.remoteJid || '').split('@')[0];
            const text = msg.message.conversation ||
                         msg.message.extendedTextMessage?.text ||
                         msg.message.imageMessage?.caption || '';
            sendCallbackToPhp('messages.incoming', {
                session_ref: session.sessionRef,
                sender,
                text,
                message_id: msg.key.id,
                timestamp: msg.messageTimestamp,
            });
        }
    }
}
