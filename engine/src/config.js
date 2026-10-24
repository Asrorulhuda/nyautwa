import dotenv from 'dotenv';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: path.resolve(__dirname, '../../.env') });

export const config = {
    port: parseInt(process.env.PORT || process.env.ENGINE_PORT || '3000', 10),
    secret: process.env.ENGINE_SECRET || 'nyautwa_engine_internal_secret_994821',
    phpCallbackUrl: (process.env.APP_URL || 'http://localhost:8000') + '/api/v1/internal/callback',
    sessionsDir: path.resolve(__dirname, '../sessions'),
};
