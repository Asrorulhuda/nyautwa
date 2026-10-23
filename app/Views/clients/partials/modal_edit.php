<!-- Modal Edit Client -->
<div id="modal-edit-client" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-md rounded-2xl bg-surface-container-lowest p-6 shadow-xl border border-surface-container-high/60 space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-surface-container-high">
            <h3 class="text-base font-bold text-on-surface">Ubah Informasi Klien</h3>
            <button onclick="closeModal('modal-edit-client')" type="button" class="p-1 rounded-lg text-secondary hover:text-on-surface">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form id="form-edit-client" action="" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <div>
                <label class="block font-medium text-on-surface mb-1">Nama Perusahaan / Bisnis *</label>
                <input type="text" id="edit-name" name="name" required class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block font-medium text-on-surface mb-1">Paket Langganan</label>
                <select id="edit-plan" name="plan_id" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
                    <option value="starter">Starter (10k pesan / bln)</option>
                    <option value="pro">Pro (50k pesan / bln)</option>
                    <option value="business">Business (Unlimited)</option>
                </select>
            </div>
            <div>
                <label class="block font-medium text-on-surface mb-1">Status Akun</label>
                <select id="edit-status" name="status" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
                    <option value="active">Aktif (Active)</option>
                    <option value="suspended">Ditangguhkan (Suspended)</option>
                </select>
            </div>
            <div class="pt-3 border-t border-surface-container-high flex items-center justify-end gap-2">
                <button onclick="closeModal('modal-edit-client')" type="button" class="px-4 py-2 rounded-lg bg-surface-container text-secondary font-semibold hover:bg-surface-container-high">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white font-semibold hover:bg-primary-container shadow-xs">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editClient(client) {
        document.getElementById('edit-name').value = client.name || '';
        document.getElementById('edit-plan').value = client.plan_id || 'starter';
        document.getElementById('edit-status').value = client.status || 'active';
        document.getElementById('form-edit-client').action = '<?= url('/clients') ?>/' + encodeURIComponent(client.id);
        openModal('modal-edit-client');
    }
</script>
