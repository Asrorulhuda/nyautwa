<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between h-full">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/20 mb-3">
            <h3 class="text-sm font-bold text-on-surface">Integrasi Cepat REST API</h3>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/15 text-primary font-mono font-semibold">POST /v1/messages</span>
        </div>

        <p class="text-xs text-secondary mb-3">Kirim pesan WhatsApp dari backend Anda menggunakan payload JSON sederhana.</p>

        <!-- Code Snippet Box -->
        <div class="p-3 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface space-y-1.5 overflow-x-auto border border-outline-variant/20">
            <div class="text-secondary select-none"># Contoh Request cURL:</div>
            <div class="text-primary font-semibold">curl -X POST <?= url('/api/v1/messages') ?> \</div>
            <div class="text-secondary">  -H "Authorization: Bearer <span class="text-amber-600">nyaut_live_...</span>" \</div>
            <div class="text-secondary">  -H "Content-Type: application/json" \</div>
            <div class="text-on-surface">  -d '{"to": "628123456789", "message": "Halo dari NyautWa!"}'</div>
        </div>

        <div class="mt-4 space-y-2">
            <div class="flex items-center justify-between text-xs p-2.5 rounded-lg bg-surface-container/60 border border-outline-variant/15">
                <span class="text-secondary">Kunci API Aktif:</span>
                <span class="font-mono text-on-surface font-semibold text-[11px]"><?= $api_key ? htmlspecialchars($api_key['prefix'] ?? 'nyaut_live', ENT_QUOTES, 'UTF-8') . '...' : 'Belum dibuat' ?></span>
            </div>
        </div>
    </div>

    <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-xs">
        <a href="<?= url('/api-keys') ?>" class="text-primary hover:underline font-medium">Buka Kunci API & Webhook &rarr;</a>
    </div>
</div>
