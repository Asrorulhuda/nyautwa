<?php
$user = \App\Core\Session::get('user');
$tenant = \App\Core\Session::get('tenant');
?>
<aside id="app-sidebar" class="fixed left-0 top-0 h-screen w-60 bg-[#0c1513] text-inverse-on-surface z-50 flex flex-col justify-between border-r border-white/10 select-none -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
    <div class="relative flex flex-col flex-1 min-h-0 overflow-hidden">
        <!-- Subtle ambient glow -->
        <div class="absolute -top-10 -left-10 w-44 h-44 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>
        <div class="absolute top-1/3 -right-12 w-36 h-36 rounded-full bg-emerald-600/5 blur-2xl pointer-events-none"></div>

        <!-- Header Logo & Version -->
        <div class="relative h-16 px-4 flex items-center justify-between border-b border-white/5 backdrop-blur-md bg-white/[0.02]">
            <a href="<?= url('/dashboard') ?>" class="flex items-center gap-2.5">
                <div class="relative p-1.5 rounded-xl bg-gradient-to-b from-emerald-500/25 to-emerald-700/15 border border-emerald-500/30 flex items-center justify-center shadow-[0_0_12px_rgba(16,185,129,0.2)]">
                    <span class="material-symbols-outlined text-emerald-400 text-xl">chat</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[16px] tracking-tight text-white font-bold leading-none">NyautWa</span>
                    <span class="text-[10px] text-emerald-400/80 font-mono font-medium tracking-wide mt-1">WA GATEWAY</span>
                </div>
            </a>
            <div class="flex items-center gap-1.5">
                <div class="flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/25 text-[11px] font-mono font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>v1.4</span>
                </div>
                <button id="mobile-sidebar-close" class="lg:hidden p-1 rounded-lg text-outline-variant hover:text-white" type="button" aria-label="Tutup Menu">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        </div>

        <!-- Navigation Sections (Scrollable) -->
        <div class="flex-1 overflow-y-auto px-3 py-3.5 space-y-3">
            <?php require __DIR__ . '/sidebar_nav.php'; ?>

            <!-- Mini Quota Summary Card -->
            <div class="p-3 rounded-xl bg-white/[0.03] border border-white/5 backdrop-blur-sm space-y-2 mt-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-white font-medium flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px] text-emerald-400">database</span>
                        Kuota Pesan
                    </span>
                    <span class="font-mono text-[10px] text-emerald-400 font-semibold">120 / 10.000</span>
                </div>
                <div class="w-full h-1.5 rounded-full bg-white/10 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full shadow-[0_0_8px_rgba(52,211,153,0.8)]" style="width: 12%;"></div>
                </div>
                <div class="flex items-center justify-between pt-0.5 text-[10.5px] text-outline-variant">
                    <span>1.2% terpakai</span>
                    <span class="text-emerald-300 font-medium">Pro Tier</span>
                </div>
            </div>
        </div>

        <!-- Bottom Gateway Status & User Profile -->
        <div class="p-3 border-t border-white/5 bg-[#080f0d] space-y-2">
            <div class="px-3 py-1.5 rounded-xl bg-white/[0.04] border border-white/5 flex items-center justify-between backdrop-blur-sm">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    <div class="flex flex-col">
                        <span class="font-mono text-[11px] text-white font-medium leading-none">Gateway Engine</span>
                        <span class="font-mono text-[9px] text-outline-variant mt-0.5">Jakarta-01 Active</span>
                    </div>
                </div>
                <span class="font-mono text-[10px] text-emerald-400 font-medium">98ms</span>
            </div>
            <div class="flex items-center gap-2 px-2 py-1.5 rounded-lg bg-white/[0.02] border border-white/5">
                <div class="w-7 h-7 rounded-full bg-emerald-800/40 text-emerald-300 border border-emerald-500/30 flex items-center justify-center font-bold text-xs">
                    <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs text-white font-semibold truncate leading-tight"><?= e($user['name'] ?? 'User') ?></div>
                    <div class="text-[10px] text-outline-variant truncate"><?= e($tenant['name'] ?? 'Tenant') ?></div>
                </div>
                <form action="<?= url('/logout') ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="text-outline-variant hover:text-red-400 transition-colors p-1" title="Keluar">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
