<div id="modal-create-reply" class="fixed inset-0 z-50 hidden bg-[#17211F]/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl border border-[#E4EAE6] w-full max-w-lg p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-lg font-semibold text-[#17211F]">Tambah Aturan Balas Otomatis</h3>
            <button type="button" onclick="document.getElementById('modal-create-reply').classList.add('hidden')" class="text-[#697570] hover:text-[#17211F]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="/autoreplies" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Kata Kunci (Keyword)</label>
                <input type="text" name="keyword" required placeholder="Contoh: info, harga, menu" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Tipe Pencocokan</label>
                    <select name="match_type" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white">
                        <option value="contain">Mengandung Kata</option>
                        <option value="exact">Persis Sama</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#17211F] mb-1">Tipe Pesan</label>
                    <select name="type" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none bg-white">
                        <option value="text">Teks Biasa</option>
                        <option value="media">Gambar / Media</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">URL Media (Opsional)</label>
                <input type="url" name="media_url" placeholder="https://domain.com/brosur.jpg" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Isi Balasan Otomatis</label>
                <textarea name="response" rows="4" required placeholder="Halo! Terima kasih telah menghubungi kami. Berikut adalah informasi harga kami..." class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-[#E4EAE6]">
                <button type="button" onclick="document.getElementById('modal-create-reply').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-[#697570] hover:bg-[#F6F8F7] rounded-md">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md">Simpan Aturan</button>
            </div>
        </form>
    </div>
</div>
