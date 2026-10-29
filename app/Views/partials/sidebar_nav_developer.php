<!-- Developer Section -->
<div class="space-y-1 pt-2">
    <div class="px-2.5 py-1 flex items-center justify-between text-[10.5px] uppercase tracking-wider text-outline-variant/60 font-semibold">
        <span class="flex items-center gap-1.5"><span class="w-1 h-1 rounded-full bg-emerald-400/70"></span><span>Developer</span></span>
    </div>
    <nav class="space-y-0.5">
        <?php if ($canApi): ?>
        <a href="<?= url('/api-keys') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/api-keys') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/api-keys') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">key</span>
                </div>
                <span class="text-[13px]">API Keys & Webhook</span>
            </div>
        </a>
        <?php else: ?>
        <button type="button" onclick="openUpsellModal('REST API & Webhook', 'Integrasikan pengiriman notifikasi, OTP, dan terima webhook status pesan langsung ke server Anda.')" class="w-full text-left group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all text-inverse-on-surface/50 hover:bg-white/[0.04]">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md bg-white/5 border border-white/5 flex items-center justify-center text-outline-variant"><span class="material-symbols-outlined text-[17px]">key</span></div>
                <span class="text-[13px]">API Keys & Webhook</span>
            </div>
            <span class="material-symbols-outlined text-amber-400 text-[15px]" title="Terkunci — Perlu Upgrade">lock</span>
        </button>
        <?php endif; ?>

        <a href="<?= url('/docs') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/docs') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/docs') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">menu_book</span>
                </div>
                <span class="text-[13px]">Dokumentasi API</span>
            </div>
        </a>
    </nav>
</div>
