<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="material-symbols-outlined text-primary text-[28px]">api</span>
                <h1 class="text-2xl font-bold text-on-surface tracking-tight">Dokumentasi REST API Publik (v1)</h1>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-primary font-mono text-xs font-semibold">
                    v1.0 Live
                </span>
            </div>
            <p class="text-xs text-secondary max-w-2xl">
                Gunakan REST API NyautWa untuk mengintegrasikan pengiriman notifikasi order, OTP, pesan massal, dan webhook dua arah langsung dari aplikasi Anda.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
            <div class="px-3 py-2 rounded-xl bg-surface-container border border-outline-variant/20 font-mono text-xs text-secondary flex items-center gap-2">
                <span class="text-[10px] uppercase font-semibold text-primary">Base URL:</span>
                <span class="text-on-surface font-semibold select-all"><?= url('/api/v1') ?></span>
            </div>
            <a href="<?= url('/docs/download-pdf') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-surface-container border border-outline-variant/30 text-on-surface text-xs font-semibold hover:bg-surface-container-high shadow-xs transition-colors" title="Download Panduan Format PDF">
                <span class="material-symbols-outlined text-[16px] text-primary">picture_as_pdf</span>
                <span>Download PDF</span>
            </a>
            <a href="<?= url('/api-keys') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-container shadow-xs transition-colors">
                <span class="material-symbols-outlined text-[16px]">key</span>
                <span>Ambil API Key</span>
            </a>
        </div>
    </div>
</div>

