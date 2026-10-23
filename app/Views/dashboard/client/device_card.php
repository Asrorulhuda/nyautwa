<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between h-full">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/20 mb-4">
            <h3 class="text-sm font-bold text-on-surface">Perangkat WhatsApp</h3>
            <span class="text-[11px] font-mono text-secondary"><?= $connected_devices ?>/<?= max(1, $total_devices) ?> Online</span>
        </div>

        <?php if ($primary_device && ($primary_device['status'] ?? '') === 'connected'): ?>
            <div class="space-y-4">
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                    <div class="w-10 h-10 rounded-lg bg-primary text-white flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">phone_iphone</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-bold text-on-surface truncate"><?= htmlspecialchars($primary_device['label'] ?? 'WhatsApp Utama', ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="text-xs font-mono text-primary font-semibold"><?= htmlspecialchars($primary_device['phone'] ?? '+628xxxxxxxxxx', ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                    <span class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse"></span>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-outline-variant/15">
                        <span class="text-secondary">Batas Harian</span>
                        <span class="font-mono text-on-surface"><?= number_format($daily_limit, 0, ',', '.') ?> pesan</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-outline-variant/15">
                        <span class="text-secondary">Sesi Baileys</span>
                        <span class="font-mono text-primary">Live Active</span>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-4 space-y-3">
                <div class="w-12 h-12 rounded-full bg-surface-container mx-auto flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[24px]">qr_code_scanner</span>
                </div>
                <div>
                    <div class="text-xs font-bold text-on-surface">WhatsApp Belum Terhubung</div>
                    <p class="text-[11px] text-secondary mt-1">Scan QR code sekarang menggunakan aplikasi WhatsApp di smartphone Anda.</p>
                </div>
                <a href="<?= url('/devices') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container shadow-xs transition-colors">
                    <span class="material-symbols-outlined text-[16px]">qr_code</span>
                    <span>Hubungkan WhatsApp</span>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-xs">
        <a href="<?= url('/devices') ?>" class="text-primary hover:underline font-medium flex items-center gap-1">
            <span>Kelola Semua Device</span>
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </a>
    </div>
</div>
