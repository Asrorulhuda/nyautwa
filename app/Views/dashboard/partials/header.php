<!-- PAGE HEADER & ACTION CONTROLS -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <h1 class="text-2xl font-bold text-on-surface tracking-tight">Dashboard</h1>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-surface-container-high text-primary font-mono text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                Live Production
            </span>
        </div>
        <p class="text-xs text-secondary">Pantau koneksi dan aktivitas pesan WhatsApp Anda secara realtime.</p>
    </div>
    <!-- Controls -->
    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
        <div class="hidden sm:inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-surface-container-lowest shadow-xs text-on-surface border border-outline-variant/30 text-xs">
            <span class="material-symbols-outlined text-[16px] text-secondary">calendar_today</span>
            <span class="font-medium">7 Hari: <?= date('d M', strtotime('-7 days')) ?> - <?= date('d M Y') ?></span>
        </div>
        <button onclick="window.location.reload()" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-lowest shadow-xs hover:bg-surface-container-low text-on-surface border border-outline-variant/30 text-xs transition-all active:scale-95" type="button">
            <span class="material-symbols-outlined text-[16px] text-secondary">refresh</span>
            <span class="font-medium">Muat Ulang</span>
            <span class="font-mono text-secondary text-[10px] hidden sm:inline ml-0.5"><?= date('H:i') ?></span>
        </button>
        <a class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container shadow-xs transition-colors ml-auto sm:ml-0" href="<?= url('/messages/send') ?>">
            <span class="material-symbols-outlined text-[16px]">add_circle</span>
            <span>Kirim Pesan</span>
        </a>
    </div>
</div>
