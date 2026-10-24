<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-primary text-[20px]">lock</span>
        <h2 class="text-base font-bold text-on-surface">1. Autentikasi & Header Permintaan</h2>
    </div>
    <p class="text-xs text-secondary mb-4 leading-relaxed">
        Endpoint publik mendukung header standar <code class="font-mono bg-surface-container px-1.5 py-0.5 rounded text-primary">Authorization: Bearer &lt;API_KEY&gt;</code>, header <code class="font-mono bg-surface-container px-1.5 py-0.5 rounded text-primary">X-Api-Key</code>, atau parameter body <code class="font-mono bg-surface-container px-1.5 py-0.5 rounded text-primary">api_key</code> untuk kemudahan integrasi dengan aplikasi seperti Sipanda, MPWA, dan cURL form-data.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Auth Header Sample -->
        <div class="p-4 rounded-xl bg-surface-container font-mono text-xs border border-outline-variant/20 space-y-1.5">
            <div class="text-secondary select-none text-[11px] font-sans font-semibold">Format Autentikasi yang Didukung:</div>
            <div class="text-on-surface">1. Header: <span class="text-emerald-600 font-semibold">Authorization: Bearer <?= e($apiKeyPrefix) ?>_...</span></div>
            <div class="text-on-surface">2. Header: <span class="text-emerald-600 font-semibold">X-Api-Key: <?= e($apiKeyPrefix) ?>_...</span></div>
            <div class="text-on-surface">3. Body POST: <span class="text-emerald-600 font-semibold">"api_key": "<?= e($apiKeyPrefix) ?>_..."</span></div>
            <div class="text-secondary select-none text-[11px] pt-1 font-sans">Opsional (Deduplikasi): Idempotency-Key: trx-1042</div>
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
