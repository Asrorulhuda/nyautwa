<!-- Webhook & SLA Telemetry Bento Card -->
<div class="p-6 rounded-xl bg-surface-container-lowest shadow-xs border border-surface-container-high/60 space-y-4 flex flex-col justify-between">
    <div>
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-semibold text-on-surface flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px]">webhook</span>
                </span>
                Kesehatan Webhook
            </span>
            <span class="px-2.5 py-0.5 rounded-full bg-surface-container-low text-primary font-mono text-[11px] font-bold border border-primary/20">
                99.8% Live
            </span>
        </div>
        <p class="text-xs text-secondary leading-relaxed">
            Callback event pesan masuk dan ACK status berhasil diterima oleh endpoint bisnis Anda tanpa antrean tertunda.
        </p>
    </div>
    <div class="space-y-2 pt-2 border-t border-surface-container">
        <div class="flex items-center justify-between text-xs">
            <span class="text-secondary">Rata-rata Respon:</span>
            <span class="font-mono font-semibold text-primary bg-surface-container px-2 py-0.5 rounded">84ms</span>
        </div>
        <div class="flex items-center justify-between text-xs">
            <span class="text-secondary">Retries Gagal:</span>
            <span class="font-mono font-semibold text-on-surface">0 / 2.4k</span>
        </div>
    </div>
    <a href="<?= url('/api-keys') ?>" class="w-full text-center py-2 rounded-lg bg-surface-container-low hover:bg-surface-container text-xs font-semibold text-primary transition-colors block border border-primary/10">
        Konfigurasi Webhook
    </a>
</div>
