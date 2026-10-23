<!-- Hero & Terminal Simulation Settings -->
<div class="space-y-5">
    <div class="border-b border-surface-container-high pb-3">
        <h3 class="text-sm font-semibold text-on-surface">Hero Section Utama</h3>
        <p class="text-xs text-secondary">Teks headline pembuka, badge label, dan tombol ajakan bertindak (CTA).</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Badge Tagline</label>
            <input type="text" name="hero_badge" value="<?= e($settings['hero_badge'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-primary">
        </div>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Judul Headline (H1)</label>
            <input type="text" name="hero_title" value="<?= e($settings['hero_title'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-primary">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-on-surface mb-1">Subjudul Deskripsi</label>
        <textarea name="hero_subtitle" rows="2" class="w-full p-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-primary"><?= e($settings['hero_subtitle'] ?? '') ?></textarea>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Teks Tombol Utama</label>
            <input type="text" name="hero_cta_primary" value="<?= e($settings['hero_cta_primary'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-primary">
        </div>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Teks Tombol Sekunder</label>
            <input type="text" name="hero_cta_secondary" value="<?= e($settings['hero_cta_secondary'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface focus:ring-1 focus:ring-primary focus:border-primary">
        </div>
    </div>
    <div class="border-t border-surface-container-high pt-4 mt-6">
        <h4 class="text-xs font-semibold text-on-surface uppercase tracking-wider mb-3">Simulasi Node Sesi (Hero Box Kanan)</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Nama Node Server</label>
                <input type="text" name="node_name" value="<?= e($settings['node_name'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Nomor Perangkat Demo</label>
                <input type="text" name="node_phone" value="<?= e($settings['node_phone'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Statistik Latensi Demo</label>
                <input type="text" name="node_uptime" value="<?= e($settings['node_uptime'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface">
            </div>
        </div>
    </div>
</div>
