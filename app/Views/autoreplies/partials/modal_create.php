<div id="modal-create-reply" class="fixed inset-0 z-50 hidden bg-[#17211F]/50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl border border-[#E4EAE6] w-full max-w-lg p-6 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-lg font-semibold text-[#17211F]">Tambah Aturan Balas Otomatis</h3>
            <button type="button" onclick="if(typeof closeModal==='function'){closeModal('modal-create-reply')}else{const m=document.getElementById('modal-create-reply');m.classList.add('hidden');m.classList.remove('flex');}" class="text-[#697570] hover:text-[#17211F] cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="<?= url('/autoreplies') ?>" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Perangkat WhatsApp (Device)</label>
                <select name="device_id" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white">
                    <option value="">Semua Perangkat (Global)</option>
                    <?php if (!empty($devices)): ?>
                        <?php foreach ($devices as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['label']) ?> (<?= htmlspecialchars($d['status']) ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Kata Kunci (Keyword) <span class="text-[#D84B4B]">*</span></label>
                    <input type="text" name="keyword" required placeholder="Contoh: info, promo, menu" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Pencocokan</label>
                    <select name="match_type" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white">
                        <option value="contain">Mengandung Kata</option>
                        <option value="exact">Persis Sama</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Tipe Pesan Balasan <span class="text-[#D84B4B]">*</span></label>
                <select name="type" id="reply-type-select" onchange="handleReplyTypeChange(this)" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white font-medium text-[#17211F]">
                    <option value="text">💬 Teks Biasa</option>
                    <option value="image">🖼️ Gambar (Image Upload)</option>
                    <option value="document">📄 Dokumen / Berkas File</option>
                    <option value="poll">📊 Polling / Voting</option>
                    <option value="button">🔘 Tombol Pilihan (Interactive Buttons)</option>
                </select>
            </div>

            <!-- Dynamic File Upload & Options Partial -->
            <?php require __DIR__ . '/modal_type_fields.php'; ?>

            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">
                    <span id="response-label-text">Isi Balasan Otomatis</span>
                    <span class="text-[#D84B4B]">*</span>
                </label>
                <textarea name="response" rows="3" required placeholder="Tuliskan isi pesan balasan otomatis..." class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-[#E4EAE6]">
                <button type="button" onclick="if(typeof closeModal==='function'){closeModal('modal-create-reply')}else{const m=document.getElementById('modal-create-reply');m.classList.add('hidden');m.classList.remove('flex');}" class="px-4 py-2 text-sm font-medium text-[#697570] hover:bg-[#F6F8F7] rounded-md cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md cursor-pointer shadow-sm">Simpan Aturan</button>
            </div>
        </form>
    </div>
</div>
