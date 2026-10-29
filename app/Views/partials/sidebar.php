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
            <a href="<?= url('/dashboard') ?>" class="flex items-center gap-2.5 group">
                <img src="<?= url('/assets/images/logo.png') ?>" alt="NyautWa Logo" class="h-9 w-9 rounded-lg object-contain bg-white/5 p-0.5 border border-emerald-500/30 shadow-[0_0_12px_rgba(16,185,129,0.2)] group-hover:scale-105 transition-transform">
                <div class="flex flex-col">
                    <span class="text-[15px] tracking-tight text-white font-bold leading-none">Nyaut<span class="text-emerald-400">Wa</span></span>
                    <span class="text-[9px] text-emerald-400/80 font-mono font-medium tracking-wider mt-0.5">GATEWAY &bull; CRM</span>
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

        <!-- Navigation Sections (Scrollable without visible scrollbar) -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-3 py-2.5 space-y-2.5" style="scrollbar-width: none; -ms-overflow-style: none;">
            <?php require __DIR__ . '/sidebar_nav.php'; ?>

            <!-- Dynamic Quota Summary Card -->
            <?php require __DIR__ . '/sidebar_quota.php'; ?>
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
