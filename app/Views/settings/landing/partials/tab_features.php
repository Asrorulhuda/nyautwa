<!-- Features / Benefits Settings -->
<div class="space-y-6">
    <div class="border-b border-surface-container-high pb-3">
        <h3 class="text-sm font-semibold text-on-surface">4 Fitur & Keunggulan Platform</h3>
        <p class="text-xs text-secondary">Atur judul dan deskripsi 4 kartu fitur utama yang ditampilkan pada landing page.</p>
    </div>
    <!-- Feature 1 & 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-4 rounded-lg bg-surface-container-low/50 border border-surface-container space-y-3">
            <span class="text-xs font-bold text-primary">Fitur 1 (API Rest & SDK)</span>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Judul Fitur</label>
                <input type="text" name="feature_1_title" value="<?= e($settings['feature_1_title'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Deskripsi Singkat</label>
                <textarea name="feature_1_desc" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs"><?= e($settings['feature_1_desc'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="p-4 rounded-lg bg-surface-container-low/50 border border-surface-container space-y-3">
            <span class="text-xs font-bold text-primary">Fitur 2 (Webhook Delivery)</span>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Judul Fitur</label>
                <input type="text" name="feature_2_title" value="<?= e($settings['feature_2_title'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Deskripsi Singkat</label>
                <textarea name="feature_2_desc" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs"><?= e($settings['feature_2_desc'] ?? '') ?></textarea>
            </div>
        </div>
    </div>
    <!-- Feature 3 & 4 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-4 rounded-lg bg-surface-container-low/50 border border-surface-container space-y-3">
            <span class="text-xs font-bold text-primary">Fitur 3 (Multi-Device Session)</span>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Judul Fitur</label>
                <input type="text" name="feature_3_title" value="<?= e($settings['feature_3_title'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Deskripsi Singkat</label>
                <textarea name="feature_3_desc" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs"><?= e($settings['feature_3_desc'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="p-4 rounded-lg bg-surface-container-low/50 border border-surface-container space-y-3">
            <span class="text-xs font-bold text-primary">Fitur 4 (Anti-Blokir & Proteksi)</span>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Judul Fitur</label>
                <input type="text" name="feature_4_title" value="<?= e($settings['feature_4_title'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Deskripsi Singkat</label>
                <textarea name="feature_4_desc" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs"><?= e($settings['feature_4_desc'] ?? '') ?></textarea>
            </div>
        </div>
    </div>
</div>
