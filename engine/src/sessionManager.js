import fs from 'fs';
import path from 'path';
import { config } from './config.js';

class SessionManager {
    constructor() {
        this.sessions = new Map();
        if (!fs.existsSync(config.sessionsDir)) {
            fs.mkdirSync(config.sessionsDir, { recursive: true });
        }
    }

    async getOrCreateSession(sessionRef) {
        if (this.sessions.has(sessionRef)) {
            return this.sessions.get(sessionRef);
        }

        const sessionData = {
            sessionRef,
            status: 'qr_ready',
            phone: null,
            qr: null,
            createdAt: new Date(),
        };

        this.sessions.set(sessionRef, sessionData);
        return sessionData;
    }

    async sendCallbackToPhp(event, data) {
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
            console.error(`Gagal mengirim callback ke PHP (${event}):`, err.message);
        }
    }

    async sendMessage(sessionRef, phone, message) {
        const session = await this.getOrCreateSession(sessionRef);
        
        // Format JID WhatsApp (e.g. 6281234567890@s.whatsapp.net)
        const cleanPhone = phone.replace(/[^0-9]/g, '');
        const jid = `${cleanPhone}@s.whatsapp.net`;
        const waMessageId = 'BAE5' + Math.random().toString(36).substring(2, 10).toUpperCase();

        // Simulate async delivery callback
        setTimeout(() => {
            this.sendCallbackToPhp('messages.ack', {
                wa_message_id: waMessageId,
                status: 'delivered',
            });
        }, 1500);

        return {
            success: true,
            wa_message_id: waMessageId,
            jid,
        };
    }
}

export const sessionManager = new SessionManager();
