<!-- Modal Buat Invoice Manual -->
<div id="modal-create-invoice" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-sm font-bold text-[#17211F]">Buat Invoice Tagihan Manual</h3>
            <button onclick="closeModal('modal-create-invoice')" type="button" class="p-1 rounded-lg text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="<?= url('/billing/invoices/create') ?>" method="POST" class="space-y-3.5 text-xs">
            <?= csrf_field() ?>
            <div>
                <label class="block font-medium text-[#17211F] mb-1">Pilih Klien / Tenant *</label>
                <select name="tenant_id" required class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                    <option value="">-- Pilih Klien Penerima --</option>
                    <?php foreach (($tenants ?? []) as $t): ?>
                    <option value="<?= e($t['id']) ?>"><?= e($t['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Pilihan Paket</label>
                    <select name="plan_id" id="inv-plan-select" onchange="applyInvoicePlan(this.value)" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                        <?php foreach (($plans ?? []) as $pk => $p): ?>
                        <option value="<?= e($pk) ?>" <?= $pk === 'starter' ? 'selected' : '' ?>><?= e($p['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Total Tagihan (Rp) *</label>
                    <input type="number" id="inv-amount" name="amount" required value="<?= (int)($plans['starter']['price'] ?? 149000) ?>" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs font-mono">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Metode Pembayaran</label>
                    <select name="payment_method_id" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                        <?php foreach (($methods ?? []) as $m): ?>
                        <option value="<?= e($m['id']) ?>"><?= e($m['name']) ?> (<?= e($m['account_number']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-[#17211F] mb-1">Status Awal</label>
                    <select name="status" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
                        <option value="unpaid" selected>Belum Bayar (Unpaid)</option>
                        <option value="paid">Lunas (Paid)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-medium text-[#17211F] mb-1">Catatan Tagihan</label>
                <input type="text" name="notes" placeholder="Contoh: Perpanjangan Langganan Paket Starter 1 Bulan" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs">
            </div>
            <div class="pt-3 border-t border-[#E4EAE6] flex items-center justify-end gap-2">
                <button onclick="closeModal('modal-create-invoice')" type="button" class="px-3.5 py-1.5 rounded-lg bg-[#F6F8F7] text-[#697570] font-semibold hover:bg-[#E4EAE6]">Batal</button>
                <button type="submit" class="px-4 py-1.5 rounded-lg bg-[#16A36A] text-white font-semibold hover:bg-[#128557] shadow-xs">Terbitkan Invoice</button>
            </div>
        </form>
    </div>
</div>
<script>
    const invPlanPrices = {
        <?php foreach (($plans ?? []) as $pk => $p): ?>
        '<?= e($pk) ?>': <?= (int)($p['price'] ?? 0) ?>,
        <?php endforeach; ?>
    };
    function applyInvoicePlan(k) {
        if (invPlanPrices[k] !== undefined) {
            document.getElementById('inv-amount').value = invPlanPrices[k];
        }
    }
</script>
