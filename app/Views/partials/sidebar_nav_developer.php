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
        <a href="<?= url('/docs') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/docs') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/docs') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">menu_book</span>
                </div>
                <span class="text-sm">Dokumentasi API</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-white/10 text-white font-mono">v1</span>
        </a>
    </nav>
</div>
