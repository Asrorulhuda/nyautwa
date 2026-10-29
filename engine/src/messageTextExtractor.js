export function extractText(m) {
    if (!m) return '';
    if (m.ephemeralMessage?.message) return extractText(m.ephemeralMessage.message);
    if (m.viewOnceMessage?.message) return extractText(m.viewOnceMessage.message);
    if (m.documentWithCaptionMessage?.message) return extractText(m.documentWithCaptionMessage.message);

    if (m.interactiveResponseMessage) {
        const resp = m.interactiveResponseMessage;
        const nativeFlow = resp.nativeFlowResponseMessage;
        if (nativeFlow?.paramsJson) {
            try {
                const params = JSON.parse(nativeFlow.paramsJson);
                return params.id || params.selected_id || resp.body?.text || '';
            } catch {}
        }
        return resp.body?.text || '';
    }

    if (m.templateButtonReplyMessage) {
        return m.templateButtonReplyMessage.selectedDisplayText || m.templateButtonReplyMessage.selectedId || '';
    }

    if (m.buttonsResponseMessage) {
        return m.buttonsResponseMessage.selectedDisplayText || m.buttonsResponseMessage.selectedButtonId || '';
    }

    if (m.listResponseMessage) {
        return m.listResponseMessage.title || m.listResponseMessage.singleSelectReply?.selectedRowId || '';
    }

    return m.conversation || m.extendedTextMessage?.text || m.imageMessage?.caption || m.videoMessage?.caption || '';
}
