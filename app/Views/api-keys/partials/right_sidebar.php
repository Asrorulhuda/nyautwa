<!-- Security Insights & Webhook Configuration (Right Column) -->
<div class="flex flex-col gap-5">
    <!-- Real API Activity Metrics Card -->
    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-xs flex flex-col gap-4 border border-surface-container-high/60">
        <div class="flex items-center justify-between">
            <span class="text-sm font-semibold text-on-surface">Aktivitas API Akun</span>
            <span class="font-mono text-[10px] px-2 py-0.5 rounded bg-surface-container-low text-primary font-semibold">Real-time</span>
        </div>
        <div class="flex flex-col gap-1">
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-bold text-on-surface font-mono"><?= number_format($apiCallsToday ?? 0) ?></span>
                <span class="text-xs text-secondary font-mono">pesan hari ini</span>
            </div>
            <span class="text-xs text-secondary">Total panggilan pesan keluar & masuk via gateway</span>
        </div>
        
        <div class="pt-3 grid grid-cols-2 gap-2 border-t border-surface-container text-xs">
            <div>
                <span class="text-secondary block text-[11px]">Total Kumulatif</span>
                <span class="font-bold text-on-surface font-mono"><?= number_format($apiCallsTotal ?? 0) ?> pesan</span>
            </div>
            <div>
                <span class="text-secondary block text-[11px]">Kunci Aktif</span>
                <span class="font-bold text-primary font-mono"><?= count($keys) ?> token</span>
            </div>
        </div>
    </div>

    <!-- Webhook URL Configuration Form -->
    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-xs flex flex-col gap-3 border border-surface-container-high/60">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[18px]">webhook</span>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-on-surface">Konfigurasi Webhook</h4>
                <span class="text-[11px] text-secondary">Terima notifikasi pesan masuk & laporan status</span>
            </div>
        </div>
        <form action="<?= url('/webhook/update') ?>" method="POST" class="space-y-3">
            <?= csrf_field() ?>
            <div>
                <label for="webhook_url" class="block text-xs font-semibold text-on-surface mb-1">Callback URL (Endpoint HTTPS)</label>
                <input type="url" id="webhook_url" name="webhook_url" placeholder="https://domain-anda.com/api/wa-callback" value="<?= e($webhookUrl ?? '') ?>" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface font-mono outline-hidden focus:border-primary">
            </div>
            <?php if (!empty($webhookSecret)): ?>
            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1">Webhook Secret (Header Verification)</label>
                <input type="text" readonly value="<?= e($webhookSecret) ?>" class="w-full px-3 py-2 bg-surface-container-low border border-surface-container rounded-md text-xs text-secondary font-mono select-all">
            </div>
            <?php endif; ?>
            <button type="submit" class="w-full py-2 bg-primary hover:bg-primary-container text-xs font-semibold text-white rounded-md transition-colors shadow-xs">
                Simpan URL Webhook
            </button>
        </form>
    </div>
</div>
