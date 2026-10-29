<!-- Workspace Section -->
<div class="space-y-1">
    <div class="px-2.5 py-1 flex items-center justify-between text-[10.5px] uppercase tracking-wider text-outline-variant/60 font-semibold">
        <span class="flex items-center gap-1.5"><span class="w-1 h-1 rounded-full bg-emerald-400/70"></span><span>Workspace</span></span>
    </div>
    <nav class="space-y-0.5">
        <a href="<?= url('/dashboard') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/dashboard') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/dashboard') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">dashboard</span>
                </div>
                <span class="text-[13px]">Dashboard</span>
            </div>
        </a>

        <a href="<?= url('/devices') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/devices') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/devices') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">cell_tower</span>
                </div>
                <span class="text-[13px]">Koneksi WhatsApp</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 font-medium border border-emerald-500/25 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Online</span>
        </a>

        <?php if ($canCrm): ?>
        <a href="<?= url('/chat') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/chat') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/chat') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">forum</span>
                </div>
                <span class="text-[13px]">Live Chat (CRM)</span>
            </div>
            <span class="text-[9.5px] px-1.5 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 font-medium border border-emerald-500/30">CRM</span>
        </a>
        <?php else: ?>
        <button type="button" onclick="openUpsellModal('Live Chat CRM', 'Kelola percakapan dua arah dengan pelanggan, sinkronisasi kontak, dan tanggapi pesan masuk seketika.')" class="w-full text-left group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all text-inverse-on-surface/50 hover:bg-white/[0.04]">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md bg-white/5 border border-white/5 flex items-center justify-center text-outline-variant"><span class="material-symbols-outlined text-[17px]">forum</span></div>
                <span class="text-[13px]">Live Chat (CRM)</span>
            </div>
            <span class="material-symbols-outlined text-amber-400 text-[15px]" title="Terkunci — Perlu Upgrade">lock</span>
        </button>
        <?php endif; ?>

        <?php if ($canSend): ?>
        <a href="<?= url('/messages/send') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/messages/send') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/messages/send') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">send</span>
                </div>
                <span class="text-[13px]">Kirim Pesan</span>
            </div>
        </a>
        <?php else: ?>
        <button type="button" onclick="openUpsellModal('Kirim Pesan', 'Kirim pesan teks, gambar, dan dokumen secara manual ke nomor tujuan pelanggan.')" class="w-full text-left group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all text-inverse-on-surface/50 hover:bg-white/[0.04]">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md bg-white/5 border border-white/5 flex items-center justify-center text-outline-variant"><span class="material-symbols-outlined text-[17px]">send</span></div>
                <span class="text-[13px]">Kirim Pesan</span>
            </div>
            <span class="material-symbols-outlined text-amber-400 text-[15px]" title="Terkunci — Perlu Upgrade">lock</span>
        </button>
        <?php endif; ?>

        <a href="<?= url('/messages') ?>" class="group flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all <?= is_active('/messages') && !is_active('/messages/send') ? 'bg-emerald-500/15 text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.05] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-md <?= is_active('/messages') && !is_active('/messages/send') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15' ?> flex items-center justify-center">
                    <span class="material-symbols-outlined text-[17px]">history_edu</span>
                </div>
                <span class="text-[13px]">Log Pesan</span>
            </div>
        </a>
    </nav>
</div>
