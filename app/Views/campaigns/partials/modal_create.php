<div id="modal-create-campaign" class="fixed inset-0 z-50 hidden bg-[#17211F]/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl border border-[#E4EAE6] w-full max-w-lg p-6 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-lg font-semibold text-[#17211F]">Buat Kampanye Blast Baru</h3>
            <button type="button" onclick="document.getElementById('modal-create-campaign').classList.add('hidden')" class="text-[#697570] hover:text-[#17211F]">✕</button>
        </div>

        <form method="POST" action="<?= url('/campaigns') ?>" class="space-y-3">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Nama Kampanye</label>
                <input type="text" name="name" required placeholder="Contoh: Promo Gajian Oktober" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Node WhatsApp Pengirim</label>
                    <select name="device_id" required class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white">
                        <?php foreach ($devices as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['label']) ?> (<?= htmlspecialchars($d['status']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Pilih Kontak dari Tag</label>
                    <select name="tag_id" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white">
                        <option value="">-- Manual / Input Bawah Saja --</option>
                        <?php foreach ($tags as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Daftar Nomor Tambahan (1 nomor per baris)</label>
                <textarea name="receivers" rows="3" placeholder="081234567890&#10;089876543210" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none font-mono"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Jeda Min (Detik)</label>
                    <input type="number" name="delay_min" value="5" min="3" max="60" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Jeda Max (Detik)</label>
                    <input type="number" name="delay_max" value="15" min="5" max="120" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Pesan Promosi (Mendukung Spintax: {Halo|Hai})</label>
                <textarea name="message" rows="4" required placeholder="{Halo|Hai|Selamat Siang} Kak! Ada penawaran spesial untuk Anda hari ini..." class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-[#E4EAE6]">
                <button type="button" onclick="document.getElementById('modal-create-campaign').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-[#697570] hover:bg-[#F6F8F7] rounded-md">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md">Simpan Kampanye</button>
            </div>
        </form>
    </div>
</div>
