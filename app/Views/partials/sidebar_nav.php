<!-- Workspace Section -->
<div class="space-y-1">
    <div class="px-2.5 py-1 flex items-center justify-between text-[10.5px] uppercase tracking-wider text-outline-variant/60 font-semibold">
        <span class="flex items-center gap-1.5">
            <span class="w-1 h-1 rounded-full bg-emerald-400/70"></span>
            <span>Workspace</span>
        </span>
    </div>
    <nav class="space-y-1">
        <a href="<?= url('/dashboard') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/dashboard') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.08)]' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/dashboard') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span>
                </div>
                <span class="text-sm">Dashboard</span>
            </div>
            <?php if (is_active('/dashboard')): ?>
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.9)]"></span>
            <?php endif; ?>
        </a>
        <a href="<?= url('/devices') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/devices') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.08)]' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/devices') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">cell_tower</span>
                </div>
                <span class="text-sm">Koneksi WhatsApp</span>
            </div>
            <span class="text-[10.5px] px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 font-medium border border-emerald-500/25 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                Online
            </span>
        </a>
        <a href="<?= url('/messages/send') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/messages/send') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/messages/send') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                </div>
                <span class="text-sm">Kirim Pesan</span>
            </div>
        </a>
        <a href="<?= url('/messages') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/messages') && !is_active('/messages/send') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/messages') && !is_active('/messages/send') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">history_edu</span>
                </div>
                <span class="text-sm">Riwayat Pesan</span>
            </div>
        </a>
    </nav>
</div>
<!-- Developer Section -->
<div class="space-y-1 pt-2">
    <div class="px-2.5 py-1 flex items-center justify-between text-[10.5px] uppercase tracking-wider text-outline-variant/60 font-semibold">
        <span class="flex items-center gap-1.5">
            <span class="w-1 h-1 rounded-full bg-emerald-400/70"></span>
            <span>Developer</span>
        </span>
    </div>
    <nav class="space-y-1">
        <a href="<?= url('/api-keys') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/api-keys') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/api-keys') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">key</span>
                </div>
                <span class="text-sm">API Keys & Webhook</span>
            </div>
        </a>
        <a href="<?= url('/') ?>" target="_blank" class="group flex items-center justify-between px-3 py-2 rounded-xl text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white transition-all">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300 flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">terminal</span>
                </div>
                <span class="text-sm">Landing & Docs</span>
            </div>
            <span class="material-symbols-outlined text-xs text-outline-variant">open_in_new</span>
        </a>
    </nav>
</div>
