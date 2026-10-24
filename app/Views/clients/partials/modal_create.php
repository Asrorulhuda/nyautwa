<!-- Modal Tambahkan Pengguna (Matching Reference Mockup) -->
<div id="modal-create-client" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="relative w-full max-w-xl rounded-2xl bg-white p-6 shadow-xl border border-[#E4EAE6] space-y-4 my-8">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-base font-bold text-[#17211F] font-['Geist']">Tambahkan Pengguna</h3>
            <button onclick="closeModal('modal-create-client')" type="button" class="p-1 rounded-lg text-[#697570] hover:text-[#17211F] transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form action="<?= url('/clients/create') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <!-- Basic Fields (Nama pengguna, Email, Kata sandi, Batas Pesan, dll) -->
            <?php require __DIR__ . '/modal_create_fields.php'; ?>

            <!-- Features Checkboxes (3 columns) & Payment Method -->
            <?php require __DIR__ . '/modal_create_features.php'; ?>

            <div class="pt-4 border-t border-[#E4EAE6] flex items-center justify-end gap-2.5">
                <button onclick="closeModal('modal-create-client')" type="button" class="px-4 py-2 rounded-lg bg-[#F6F8F7] text-[#697570] text-xs font-semibold hover:bg-[#E4EAE6] transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-lg bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold shadow-xs transition-colors">
                    Tambahkan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
