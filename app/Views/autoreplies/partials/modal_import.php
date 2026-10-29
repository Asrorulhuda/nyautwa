<div id="modal-import-reply" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#17211F]/40 backdrop-blur-sm p-4">
    <div class="bg-white border border-[#E4EAE6] rounded-xl shadow-xl w-full max-w-xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="px-6 py-4 border-b border-[#E4EAE6] flex items-center justify-between bg-[#F6F8F7]">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#16A36A] text-[22px]">upload_file</span>
                <h3 class="text-base font-semibold text-[#17211F]">Import Balas Otomatis dari Excel / CSV</h3>
            </div>
            <button type="button" onclick="closeModal('modal-import-reply')" class="text-[#697570] hover:text-[#17211F] p-1 rounded-md transition-colors cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="<?= url('/autoreplies/import') ?>" enctype="multipart/form-data" class="p-6 space-y-5">
            <?= csrf_field() ?>

            <!-- Template Download Banner -->
            <div class="p-4 bg-[#F6F8F7] border border-[#E4EAE6] rounded-lg space-y-2.5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold text-[#17211F]">Format File Spreadsheet</p>
                        <p class="text-[11px] text-[#697570] mt-0.5 leading-relaxed">Gunakan template resmi agar kolom dan opsi menu tersusun rapi tanpa kendala.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-1">
                    <a href="<?= url('/autoreplies/template?format=xlsx') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-[#16865A] bg-[#EAF7F0] border border-[#16A36A]/20 hover:bg-[#D4EFE0] rounded-md transition-colors shadow-xs">
                        <span class="material-symbols-outlined text-[16px]">table_view</span>
                        <span>Unduh Template Excel (.xlsx)</span>
                    </a>
                    <a href="<?= url('/autoreplies/template?format=csv') ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-[#17211F] bg-white border border-[#E4EAE6] hover:bg-[#F6F8F7] rounded-md transition-colors shadow-xs">
                        <span class="material-symbols-outlined text-[16px]">file_save</span>
                        <span>Format CSV (.csv)</span>
                    </a>
                </div>
            </div>

            <!-- Target Device Selection -->
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1.5">Terapkan pada Perangkat</label>
                <select name="device_id" class="w-full text-xs px-3 py-2 bg-white border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] outline-none">
                    <option value="">Semua Perangkat (Global)</option>
                    <?php if (!empty($devices)): ?>
                        <?php foreach ($devices as $d): ?>
                            <option value="<?= htmlspecialchars($d['id']) ?>"><?= htmlspecialchars($d['label'] ?? $d['phone'] ?? $d['id']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <p class="text-[11px] text-[#697570] mt-1">Pilih perangkat khusus atau biarkan global agar berlaku di seluruh nomor WhatsApp Anda.</p>
            </div>

            <!-- File Upload Input -->
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1.5">Pilih Berkas Excel / CSV</label>
                <input type="file" name="file" accept=".xlsx, .csv, .xls" required class="block w-full text-xs text-[#17211F] file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#16A36A] file:text-white hover:file:bg-[#128557] file:cursor-pointer border border-[#E4EAE6] rounded-md bg-[#F6F8F7]/50 p-1">
                <p class="text-[11px] text-[#697570] mt-1.5">Mendukung format Microsoft Excel (<strong>.xlsx</strong>) dan Comma-Separated Values (<strong>.csv</strong>).</p>
            </div>

            <div class="pt-3 border-t border-[#E4EAE6] flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeModal('modal-import-reply')" class="px-4 py-2 text-xs font-semibold text-[#17211F] bg-white border border-[#E4EAE6] hover:bg-[#F6F8F7] rounded-md transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors shadow-sm cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">cloud_upload</span>
                    <span>Mulai Impor Data</span>
                </button>
            </div>
        </form>
    </div>
</div>
