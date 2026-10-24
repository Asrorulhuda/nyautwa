<!-- Modal Tambah Fitur Baru oleh Admin -->
<div id="modal-add-feature" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <div>
                <h3 class="text-base font-bold text-[#17211F] font-['Geist']">Tambah Fitur Baru ke Katalog</h3>
                <p class="text-xs text-[#697570]">Fitur baru akan langsung muncul di checkbox paket pengguna.</p>
            </div>
            <button onclick="closeModal('modal-add-feature')" type="button" class="p-1 rounded-lg text-[#697570] hover:text-[#17211F] transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form action="<?= url('/features/create') ?>" method="POST" class="space-y-3.5">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Nama Fitur *</label>
                <input type="text" name="name" required placeholder="Contoh: Auto CRM Sync" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1">Kode Unik Fitur (Opsional)</label>
                <input type="text" name="code" placeholder="auto_crm_sync" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] font-mono placeholder-[#697570] focus:outline-none focus:border-[#16A36A]">
                <p class="text-[11px] text-[#697570] mt-1">Jika dikosongkan, kode akan otomatis dibuat dari nama fitur.</p>
            </div>

            <div class="pt-3 border-t border-[#E4EAE6] flex items-center justify-end gap-2">
                <button onclick="closeModal('modal-add-feature')" type="button" class="px-4 py-2 rounded-lg bg-[#F6F8F7] text-[#697570] text-xs font-semibold hover:bg-[#E4EAE6] transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold shadow-xs transition-colors">
                    Simpan Fitur Baru
                </button>
            </div>
        </form>
    </div>
</div>
