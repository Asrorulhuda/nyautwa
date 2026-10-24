import fs from 'fs';
import path from 'path';
import { config } from './config.js';
import { createBaileysSocket } from './baileysSocket.js';
import { handleConnectionUpdate, handleMessagesUpsert } from './eventHandler.js';
import { sendBaileysMessage } from './messageSender.js';

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

        const session = {
            sessionRef,
            status: 'initializing',
            phone: null,
            qr: null,
            sock: null,
            createdAt: new Date(),
        };
        this.sessions.set(sessionRef, session);

        const initSocket = async () => {
            const { sock } = await createBaileysSocket(sessionRef, {
                onConnectionUpdate: (update) => handleConnectionUpdate(session, update, sock, initSocket),
                onMessagesUpsert: (upsert) => handleMessagesUpsert(session, upsert),
            });
            session.sock = sock;
        };

        await initSocket();
        return session;
    }

    async requestPairingCode(sessionRef, phone) {
        const session = await this.getOrCreateSession(sessionRef);
        if (!session.sock) {
            throw new Error('Socket sesi belum siap');
        }
        const cleanPhone = phone.replace(/[^0-9]/g, '');
        const code = await session.sock.requestPairingCode(cleanPhone);
        return code;
    }

    async sendMessage(sessionRef, phone, payload) {
        const session = await this.getOrCreateSession(sessionRef);
        if (!session.sock) {
            throw new Error(`Perangkat (${sessionRef}) belum aktif`);
        }
        const result = await sendBaileysMessage(session.sock, phone, payload);
        return {
            success: true,
            wa_message_id: result?.key?.id || ('MSG_' + Date.now()),
            recipient: phone,
        };
    }

    async logoutSession(sessionRef) {
        const session = this.sessions.get(sessionRef);
        if (session?.sock) {
            try { await session.sock.logout(); } catch {}
        }
        this.sessions.delete(sessionRef);
        const sessionDir = path.join(config.sessionsDir, sessionRef);
        if (fs.existsSync(sessionDir)) {
            fs.rmSync(sessionDir, { recursive: true, force: true });
        }
        return { success: true, message: 'Sesi berhasil di-logout dan kredensial dibersihkan' };
    }
}

export const sessionManager = new SessionManager();
