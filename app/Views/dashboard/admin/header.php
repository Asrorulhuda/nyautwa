<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <h1 class="text-2xl font-bold text-on-surface tracking-tight">Dashboard Platform SaaS</h1>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-primary font-mono text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                Admin Supercontrol
            </span>
        </div>
        <p class="text-xs text-secondary">Pantau seluruh klien tenant, volume pesan gateway, dan infrastruktur Baileys global.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
        <a href="<?= url('/clients') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-lowest hover:bg-surface-container-low text-on-surface border border-outline-variant/30 text-xs font-medium transition-all shadow-xs">
            <span class="material-symbols-outlined text-[16px] text-primary">group</span>
            <span>Kelola Klien</span>
        </a>
        <a href="<?= url('/settings/landing') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-lowest hover:bg-surface-container-low text-on-surface border border-outline-variant/30 text-xs font-medium transition-all shadow-xs">
            <span class="material-symbols-outlined text-[16px] text-secondary">tune</span>
            <span>Config Landing</span>
        </a>
        <button onclick="window.location.reload()" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container shadow-xs transition-colors" type="button">
            <span class="material-symbols-outlined text-[16px]">refresh</span>
            <span>Segarkan</span>
        </button>
    </div>
</div>
