<!-- Modal Delete Client Confirmation -->
<div id="modal-delete-client" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#FDF0F0] flex items-center justify-center text-[#D84B4B] shrink-0">
                <span class="material-symbols-outlined text-[22px]">delete</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#17211F] font-['Geist']">Hapus Akun Klien?</h3>
                <p class="text-xs text-[#697570]">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>

        <p class="text-xs text-[#17211F] leading-relaxed">
            Apakah Anda yakin ingin menghapus klien <strong id="delete-client-name" class="font-semibold text-[#D84B4B]"></strong>? 
            Seluruh data device, riwayat pesan, API key, dan riwayat nota penagihan akan dihapus secara permanen dari database.
        </p>

        <form id="form-delete-client" action="" method="POST" class="pt-2 flex items-center justify-end gap-2">
            <?= csrf_field() ?>
            <button onclick="closeModal('modal-delete-client')" type="button" class="px-4 py-2 rounded-lg bg-[#F6F8F7] text-[#697570] text-xs font-semibold hover:bg-[#E4EAE6] transition-colors">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-[#D84B4B] hover:bg-[#C23838] text-white text-xs font-semibold shadow-xs transition-colors">
                Ya, Hapus Permanen
            </button>
        </form>
    </div>
</div>

<script>
function confirmDeleteClient(id, name) {
    document.getElementById('delete-client-name').textContent = name;
    document.getElementById('form-delete-client').action = '<?= url('/clients/') ?>' + id + '/delete';
    openModal('modal-delete-client');
}
</script>
