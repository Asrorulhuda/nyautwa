<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <h1 class="text-2xl font-bold text-on-surface tracking-tight">Workspace WhatsApp</h1>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-primary font-mono text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                <?= htmlspecialchars($plan_name ?? 'Starter', ENT_QUOTES, 'UTF-8') ?>
            </span>
        </div>
        <p class="text-xs text-secondary">Pantau kuota pesan, koneksi nomor WhatsApp, dan integrasi API bisnis Anda.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
        <a href="<?= url('/devices') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-lowest hover:bg-surface-container-low text-on-surface border border-outline-variant/30 text-xs font-medium transition-all shadow-xs">
            <span class="material-symbols-outlined text-[16px] text-primary">qr_code_scanner</span>
            <span>Scan QR WhatsApp</span>
        </a>
        <a href="<?= url('/messages/send') ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container shadow-xs transition-colors">
            <span class="material-symbols-outlined text-[16px]">send</span>
            <span>Kirim Pesan Baru</span>
        </a>
    </div>
</div>
