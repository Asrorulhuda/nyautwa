<!-- Marketing & Automation Section -->
<div class="space-y-1">
    <div class="px-2.5 py-1 flex items-center justify-between text-[10.5px] uppercase tracking-wider text-outline-variant/60 font-semibold">
        <span class="flex items-center gap-1.5">
            <span class="w-1 h-1 rounded-full bg-emerald-400/70"></span>
            <span>Broadcast & Otomasi</span>
        </span>
    </div>
    <nav class="space-y-1">
        <a href="<?= url('/autoreplies') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/autoreplies') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/autoreplies') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">smart_toy</span>
                </div>
                <span class="text-sm">Balas Otomatis</span>
            </div>
        </a>
        <a href="<?= url('/contacts') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/contacts') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/contacts') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">contact_phone</span>
                </div>
                <span class="text-sm">Buku Kontak (Tag)</span>
            </div>
        </a>
        <a href="<?= url('/campaigns') ?>" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all <?= is_active('/campaigns') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-600/15 to-transparent text-emerald-300 font-semibold border border-emerald-500/30' : 'text-inverse-on-surface/75 hover:bg-white/[0.06] hover:text-white' ?>">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg <?= is_active('/campaigns') ? 'bg-emerald-500/25 border border-emerald-500/40 text-emerald-300' : 'bg-white/5 border border-white/5 group-hover:bg-emerald-500/15 group-hover:text-emerald-300' ?> flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-[18px]">campaign</span>
                </div>
                <span class="text-sm">Broadcast Blast</span>
            </div>
        </a>
    </nav>
</div>
