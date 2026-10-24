<!-- Dynamic Type-Specific Inputs -->
<div id="field-image" class="type-panel hidden space-y-3 p-3 bg-surface-container-low rounded-lg border border-surface-container">
    <div>
        <label for="media_url" class="block text-xs font-semibold text-on-surface mb-1">URL Gambar Langsung (JPG/PNG)</label>
        <input type="url" id="media_url" name="media_url" placeholder="https://domain.com/gambar-promo.jpg" value="<?= e(old('media_url')) ?>" oninput="updatePreviewMedia(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden">
    </div>
</div>

<div id="field-document" class="type-panel hidden space-y-3 p-3 bg-surface-container-low rounded-lg border border-surface-container">
    <div>
        <label for="doc_url" class="block text-xs font-semibold text-on-surface mb-1">URL File / Dokumen (PDF/DOCX/XLS)</label>
        <input type="url" id="doc_url" name="doc_url" placeholder="https://domain.com/invoice-001.pdf" value="<?= e(old('doc_url')) ?>" oninput="updatePreviewDoc(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden">
    </div>
    <div>
        <label for="filename" class="block text-xs font-semibold text-on-surface mb-1">Nama File Tampilan</label>
        <input type="text" id="filename" name="filename" placeholder="Invoice_Order_99.pdf" value="<?= e(old('filename', 'Invoice_Pelanggan.pdf')) ?>" oninput="updatePreviewDocName(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden">
    </div>
</div>

<div id="field-poll" class="type-panel hidden space-y-3 p-3 bg-surface-container-low rounded-lg border border-surface-container">
    <div>
        <label for="poll_question" class="block text-xs font-semibold text-on-surface mb-1">Pertanyaan Polling</label>
        <input type="text" id="poll_question" name="poll_question" placeholder="Apakah Anda puas dengan layanan kami?" value="<?= e(old('poll_question')) ?>" oninput="updatePreviewPollQ(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden">
    </div>
    <div>
        <label for="poll_options" class="block text-xs font-semibold text-on-surface mb-1">Pilihan Opsi (Satu baris per opsi)</label>
        <textarea id="poll_options" name="poll_options" rows="3" placeholder="Sangat Puas&#10;Cukup Puas&#10;Perlu Ditingkatkan" oninput="updatePreviewPollOpts(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden"><?= e(old('poll_options', "Sangat Puas\nCukup Puas\nPerlu Ditingkatkan")) ?></textarea>
    </div>
</div>

<div id="field-button" class="type-panel hidden space-y-3 p-3 bg-surface-container-low rounded-lg border border-surface-container">
    <div>
        <label for="buttons_list" class="block text-xs font-semibold text-on-surface mb-1">Label Tombol Respons Cepat (Satu baris per tombol)</label>
        <textarea id="buttons_list" name="buttons_list" rows="2" placeholder="Konfirmasi Pesanan&#10;Batalkan" oninput="updatePreviewButtons(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden"><?= e(old('buttons_list', "Konfirmasi Pesanan\nHubungi CS")) ?></textarea>
    </div>
    <div>
        <label for="footer_text" class="block text-xs font-semibold text-on-surface mb-1">Teks Footer Bawah</label>
        <input type="text" id="footer_text" name="footer_text" placeholder="NyautWa Gateway Notifikasi" value="<?= e(old('footer_text', 'NyautWa Gateway Service')) ?>" oninput="updatePreviewFooter(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden">
    </div>
</div>
