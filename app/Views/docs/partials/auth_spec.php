<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-primary text-[20px]">lock</span>
        <h2 class="text-base font-bold text-on-surface">1. Autentikasi & Header Permintaan</h2>
    </div>
    <p class="text-xs text-secondary mb-4 leading-relaxed">
        Seluruh endpoint publik mewajibkan header <code class="font-mono bg-surface-container px-1.5 py-0.5 rounded text-primary">Authorization: Bearer &lt;API_KEY&gt;</code>. Kunci API Anda disimpan dalam bentuk hash SHA-256 untuk memastikan keamanan maksimal.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Auth Header Sample -->
        <div class="p-4 rounded-xl bg-surface-container font-mono text-xs border border-outline-variant/20 space-y-1.5">
            <div class="text-secondary select-none text-[11px] font-sans font-semibold">Format Header HTTP:</div>
            <div class="text-on-surface">Authorization: Bearer <span class="text-emerald-600 font-semibold"><?= e($apiKeyPrefix) ?>_sample_token_hash</span></div>
            <div class="text-on-surface">Content-Type: application/json</div>
            <div class="text-secondary select-none text-[11px] pt-1 font-sans">Opsional (Deduplikasi):</div>
            <div class="text-on-surface">Idempotency-Key: order-trx-1042</div>
        </div>

        <!-- Rate Limit Headers -->
        <div class="p-4 rounded-xl bg-surface-container font-mono text-xs border border-outline-variant/20 space-y-1.5">
            <div class="text-secondary select-none text-[11px] font-sans font-semibold">Header Respons Rate Limiting:</div>
            <div class="text-on-surface"><span class="text-primary font-semibold">X-RateLimit-Limit:</span> 120</div>
            <div class="text-on-surface"><span class="text-primary font-semibold">X-RateLimit-Remaining:</span> 119</div>
            <div class="text-on-surface"><span class="text-primary font-semibold">X-RateLimit-Reset:</span> 1730000000</div>
            <div class="text-[11px] text-secondary font-sans pt-1">Batas request per menit mengikuti paket langganan aktif.</div>
        </div>
    </div>
</div>
