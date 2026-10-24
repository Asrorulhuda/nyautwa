import makeWASocket, {
    useMultiFileAuthState,
    DisconnectReason,
    fetchLatestBaileysVersion
} from '@whiskeysockets/baileys';
import pino from 'pino';
import path from 'path';
import { config } from './config.js';

export async function createBaileysSocket(sessionRef, eventCallbacks) {
    const sessionDir = path.join(config.sessionsDir, sessionRef);
    const { state, saveCreds } = await useMultiFileAuthState(sessionDir);
    const { version } = await fetchLatestBaileysVersion().catch(() => ({ version: [2, 3000, 1015901307] }));

    const sock = makeWASocket({
        version,
        auth: state,
        logger: pino({ level: 'silent' }),
        printQRInTerminal: false,
        browser: ['NyautWa Gateway', 'Chrome', '124.0.0.0'],
        syncFullHistory: false,
        markOnlineOnConnect: true,
        generateHighQualityLinkPreview: true,
    });

    sock.ev.on('creds.update', saveCreds);

    if (eventCallbacks.onConnectionUpdate) {
        sock.ev.on('connection.update', (update) => {
            eventCallbacks.onConnectionUpdate(update, sock);
        });
    }

    if (eventCallbacks.onMessagesUpsert) {
        sock.ev.on('messages.upsert', (upsert) => {
            eventCallbacks.onMessagesUpsert(upsert, sock);
        });
    }

    return { sock, saveCreds };
}

export function isSessionLoggedOut(error) {
    const statusCode = error?.output?.statusCode;
    return statusCode === DisconnectReason.loggedOut;
}
