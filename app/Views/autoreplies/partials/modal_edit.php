<div id="modal-edit-reply" class="fixed inset-0 bg-[#17211F]/40 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full border border-[#E4EAE6] overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-[#E4EAE6] flex items-center justify-between bg-[#F6F8F7]">
            <h3 class="text-base font-bold text-[#17211F]">Edit Aturan Balas Otomatis</h3>
            <button type="button" onclick="closeEditModal()" class="text-[#697570] hover:text-[#17211F] text-lg font-bold p-1 cursor-pointer">✕</button>
        </div>

        <form id="form-edit-reply" method="POST" action="" enctype="multipart/form-data" class="overflow-y-auto p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Perangkat</label>
                    <select name="device_id" id="edit_device_id" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md bg-white">
                        <option value="">Semua Perangkat (Global)</option>
                        <?php foreach ($devices as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['label'] ?? $d['phone'] ?? $d['id']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Kata Kunci (Keyword) <span class="text-[#D84B4B]">*</span></label>
                    <input type="text" name="keyword" id="edit_keyword" required class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Kecocokan</label>
                    <select name="match_type" id="edit_match_type" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md bg-white">
                        <option value="contain">Mengandung Kata</option>
                        <option value="exact">Persis Sama</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Tipe Balasan</label>
                    <select name="type" id="edit_type" onchange="handleEditTypeChange(this.value)" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md bg-white font-medium text-[#16A36A]">
                        <option value="text">Teks Biasa</option>
                        <option value="image">Gambar Promo</option>
                        <option value="document">Dokumen / PDF</option>
                        <option value="button">Menu Pilihan (Angka/Kode)</option>
                        <option value="poll">Polling / Voting</option>
                    </select>
                </div>
            </div>

            <div>
                <label id="edit-response-label" class="block text-xs font-semibold text-[#17211F] mb-1">Isi Pesan Balasan <span class="text-[#D84B4B]">*</span></label>
                <textarea name="response" id="edit_response" rows="3" required class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md"></textarea>
            </div>

            <!-- Dynamic Edit Fields -->
            <div id="edit-field-file" class="hidden">
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Ganti Berkas (Kosongkan jika tidak diubah)</label>
                <div id="edit-current-file" class="text-xs text-[#16A36A] mb-1 hidden"></div>
                <input type="file" name="media_file" id="edit_media_file" class="w-full text-xs text-[#17211F] file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#EAF7F0] file:text-[#16865A] border border-[#E4EAE6] rounded-md bg-white">
            </div>

            <div id="edit-field-poll" class="hidden">
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Pilihan Polling (Satu per baris)</label>
                <textarea name="poll_options_text" id="edit_poll_text" rows="3" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md"></textarea>
            </div>

            <div id="edit-field-button" class="hidden space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-semibold text-[#17211F]">Pilihan Menu & Sub-Menu (Kolom Terpisah)</label>
                    <button type="button" onclick="addMenuOptionRow('edit')" class="text-xs text-[#16A36A] font-semibold hover:underline cursor-pointer">+ Tambah Pilihan</button>
                </div>
                <div class="bg-[#F6F8F7] p-2.5 rounded-lg border border-[#E4EAE6]">
                    <div class="grid grid-cols-12 gap-2 text-[11px] font-semibold text-[#697570] mb-1.5 px-1">
                        <div class="col-span-3">Angka/Kode</div>
                        <div class="col-span-5">Label Tampilan</div>
                        <div class="col-span-3">Keyword</div>
                        <div class="col-span-1 text-center">✕</div>
                    </div>
                    <div id="edit-menu-options-container" class="space-y-1.5"></div>
                </div>
            </div>

            <div class="pt-4 border-t border-[#E4EAE6] flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-[#17211F] bg-white border border-[#E4EAE6] rounded-md hover:bg-[#F6F8F7] cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md shadow-sm cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
