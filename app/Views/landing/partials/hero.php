<!-- Hero Section Left Column -->
<div class="lg:col-span-7 flex flex-col items-start">
    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 text-amber-800 border border-amber-500/30 mb-6 shadow-xs">
        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
        <span class="text-xs uppercase tracking-wider font-bold font-mono"><?= e($settings['hero_badge'] ?? 'WA GATEWAY + LIVE CRM PELANGGAN') ?></span>
    </div>
    <h1 class="font-sans text-4xl sm:text-5xl lg:text-[46px] font-black text-on-surface tracking-tight leading-[1.15] mb-5">
        <?php if (!empty($settings['hero_title'])): ?>
            <?= str_replace('Nyaut', '<span class="text-primary underline decoration-amber-400 decoration-wavy decoration-2">Nyaut</span>', htmlspecialchars($settings['hero_title'])) ?>
        <?php else: ?>
            Pesan Masuk Langsung <span class="text-primary underline decoration-amber-400 decoration-wavy decoration-2">Nyaut</span>, Bisnis Makin Gesit.
        <?php endif; ?>
    </h1>
    <p class="text-base sm:text-lg text-on-surface-variant mb-7 max-w-xl leading-relaxed">
        <?= e($settings['hero_subtitle'] ?? 'Kombinasi resmi WhatsApp Gateway API berkecepatan tinggi dengan Live Chat CRM dua arah. Kirim notifikasi, auto-reply cerdas, dan layani pelanggan seketika dalam satu platform terpadu by asr_production.') ?>
    </p>
    <div class="flex flex-wrap items-center gap-3.5 w-full sm:w-auto mb-8">
        <a class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-white text-sm font-semibold rounded-lg shadow-md hover:bg-primary-container transition-all" href="<?= url('/register') ?>">
            <span><?= e($settings['hero_cta_primary'] ?? 'Mulai Sekarang — Gratis') ?></span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>
        <a class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-surface-container-lowest border border-outline-variant/40 text-on-surface text-sm font-semibold rounded-lg shadow-sm hover:bg-surface-container transition-colors" href="#api">
            <span class="material-symbols-outlined text-[18px] text-amber-600">terminal</span>
            <span><?= e($settings['hero_cta_secondary'] ?? 'Dokumentasi REST API') ?></span>
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs text-on-surface-variant pt-2 border-t border-surface-container-high/60 w-full">
        <div class="flex items-center gap-1.5 font-medium"><span class="material-symbols-outlined text-primary text-[17px]">verified</span> Multi-Device QR</div>
        <div class="flex items-center gap-1.5 font-medium"><span class="material-symbols-outlined text-amber-600 text-[17px]">forum</span> Live Chat CRM</div>
        <div class="flex items-center gap-1.5 font-medium"><span class="material-symbols-outlined text-primary text-[17px]">shield</span> Anti-Blokir Cerdas</div>
    </div>
</div>
