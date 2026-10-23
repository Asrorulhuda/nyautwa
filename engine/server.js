import express from 'express';
import { config } from './src/config.js';
import { sessionManager } from './src/sessionManager.js';

const app = express();
app.use(express.json());

// Middleware: Secret Token Authentication
app.use((req, res, next) => {
    if (req.path === '/health') return next();
    
    const secret = req.headers['x-engine-secret'];
    if (!secret || secret !== config.secret) {
        return res.status(403).json({ error: 'Akses internal ditolak: Secret token tidak valid' });
    }
    next();
});

// Health check endpoint
app.get('/health', (req, res) => {
    res.json({ status: 'ok', engine: 'NyautWa Baileys v1.0', time: new Date() });
});

// Start session & request QR
app.post('/session/start', async (req, res) => {
    const { session_ref } = req.body;
    if (!session_ref) {
        return res.status(400).json({ error: 'Field session_ref wajib disertakan' });
    }

    const session = await sessionManager.getOrCreateSession(session_ref);
    res.json({
        success: true,
        session_ref,
        status: session.status,
        qr: session.qr,
    });
});

// Send message via Baileys
app.post('/message/send', async (req, res) => {
    const { session_ref, phone, message } = req.body;
    if (!session_ref || !phone || !message) {
        return res.status(400).json({ error: 'Field session_ref, phone, dan message wajib disertakan' });
    }

    try {
        const result = await sessionManager.sendMessage(session_ref, phone, message);
        res.json({
            success: true,
            wa_message_id: result.wa_message_id,
            recipient: phone,
        });
    } catch (err) {
        res.status(500).json({ error: 'Gagal mengirim pesan via Baileys: ' + err.message });
    }
});

app.listen(config.port, () => {
    console.log(`[NyautWa Engine] Berjalan di port internal ${config.port}`);
});
