<!-- Security Insights & Webhook Configuration (Right Column) -->
<div class="flex flex-col gap-5">
    <!-- Telemetry Card -->
    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-xs flex flex-col gap-4 border border-surface-container-high/60">
        <div class="flex items-center justify-between">
            <span class="text-sm font-semibold text-on-surface">Tingkat Aktivitas API</span>
            <span class="font-mono text-[10px] px-2 py-0.5 rounded bg-surface-container-low text-primary font-medium">Live 24 Jam</span>
        </div>
        <div class="flex flex-col gap-1">
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-bold text-on-surface font-mono">148.290</span>
                <span class="text-xs text-primary font-semibold flex items-center">
                    <span class="material-symbols-outlined text-[14px]">arrow_upward</span> +14.2%
                </span>
            </div>
            <span class="text-xs text-secondary">Total panggilan terautentikasi hari ini</span>
        </div>
        <div class="w-full h-12 pt-1">
            <svg class="w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 300 60">
                <path d="M0,45 Q30,10 60,35 T120,20 T180,40 T240,15 T300,28" fill="none" stroke="#008655" stroke-linecap="round" stroke-width="2.5"></path>
            </svg>
        </div>
        <div class="pt-3 grid grid-cols-2 gap-2 border-t border-surface-container text-xs">
            <div><span class="text-secondary block font-mono text-[11px]">Kegagalan Auth</span><span class="font-bold text-on-surface font-mono">0.002%</span></div>
            <div><span class="text-secondary block font-mono text-[11px]">Rata-rata Latensi</span><span class="font-bold text-primary font-mono">18ms</span></div>
        </div>
    </div>

    <!-- Webhook URL & Secret Form -->
    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-xs flex flex-col gap-3 border border-surface-container-high/60">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[18px]">webhook</span>
            </div>
            <h4 class="text-sm font-semibold text-on-surface">Konfigurasi Webhook</h4>
        </div>
        <form action="<?= url('/api-keys/webhook') ?>" method="POST" class="space-y-3">
            <?= csrf_field() ?>
            <div>
                <label for="webhook_url" class="block text-xs font-medium text-secondary mb-1">Callback URL (HTTPS)</label>
                <input type="url" id="webhook_url" name="webhook_url" placeholder="https://api.bisnis.com/wa-callback" value="<?= e($currentWebhookUrl ?? '') ?>" class="w-full px-3 py-1.5 bg-surface-container-low border border-surface-container rounded-md text-xs text-on-surface font-mono outline-hidden focus:border-primary">
            </div>
            <div>
                <label for="webhook_secret" class="block text-xs font-medium text-secondary mb-1">HMAC Secret (Verifikasi Signature)</label>
                <input type="text" id="webhook_secret" name="webhook_secret" value="<?= e($currentWebhookSecret ?? '') ?>" class="w-full px-3 py-1.5 bg-surface-container-low border border-surface-container rounded-md text-xs text-on-surface font-mono outline-hidden focus:border-primary">
            </div>
            <button type="submit" class="w-full py-2 bg-surface-container hover:bg-surface-container-high text-xs font-semibold text-on-surface rounded-md transition-colors">
                Simpan Konfigurasi Webhook
            </button>
        </form>
    </div>
</div>
