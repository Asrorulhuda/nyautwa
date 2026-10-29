import { proto, generateWAMessageFromContent } from '@whiskeysockets/baileys';
import { savePollMessage } from './pollHandler.js';

export function buildNativeButtons(raw) {
    const list = Array.isArray(raw) ? raw : ['Pilihan 1', 'Pilihan 2'];
    return list.map((b, idx) => {
        const text = typeof b === 'string' ? b : (b.text || `Opsi ${idx + 1}`);
        const url = (typeof b === 'object' && b.url) ? b.url : null;
        const copy = (typeof b === 'object' && b.copy) ? b.copy : null;

        if (url) {
            return {
                name: 'cta_url',
                buttonParamsJson: JSON.stringify({ display_text: text, url, merchant_url: url })
            };
        }
        if (copy) {
            return {
                name: 'cta_copy',
                buttonParamsJson: JSON.stringify({ display_text: text, id: `copy_${idx}`, copy_code: copy })
            };
        }
        return {
            name: 'quick_reply',
            buttonParamsJson: JSON.stringify({ display_text: text, id: text })
        };
    });
}

export async function sendNativeFlowButton(sock, jid, payload) {
    const raw = payload.buttons || payload.options || ['Ya', 'Tidak'];
    const buttons = buildNativeButtons(raw);

    const interactiveMessage = {
        body: proto.Message.InteractiveMessage.Body.fromObject({
            text: payload.message || 'Silakan pilih salah satu opsi:'
        }),
        footer: proto.Message.InteractiveMessage.Footer.fromObject({
            text: payload.footer || 'NyautWa Gateway'
        }),
        header: proto.Message.InteractiveMessage.Header.fromObject({
            title: payload.title || '',
            hasMediaAttachment: false
        }),
        nativeFlowMessage: proto.Message.InteractiveMessage.NativeFlowMessage.fromObject({ buttons })
    };

    const msg = generateWAMessageFromContent(jid, {
        interactiveMessage: proto.Message.InteractiveMessage.fromObject(interactiveMessage)
    }, { userJid: sock.user?.id });

    await sock.relayMessage(jid, msg.message, { messageId: msg.key.id });
    savePollMessage(msg);
    return msg;
}
