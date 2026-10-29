import crypto from 'crypto';
import { sendCallbackToPhp } from './eventHandler.js';

export const pollStore = new Map();

export function savePollMessage(msg, options = []) {
    if (!msg?.key?.id) return;
    pollStore.set(msg.key.id, { msg, options, timestamp: Date.now() });
    if (pollStore.size > 300) {
        const oldest = pollStore.keys().next().value;
        pollStore.delete(oldest);
    }
}

export function getPollMessage(key) {
    if (!key?.id) return null;
    return pollStore.get(key.id)?.msg?.message || null;
}

export function handlePollVote(session, update) {
    const pollUpdates = update.update?.pollUpdates;
    if (!pollUpdates || !Array.isArray(pollUpdates)) return;

    const pollId = update.key?.id;
    const pollData = pollStore.get(pollId);
    if (!pollData || !Array.isArray(pollData.options)) return;

    for (const pu of pollUpdates) {
        const selected = pu.vote?.selectedOptions;
        if (!selected || !Array.isArray(selected) || selected.length === 0) continue;

        const rawVoter = (update.key.remoteJid.endsWith('@g.us') ? pu.pollUpdateMessageKey?.participant : update.key.remoteJid) || update.key.remoteJid;
        const sender = (rawVoter.endsWith('@g.us') || rawVoter.endsWith('@lid')) ? rawVoter : rawVoter.split('@')[0].split(':')[0];

        for (const selBuffer of selected) {
            const selHex = Buffer.isBuffer(selBuffer) ? selBuffer.toString('hex') : Buffer.from(selBuffer).toString('hex');
            for (const optName of pollData.options) {
                const optHex = crypto.createHash('sha256').update(Buffer.from(optName)).digest('hex');
                if (selHex === optHex) {
                    console.log(`[AutoReply Polling] User ${sender} memilih opsi: "${optName}"`);
                    sendCallbackToPhp('messages.incoming', {
                        session_ref: session.sessionRef,
                        sender,
                        text: optName,
                        message_id: 'poll_vote_' + Date.now(),
                        timestamp: Math.floor(Date.now() / 1000)
                    });
                    return;
                }
            }
        }
    }
}
