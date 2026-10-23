<div class="flex flex-col w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-2xl font-bold text-on-surface tracking-tight">Konfigurasi Landing Page</h1>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-surface-container-high text-primary font-mono text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    Live Editor
                </span>
            </div>
            <p class="text-xs text-secondary">Ubah konten publik website Anda langsung tanpa perlu mengubah kode sumber.</p>
        </div>
        <a href="<?= url('/') ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-xs font-semibold text-on-surface hover:bg-surface-container-low transition-colors shadow-xs">
            <span class="material-symbols-outlined text-[16px]">visibility</span>
            <span>Lihat Website Publik</span>
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-surface-container-high pb-px overflow-x-auto">
        <?php
        $tabs = [
            'hero' => ['label' => 'Hero & Preview', 'icon' => 'home'],
            'features' => ['label' => 'Fitur Utama', 'icon' => 'star'],
            'pricing' => ['label' => 'Harga & Paket', 'icon' => 'payments'],
            'faq' => ['label' => 'Tanya Jawab (FAQ)', 'icon' => 'quiz'],
            'footer' => ['label' => 'Footer & Kontak', 'icon' => 'contact_support'],
        ];
        $currentTab = $activeTab ?? 'hero';
        ?>
        <?php foreach ($tabs as $tKey => $tab): ?>
        <a href="<?= url('/settings/landing?tab=' . $tKey) ?>" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold rounded-t-lg transition-colors whitespace-nowrap <?= $currentTab === $tKey ? 'bg-surface-container-lowest text-primary border-t-2 border-primary shadow-xs' : 'text-secondary hover:text-on-surface hover:bg-surface-container-low/50' ?>">
            <span class="material-symbols-outlined text-[16px]"><?= $tab['icon'] ?></span>
            <span><?= $tab['label'] ?></span>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Settings Form Container -->
    <div class="p-6 rounded-xl bg-surface-container-lowest shadow-xs border border-surface-container-high/60">
        <form action="<?= url('/settings/landing') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="current_tab" value="<?= e($currentTab) ?>">

            <?php if ($currentTab === 'hero'): ?>
                <?php require __DIR__ . '/partials/tab_hero.php'; ?>
            <?php elseif ($currentTab === 'features'): ?>
                <?php require __DIR__ . '/partials/tab_features.php'; ?>
            <?php elseif ($currentTab === 'pricing'): ?>
                <?php require __DIR__ . '/partials/tab_pricing.php'; ?>
            <?php elseif ($currentTab === 'faq'): ?>
                <?php require __DIR__ . '/partials/tab_faq.php'; ?>
            <?php elseif ($currentTab === 'footer'): ?>
                <?php require __DIR__ . '/partials/tab_footer.php'; ?>
            <?php endif; ?>

            <div class="pt-5 border-t border-surface-container-high flex items-center justify-between">
                <span class="text-xs text-secondary">Perubahan akan langsung terlihat pada landing page utama.</span>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container shadow-sm transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
