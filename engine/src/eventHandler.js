import QRCode from 'qrcode';
import { config } from './config.js';
import { isSessionLoggedOut, sentMessageStore } from './baileysSocket.js';
import { handlePollVote } from './pollHandler.js';
import { extractText } from './messageTextExtractor.js';

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
        if (msg.key?.id && msg.message) sentMessageStore.set(msg.key.id, msg.message);
        if (!msg.key.fromMe && msg.message) {
            const raw = msg.key.remoteJid || '';
            if (raw === 'status@broadcast') continue;
            let sender = raw.split('@')[0].split(':')[0];
            if (raw.endsWith('@g.us')) sender = raw;
            else if (raw.endsWith('@lid')) sender = session.lidMap?.get(raw) || session.lidMap?.get(raw.split('@')[0]) || raw;
            const text = extractText(msg.message);
            if (!text) continue;
            console.log(`[Pesan Masuk] Dari ${sender} (raw: ${raw}): "${text}"`);
            sendCallbackToPhp('messages.incoming', {
                session_ref: session.sessionRef,
                sender,
                raw_sender: raw,
                text,
                message_id: msg.key.id,
                timestamp: msg.messageTimestamp,
            });
        }
    }
}

export function handleMessagesUpdate(session, updates) {
    if (!Array.isArray(updates)) return;
    for (const u of updates) {
        if (u.update?.pollUpdates) handlePollVote(session, u);
    }
}
