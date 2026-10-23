<?php
$user = \App\Core\Session::get('user');
?>
<header class="fixed top-0 left-60 right-0 h-16 bg-surface/85 backdrop-blur-md z-40 border-b border-outline-variant/25 px-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-1.5 text-xs text-on-surface-variant font-medium">
            <span class="hover:text-on-surface transition-colors">Platform</span>
            <span class="text-outline-variant">/</span>
            <span class="text-on-surface font-semibold">Gateway Manager</span>
        </div>
        <div class="h-4 w-[1px] bg-outline-variant/30"></div>
        <div class="flex items-center gap-2">
            <span class="px-2 py-0.5 rounded font-mono text-[11px] font-medium bg-surface-container text-on-surface border border-outline-variant/40">Production</span>
            <div class="flex items-center gap-1 px-2 py-0.5 rounded text-[11px] bg-surface-container-low text-primary border border-primary/20">
                <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                <span>99.98% Uptime</span>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative flex items-center">
            <button class="flex items-center gap-2 h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-on-surface-variant text-xs shadow-xs" type="button">
                <span class="material-symbols-outlined text-[16px]">search</span>
                <span>Cari endpoint, ID log...</span>
                <kbd class="font-mono text-[10px] px-1.5 py-0.5 rounded bg-surface-container text-secondary font-medium">⌘K</kbd>
            </button>
        </div>
        <a class="h-9 px-2.5 flex items-center gap-1 text-xs text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-lg transition-colors" href="<?= url('/') ?>" target="_blank">
            <span class="material-symbols-outlined text-[18px]">menu_book</span>
            <span>Docs</span>
        </a>
        <button class="relative p-2 rounded-lg text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low transition-colors" type="button">
            <span class="material-symbols-outlined text-[20px]">notifications</span>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-error ring-2 ring-surface"></span>
        </button>
        <div class="h-6 w-[1px] bg-outline-variant/30"></div>
        <div class="flex items-center gap-2.5 pl-1">
            <div class="w-8 h-8 rounded-full bg-emerald-800/20 text-emerald-700 font-bold flex items-center justify-center text-xs border border-outline-variant/40 ring-1 ring-surface">
                <?= strtoupper(substr($user['name'] ?? 'B', 0, 1)) ?>
            </div>
            <div class="hidden xl:block text-left">
                <div class="text-xs font-semibold text-on-surface leading-tight"><?= e($user['name'] ?? 'Budi Pratama') ?></div>
                <div class="font-mono text-[10px] text-secondary leading-none">#ID-82910</div>
            </div>
        </div>
    </div>
</header>
