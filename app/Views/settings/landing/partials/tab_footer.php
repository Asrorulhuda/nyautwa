<!-- Footer & Contact Settings -->
<div class="space-y-5">
    <div class="border-b border-surface-container-high pb-3">
        <h3 class="text-sm font-semibold text-on-surface">Footer & Identitas Bisnis</h3>
        <p class="text-xs text-secondary">Atur tagline perusahaan dan kontak resmi yang tampil di footer publik.</p>
    </div>
    <div>
        <label class="block text-xs font-medium text-on-surface mb-1">Tagline Ringkas Perusahaan</label>
        <textarea name="footer_tagline" rows="2" class="w-full p-2.5 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface focus:ring-1 focus:ring-primary"><?= e($settings['footer_tagline'] ?? '') ?></textarea>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Nomor WhatsApp Resmi</label>
            <input type="text" name="footer_contact_phone" value="<?= e($settings['footer_contact_phone'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface">
        </div>
        <div>
            <label class="block text-xs font-medium text-on-surface mb-1">Alamat Email Dukungan</label>
            <input type="email" name="footer_contact_email" value="<?= e($settings['footer_contact_email'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-on-surface mb-1">Alamat Kantor / Domisili</label>
        <input type="text" name="footer_address" value="<?= e($settings['footer_address'] ?? '') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs text-on-surface">
    </div>
</div>
