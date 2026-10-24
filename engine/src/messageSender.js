export function formatJid(phone) {
    if (typeof phone !== 'string') return '';
    const trimmed = phone.trim();
    if (trimmed.endsWith('@g.us') || trimmed.endsWith('@s.whatsapp.net')) return trimmed;
    const clean = trimmed.replace(/[^0-9]/g, '');
    return `${clean}@s.whatsapp.net`;
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

    if (type === 'button') {
        const rawBtns = Array.isArray(payload.buttons) ? payload.buttons : (payload.options || ['Ya', 'Tidak']);
        const buttons = rawBtns.map((b, i) => ({
            buttonId: 'btn_' + i,
            buttonText: { displayText: typeof b === 'string' ? b : (b.text || `Opsi ${i+1}`) },
            type: 1
        }));
        try {
            return await sock.sendMessage(jid, {
                text: payload.message || 'Silakan pilih:',
                footer: payload.footer || 'NyautWa Gateway',
                buttons,
                headerType: 1
            });
        } catch {
            const listText = (payload.message || '') + "\n\n" + buttons.map((b, i) => `[${i+1}] ${b.buttonText.displayText}`).join("\n");
            return await sock.sendMessage(jid, { text: listText });
        }
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
