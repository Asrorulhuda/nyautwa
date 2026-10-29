<!-- Modal Edit Client -->
<div id="modal-edit-client" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-sm font-bold text-[#17211F]">Ubah Informasi & Paket Klien</h3>
            <button onclick="closeModal('modal-edit-client')" type="button" class="p-1 rounded-lg text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form id="form-edit-client" action="" method="POST" class="space-y-3.5 text-xs">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Nama Bisnis / Klien *</label>
                    <input type="text" id="edit-name" name="name" required class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                </div>
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Nomor WhatsApp *</label>
                    <input type="text" id="edit-phone" name="phone" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs font-mono">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Paket SaaS</label>
                    <select id="edit-plan" name="plan_id" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                        <?php foreach (($plans ?? []) as $pKey => $p): ?>
                        <option value="<?= e($pKey) ?>"><?= e($p['name']) ?> (<?= (int)$p['devices'] ?> Node / <?= number_format((int)$p['monthly_messages'], 0, ',', '.') ?> pesan)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Status Akun</label>
                    <select id="edit-status" name="status" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                        <option value="active">Aktif (Active)</option>
                        <option value="suspended">Ditangguhkan (Suspended)</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Batas Device</label>
                    <input type="number" id="edit-device-limit" name="device_limit" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                </div>
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Batas Kuota Pesan</label>
                    <input type="number" id="edit-message-limit" name="message_limit" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                </div>
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Berakhir Pada</label>
                    <input type="datetime-local" id="edit-sub-end" name="subscription_ends_at" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                </div>
            </div>
            <div class="pt-3 border-t border-[#E4EAE6] flex items-center justify-end gap-2">
                <button onclick="closeModal('modal-edit-client')" type="button" class="px-3.5 py-1.5 rounded-lg bg-[#F6F8F7] text-[#697570] font-semibold hover:bg-[#E4EAE6]">Batal</button>
                <button type="submit" class="px-4 py-1.5 rounded-lg bg-[#16A36A] text-white font-semibold hover:bg-[#128557] shadow-xs">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<script>
    function editClient(c) {
        document.getElementById('edit-name').value = c.name || '';
        document.getElementById('edit-phone').value = c.owner_phone || '';
        document.getElementById('edit-plan').value = c.plan_id || 'starter';
        document.getElementById('edit-status').value = c.status || 'active';
        document.getElementById('edit-device-limit').value = c.device_limit || 1;
        document.getElementById('edit-message-limit').value = c.message_limit || 1000;
        if (c.subscription_ends_at) {
            document.getElementById('edit-sub-end').value = c.subscription_ends_at.replace(' ', 'T').substring(0, 16);
        } else {
            document.getElementById('edit-sub-end').value = '';
        }
        document.getElementById('form-edit-client').action = '<?= url('/clients') ?>/' + encodeURIComponent(c.id);
        openModal('modal-edit-client');
    }
</script>
