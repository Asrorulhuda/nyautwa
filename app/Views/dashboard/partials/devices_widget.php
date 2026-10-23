<!-- WhatsApp Connection Status Panel & Webhook Health -->
<div class="flex flex-col gap-6">
    <div class="p-6 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col border border-surface-container-high/60">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-sm font-semibold text-on-surface">Status Sesi WhatsApp</h2>
                <p class="text-xs text-secondary"><?= count($devices ?? []) ?> perangkat terdaftar</p>
            </div>
            <a class="text-xs text-primary hover:underline font-semibold" href="<?= url('/devices') ?>">Kelola</a>
        </div>
        <div class="space-y-3 mb-4">
            <?php if (empty($devices)): ?>
            <p class="text-xs text-secondary py-2">Belum ada perangkat terhubung.</p>
            <?php else: ?>
                <?php foreach ($devices as $dev): ?>
                <div class="p-3 rounded-lg bg-surface-container-low flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[18px]">phonelink_ring</span>
                            </div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full <?= $dev['status'] === 'connected' ? 'bg-primary' : 'bg-error' ?> ring-2 ring-surface-container-lowest"></span>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-semibold text-on-surface truncate"><?= e($dev['label']) ?></div>
                            <div class="font-mono text-[11px] text-secondary truncate"><?= e($dev['phone'] ?? '+62 8XX-XXXX-XXXX') ?></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold <?= $dev['status'] === 'connected' ? 'text-primary' : 'text-error' ?>">
                            <span class="material-symbols-outlined text-[13px]">wifi</span> <?= ucfirst($dev['status']) ?>
                        </span>
                        <div class="font-mono text-[10px] text-secondary">Sinyal 96%</div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <a href="<?= url('/devices/connect') ?>" class="w-full text-center py-2.5 rounded-lg border border-outline-variant/40 hover:bg-surface-container-low text-xs font-semibold text-on-surface transition-colors block">
            + Tambah Sesi Node Baru
        </a>
    </div>

    <!-- Webhook Health Card -->
    <div class="p-5 rounded-xl bg-surface-container-lowest shadow-xs border border-surface-container-high/60 space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-on-surface flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px] text-primary">webhook</span>
                Kesehatan Webhook
            </span>
            <span class="px-2 py-0.5 rounded-full bg-surface-container-low text-primary font-mono text-[10px] font-bold">99.8%</span>
        </div>
        <p class="text-xs text-secondary leading-relaxed">
            Callback event pesan masuk dan ACK status berhasil diterima oleh endpoint bisnis Anda tanpa antrean tertunda.
        </p>
        <div class="pt-2 border-t border-surface-container flex items-center justify-between text-xs">
            <span class="text-secondary">Rata-rata waktu respon:</span>
            <span class="font-mono font-semibold text-primary">84ms</span>
        </div>
    </div>
</div>
