import fs from 'fs';
import path from 'path';
import { config } from './config.js';
import { createBaileysSocket } from './baileysSocket.js';
import { handleConnectionUpdate, handleMessagesUpsert, handleMessagesUpdate } from './eventHandler.js';
import { sendBaileysMessage } from './messageSender.js';

class SessionManager {
    constructor() {
        this.sessions = new Map();
        if (!fs.existsSync(config.sessionsDir)) fs.mkdirSync(config.sessionsDir, { recursive: true });
    }

    async getOrCreateSession(sessionRef) {
        if (this.sessions.has(sessionRef)) return this.sessions.get(sessionRef);
        const session = { sessionRef, status: 'initializing', phone: null, qr: null, sock: null, contacts: new Map(), lidMap: new Map() };
        this.sessions.set(sessionRef, session);

        const mapLid = (c) => {
            if (c?.id && c.id.endsWith('@s.whatsapp.net') && c.lid) {
                const p = c.id.split('@')[0].split(':')[0];
                session.lidMap.set(c.lid, p);
                session.lidMap.set(c.lid.split('@')[0], p);
            }
        };

        const initSocket = async () => {
            const { sock } = await createBaileysSocket(sessionRef, {
                onConnectionUpdate: (update) => handleConnectionUpdate(session, update, sock, initSocket),
                onMessagesUpsert: (upsert) => handleMessagesUpsert(session, upsert),
                onMessagesUpdate: (updates) => handleMessagesUpdate(session, updates),
            });
            sock.ev.on('contacts.set', ({ contacts }) => contacts && contacts.forEach(c => { if (c.id) { session.contacts.set(c.id, c); mapLid(c); } }));
            sock.ev.on('contacts.upsert', (cs) => cs && cs.forEach(c => { if (c.id) { session.contacts.set(c.id, Object.assign(session.contacts.get(c.id) || {}, c)); mapLid(c); } }));
            sock.ev.on('contacts.update', (cs) => cs && cs.forEach(c => { if (c.id) { session.contacts.set(c.id, Object.assign(session.contacts.get(c.id) || {}, c)); mapLid(c); } }));
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
            const lidMap = new Map();
            for (const [jid, c] of session.contacts.entries()) {
                if (jid.endsWith('@s.whatsapp.net') && c?.lid) {
                    lidMap.set(c.lid, jid.split('@')[0].split(':')[0]);
                }
            }
            for (const [jid, c] of session.contacts.entries()) {
                if (jid.endsWith('@g.us')) continue;
                let phone = jid.endsWith('@s.whatsapp.net') ? jid.split('@')[0].split(':')[0] : (lidMap.get(jid) || null);
                if (!phone || phone.length < 8) continue;
                if (phone.startsWith('08')) phone = '628' + phone.slice(2);
                else if (phone.startsWith('8')) phone = '628' + phone.slice(1);
                list.push({ jid: `${phone}@s.whatsapp.net`, phone, name: c.name || c.notify || ('Kontak ' + phone), is_group: false });
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
