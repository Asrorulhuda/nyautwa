<!-- Subscription & Invoices Client Section -->
<div class="space-y-1">
    <div class="px-2.5 py-1 flex items-center justify-between text-[10.5px] uppercase tracking-wider text-outline-variant/60 font-semibold">
        <span class="flex items-center gap-1.5"><span class="w-1 h-1 rounded-full bg-emerald-400/70"></span><span>Langganan & Tagihan</span></span>
    </div>
    <nav class="space-y-0.5">
        <a href="<?= url('/invoices') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/invoices') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/invoices') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">receipt_long</span>
                </div>
                <span class="text-[13px]">Riwayat Pembayaran</span>
            </div>
        </a>

        <a href="<?= url('/onboarding/plan') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/onboarding/plan') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/onboarding/plan') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">rocket_launch</span>
                </div>
                <span class="text-[13px]">Perpanjang Paket</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 font-mono font-medium">Upgrade</span>
        </a>
    </nav>
</div>
