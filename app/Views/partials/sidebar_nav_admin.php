<!-- Admin SaaS Management Section -->
<div class="space-y-1 pt-2">
    <div class="px-2.5 py-1 flex items-center justify-between text-[10.5px] uppercase tracking-wider text-outline-variant/60 font-semibold">
        <span class="flex items-center gap-1.5">
            <span class="w-1 h-1 rounded-full bg-emerald-400/70"></span>
            <span>Admin SaaS</span>
        </span>
    </div>
    <nav class="space-y-1">
        <a href="<?= url('/clients') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/clients') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.08)]' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/clients') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">group</span>
                </div>
                <span class="text-sm">Kelola Klien</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-white/10 text-white font-mono">Tenant</span>
        </a>
        <a href="<?= url('/settings/landing') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/settings/landing') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.08)]' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/settings/landing') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">web</span>
                </div>
                <span class="text-sm">Config Landing</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 font-mono">CMS</span>
        </a>
    </nav>
</div>
