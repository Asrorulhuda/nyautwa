import fs from 'fs';
import path from 'path';
import { savePollMessage } from './pollHandler.js';
import { sentMessageStore } from './baileysSocket.js';

export function formatJid(phone) {
    if (typeof phone !== 'string') return '';
    const trimmed = phone.trim();
    if (trimmed.endsWith('@g.us') || trimmed.endsWith('@lid')) return trimmed;
    let clean = trimmed.split('@')[0].split(':')[0].replace(/[^0-9]/g, '');
    if (clean.startsWith('08')) clean = '628' + clean.slice(2);
    else if (clean.startsWith('8')) clean = '628' + clean.slice(1);
    return `${clean}@s.whatsapp.net`;
}

function resolveMedia(url) {
    if (!url || typeof url !== 'string') return url;
    if (url.includes('/uploads/')) {
        const file = url.split('/uploads/').pop().split('?')[0];
        const local = path.resolve('../public/uploads', file);
        if (fs.existsSync(local)) return local;
    }
    return url;
}

export async function sendBaileysMessage(sock, phone, payload) {
    const jid = formatJid(phone);
    const type = payload.type || 'text';
    let res;

    if (type === 'text') res = await sock.sendMessage(jid, { text: payload.message });

    if (type === 'media' || type === 'image' || type === 'document') {
        const mediaUrl = resolveMedia(payload.url || payload.media_url);
        const caption = payload.caption || payload.message || '';
        const isDoc = type === 'document' || (payload.filename && !payload.filename.match(/\.(jpg|jpeg|png)$/i));

        if (isDoc) {
            res = await sock.sendMessage(jid, { document: { url: mediaUrl }, mimetype: payload.mimetype || 'application/pdf', fileName: payload.filename || 'dokumen.pdf', caption });
        } else {
            res = await sock.sendMessage(jid, { image: { url: mediaUrl }, caption });
        }
    } else if (type === 'poll') {
        const pollOpts = payload.options || ['Pilihan 1', 'Pilihan 2'];
        res = await sock.sendMessage(jid, { poll: { name: payload.question || payload.message, values: pollOpts, selectableCount: payload.selectable_count || 1 } });
        savePollMessage(res, pollOpts);
    } else if (type === 'button') {
        const rawBtns = Array.isArray(payload.buttons) ? payload.buttons : (payload.options || ['Ya', 'Tidak']);
        const header = payload.title ? `*${payload.title}*\n\n` : '';
        const body = payload.message || 'Silakan pilih salah satu opsi:';
        const footer = payload.footer ? `\n\n_${payload.footer}_` : '';
        const btnList = rawBtns.map((b, i) => {
            if (typeof b === 'object' && b !== null) {
                const k = b.key || `${i + 1}`;
                return `*${k}*. ${b.label || b.text || b.keyword || `Opsi ${k}`}`;
            }
            return `*${i + 1}*. ${typeof b === 'string' ? b : b.text}`;
        }).join('\n');
        res = await sock.sendMessage(jid, { text: `${header}${body}\n\n${btnList}${footer}\n\n_Ketik angka/kode atau nama opsi di atas._` });
    } else if (type === 'vcard' || type === 'contact') {
        const vcard = `BEGIN:VCARD\nVERSION:3.0\nFN:${payload.name || 'Kontak'}\nTEL;type=CELL;waid=${payload.phone}:${payload.phone}\nEND:VCARD`;
        res = await sock.sendMessage(jid, { contacts: { displayName: payload.name || 'Kontak', contacts: [{ vcard }] } });
    } else if (!res) {
        res = await sock.sendMessage(jid, { text: payload.message || '' });
    }

    if (res?.key?.id) {
        sentMessageStore.set(res.key.id, res.message || { conversation: payload.message || payload.caption || '' });
    }
    return res;
}
