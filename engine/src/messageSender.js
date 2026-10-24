export function formatJid(phone) {
    const clean = phone.replace(/[^0-9]/g, '');
    return clean.includes('@') ? clean : `${clean}@s.whatsapp.net`;
}

export async function sendBaileysMessage(sock, phone, payload) {
    const jid = formatJid(phone);
    const type = payload.type || 'text';

    if (type === 'text') {
        return await sock.sendMessage(jid, { text: payload.message });
    }

    if (type === 'media' || type === 'image' || type === 'document') {
        const mediaUrl = payload.url || payload.media_url;
        const caption = payload.caption || payload.message || '';
        const isDoc = type === 'document' || (payload.filename && !payload.filename.match(/\.(jpg|jpeg|png)$/i));

        if (isDoc) {
            return await sock.sendMessage(jid, {
                document: { url: mediaUrl },
                mimetype: payload.mimetype || 'application/pdf',
                fileName: payload.filename || 'dokumen.pdf',
                caption,
            });
        }
        return await sock.sendMessage(jid, {
            image: { url: mediaUrl },
            caption,
        });
    }

    if (type === 'poll') {
        return await sock.sendMessage(jid, {
            poll: {
                name: payload.question || payload.message,
                values: payload.options || ['Pilihan 1', 'Pilihan 2'],
                selectableCount: payload.selectable_count || 1,
            },
        });
    }

    if (type === 'vcard' || type === 'contact') {
        const vcard = `BEGIN:VCARD\nVERSION:3.0\nFN:${payload.name || 'Kontak'}\nTEL;type=CELL;waid=${payload.phone}:${payload.phone}\nEND:VCARD`;
        return await sock.sendMessage(jid, {
            contacts: {
                displayName: payload.name || 'Kontak',
                contacts: [{ vcard }],
            },
        });
    }

    return await sock.sendMessage(jid, { text: payload.message || '' });
}
