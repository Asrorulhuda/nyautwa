<!-- Modal Tambah/Ubah Metode Pembayaran -->
<div id="modal-method" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 id="method-modal-title" class="text-sm font-bold text-[#17211F]">Tambah Rekening Pembayaran</h3>
            <button onclick="closeModal('modal-method')" type="button" class="p-1 rounded-lg text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="<?= url('/billing/methods/save') ?>" method="POST" class="space-y-3.5 text-xs">
            <?= csrf_field() ?>
            <input type="hidden" id="method-id" name="id" value="">
            <div>
                <label class="block font-medium text-[#17211F] mb-1">Nama Bank / Channel *</label>
                <input type="text" id="method-name" name="name" required placeholder="Contoh: Bank Central Asia (BCA)" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Kategori Channel</label>
                    <select id="method-type" name="type" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                        <option value="bank_transfer">Transfer Bank</option>
                        <option value="ewallet">E-Wallet</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Nomor Rekening / HP *</label>
                    <input type="text" id="method-acc-no" name="account_number" required placeholder="Contoh: 8830192831" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs font-mono">
                </div>
            </div>
            <div>
                <label class="block font-medium text-[#17211F] mb-1">Atas Nama (A.N.) *</label>
                <input type="text" id="method-acc-name" name="account_name" required placeholder="Contoh: PT TEKNOLOGI BERKAH INDONESIA" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
            </div>
            <div class="pt-3 border-t border-[#E4EAE6] flex items-center justify-end gap-2">
                <button onclick="closeModal('modal-method')" type="button" class="px-3.5 py-1.5 rounded-lg bg-[#F6F8F7] text-[#697570] font-semibold hover:bg-[#E4EAE6]">Batal</button>
                <button type="submit" class="px-4 py-1.5 rounded-lg bg-[#16A36A] text-white font-semibold hover:bg-[#128557] shadow-xs">Simpan Rekening</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openMethodModal() {
        document.getElementById('method-modal-title').innerText = 'Tambah Rekening Pembayaran';
        document.getElementById('method-id').value = '';
        document.getElementById('method-name').value = '';
        document.getElementById('method-type').value = 'bank_transfer';
        document.getElementById('method-acc-no').value = '';
        document.getElementById('method-acc-name').value = '';
        openModal('modal-method');
    }
    function editMethod(m) {
        document.getElementById('method-modal-title').innerText = 'Ubah Rekening Pembayaran';
        document.getElementById('method-id').value = m.id || '';
        document.getElementById('method-name').value = m.name || '';
        document.getElementById('method-type').value = m.type || 'bank_transfer';
        document.getElementById('method-acc-no').value = m.account_number || '';
        document.getElementById('method-acc-name').value = m.account_name || '';
        openModal('modal-method');
    }
</script>
