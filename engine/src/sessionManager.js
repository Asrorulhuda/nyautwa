import fs from 'fs';
import path from 'path';
import { config } from './config.js';
import { createBaileysSocket } from './baileysSocket.js';
import { handleConnectionUpdate, handleMessagesUpsert } from './eventHandler.js';
import { sendBaileysMessage } from './messageSender.js';

class SessionManager {
    constructor() {
        this.sessions = new Map();
        if (!fs.existsSync(config.sessionsDir)) fs.mkdirSync(config.sessionsDir, { recursive: true });
    }

    async getOrCreateSession(sessionRef) {
        if (this.sessions.has(sessionRef)) return this.sessions.get(sessionRef);
        const session = { sessionRef, status: 'initializing', phone: null, qr: null, sock: null, contacts: new Map() };
        this.sessions.set(sessionRef, session);

        const initSocket = async () => {
            const { sock } = await createBaileysSocket(sessionRef, {
                onConnectionUpdate: (update) => handleConnectionUpdate(session, update, sock, initSocket),
                onMessagesUpsert: (upsert) => handleMessagesUpsert(session, upsert),
            });
            sock.ev.on('contacts.upsert', (cs) => cs.forEach(c => c.id && session.contacts.set(c.id, c)));
            session.sock = sock;
        };

        await initSocket();
        return session;
    }

    async requestPairingCode(sessionRef, phone) {
        const session = await this.getOrCreateSession(sessionRef);
        if (!session.sock) throw new Error('Socket sesi belum siap');
        return await session.sock.requestPairingCode(phone.replace(/[^0-9]/g, ''));
    }

    async sendMessage(sessionRef, phone, payload) {
        const session = await this.getOrCreateSession(sessionRef);
        if (!session.sock) throw new Error(`Perangkat (${sessionRef}) belum aktif`);
        const result = await sendBaileysMessage(session.sock, phone, payload);
        return { success: true, wa_message_id: result?.key?.id || ('MSG_' + Date.now()), recipient: phone };
    }

    async getContactsAndGroups(sessionRef) {
        const session = await this.getOrCreateSession(sessionRef);
        if (!session.sock) throw new Error('Perangkat belum terhubung ke WhatsApp');
        const list = [];
        try {
            const groups = await session.sock.groupFetchAllParticipating();
            for (const [jid, g] of Object.entries(groups)) {
                list.push({ jid, phone: jid, name: g.subject || 'Grup WA', is_group: true, count: g.participants?.length || 0 });
            }
        } catch {}
        if (session.contacts) {
            for (const [jid, c] of session.contacts.entries()) {
                if (!jid.endsWith('@g.us')) {
                    const phone = jid.split('@')[0].split(':')[0];
                    list.push({ jid, phone, name: c.name || c.notify || ('Kontak ' + phone), is_group: false });
                }
            }
        }
        return list;
    }

    async logoutSession(sessionRef) {
        const session = this.sessions.get(sessionRef);
        if (session?.sock) { try { await session.sock.logout(); } catch {} }
        this.sessions.delete(sessionRef);
        const dir = path.join(config.sessionsDir, sessionRef);
        if (fs.existsSync(dir)) fs.rmSync(dir, { recursive: true, force: true });
        return { success: true, message: 'Sesi berhasil di-logout' };
    }
}

export const sessionManager = new SessionManager();
