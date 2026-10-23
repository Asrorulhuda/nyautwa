<!-- FAQ Settings -->
<div class="space-y-6">
    <div class="border-b border-surface-container-high pb-3">
        <h3 class="text-sm font-semibold text-on-surface">Tanya Jawab (FAQ)</h3>
        <p class="text-xs text-secondary">Atur pertanyaan dan jawaban populer yang sering ditanyakan oleh calon pengguna.</p>
    </div>
    <!-- FAQ 1 -->
    <div class="p-4 rounded-xl bg-surface-container-low/50 border border-surface-container space-y-3">
        <span class="text-xs font-bold text-primary">Pertanyaan #1</span>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Pertanyaan</label>
            <input type="text" name="faq_1_q" value="<?= e($settings['faq_1_q'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
        </div>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Jawaban</label>
            <textarea name="faq_1_a" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs"><?= e($settings['faq_1_a'] ?? '') ?></textarea>
        </div>
    </div>
    <!-- FAQ 2 -->
    <div class="p-4 rounded-xl bg-surface-container-low/50 border border-surface-container space-y-3">
        <span class="text-xs font-bold text-primary">Pertanyaan #2</span>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Pertanyaan</label>
            <input type="text" name="faq_2_q" value="<?= e($settings['faq_2_q'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
        </div>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Jawaban</label>
            <textarea name="faq_2_a" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs"><?= e($settings['faq_2_a'] ?? '') ?></textarea>
        </div>
    </div>
    <!-- FAQ 3 -->
    <div class="p-4 rounded-xl bg-surface-container-low/50 border border-surface-container space-y-3">
        <span class="text-xs font-bold text-primary">Pertanyaan #3</span>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Pertanyaan</label>
            <input type="text" name="faq_3_q" value="<?= e($settings['faq_3_q'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
        </div>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Jawaban</label>
            <textarea name="faq_3_a" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs"><?= e($settings['faq_3_a'] ?? '') ?></textarea>
        </div>
    </div>
</div>
