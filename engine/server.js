import express from 'express';
import { config } from './src/config.js';
import { sessionManager } from './src/sessionManager.js';

const app = express();
app.use(express.json());

app.use((req, res, next) => {
    if (req.path === '/health') return next();
    const secret = req.headers['x-engine-secret'];
    if (!secret || secret !== config.secret) {
        return res.status(403).json({ error: 'Akses internal ditolak: Secret token tidak valid' });
    }
    next();
});

app.get('/health', (req, res) => {
    res.json({ status: 'ok', engine: 'NyautWa Baileys Live Engine v1.0', time: new Date() });
});

app.post('/session/start', async (req, res) => {
    const { session_ref } = req.body;
    if (!session_ref) return res.status(400).json({ error: 'Field session_ref wajib disertakan' });
    try {
        const session = await sessionManager.getOrCreateSession(session_ref);
        res.json({ success: true, session_ref, status: session.status, phone: session.phone, qr: session.qr });
    } catch (err) {
        res.status(500).json({ error: 'Gagal inisialisasi sesi Baileys: ' + err.message });
    }
});

app.post('/session/pairing-code', async (req, res) => {
    const { session_ref, phone } = req.body;
    if (!session_ref || !phone) return res.status(400).json({ error: 'Field session_ref dan phone wajib disertakan' });
    try {
        const code = await sessionManager.requestPairingCode(session_ref, phone);
        res.json({ success: true, session_ref, pairing_code: code });
    } catch (err) {
        res.status(500).json({ error: 'Gagal generate pairing code: ' + err.message });
    }
});

app.post('/session/status', async (req, res) => {
    const { session_ref } = req.body;
    const session = await sessionManager.getOrCreateSession(session_ref);
    res.json({ success: true, session_ref, status: session.status, phone: session.phone, qr: session.qr });
});

app.post('/session/logout', async (req, res) => {
    const { session_ref } = req.body;
    const result = await sessionManager.logoutSession(session_ref);
    res.json(result);
});

app.post('/message/send', async (req, res) => {
    const { session_ref, phone, message, type, url, caption, options, question } = req.body;
    if (!session_ref || !phone) return res.status(400).json({ error: 'Field session_ref dan phone wajib disertakan' });
    try {
        const result = await sessionManager.sendMessage(session_ref, phone, {
            message, type, url, caption, options, question
        });
        res.json({ success: true, wa_message_id: result.wa_message_id, recipient: phone });
    } catch (err) {
        res.status(500).json({ error: 'Gagal mengirim pesan via Baileys: ' + err.message });
    }
});

app.listen(config.port, () => {
    console.log(`[NyautWa Engine] Berjalan di port internal ${config.port}`);
});
