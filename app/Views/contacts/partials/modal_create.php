<!-- Modal Tambah Kontak -->
<div id="modal-create-contact" class="fixed inset-0 z-50 hidden bg-[#17211F]/50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl border border-[#E4EAE6] w-full max-w-md p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-lg font-semibold text-[#17211F]">Tambah Kontak Baru</h3>
            <button type="button" onclick="if(typeof closeModal==='function'){closeModal('modal-create-contact')}else{const m=document.getElementById('modal-create-contact');m.classList.add('hidden');m.classList.remove('flex');}" class="text-[#697570] hover:text-[#17211F] cursor-pointer">✕</button>
        </div>
        <form method="POST" action="<?= url('/contacts') ?>" class="space-y-3">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Nama Pelanggan</label>
                <input type="text" name="name" required placeholder="Budi Santoso" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Nomor WhatsApp (Awalan 62 atau 08)</label>
                <input type="text" name="phone" required placeholder="081234567890" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Tag / Kategori</label>
                <select name="tag_id" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white">
                    <option value="">-- Tanpa Tag --</option>
                    <?php foreach ($tags as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Catatan Tambahan (Opsional)</label>
                <input type="text" name="notes" placeholder="Pelanggan VIP / Reseller" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
            </div>
            <div class="flex justify-end gap-2 pt-3 border-t border-[#E4EAE6]">
                <button type="button" onclick="if(typeof closeModal==='function'){closeModal('modal-create-contact')}else{const m=document.getElementById('modal-create-contact');m.classList.add('hidden');m.classList.remove('flex');}" class="px-4 py-2 text-sm font-medium text-[#697570] hover:bg-[#F6F8F7] rounded-md cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md cursor-pointer">Simpan Kontak</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Tag -->
<div id="modal-create-tag" class="fixed inset-0 z-50 hidden bg-[#17211F]/50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl border border-[#E4EAE6] w-full max-w-sm p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-lg font-semibold text-[#17211F]">Buat Tag Baru</h3>
            <button type="button" onclick="if(typeof closeModal==='function'){closeModal('modal-create-tag')}else{const m=document.getElementById('modal-create-tag');m.classList.add('hidden');m.classList.remove('flex');}" class="text-[#697570] hover:text-[#17211F] cursor-pointer">✕</button>
        </div>
        <form method="POST" action="<?= url('/contacts/tags') ?>" class="space-y-3">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Nama Tag</label>
                <input type="text" name="name" required placeholder="Contoh: Reseller, Member VIP" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Warna Label</label>
                <input type="color" name="color" value="#16A36A" class="w-full h-10 p-1 border border-[#E4EAE6] rounded-md cursor-pointer">
            </div>
            <div class="flex justify-end gap-2 pt-3 border-t border-[#E4EAE6]">
                <button type="button" onclick="if(typeof closeModal==='function'){closeModal('modal-create-tag')}else{const m=document.getElementById('modal-create-tag');m.classList.add('hidden');m.classList.remove('flex');}" class="px-4 py-2 text-sm font-medium text-[#697570] hover:bg-[#F6F8F7] rounded-md cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md cursor-pointer">Buat Tag</button>
            </div>
        </form>
    </div>
</div>
