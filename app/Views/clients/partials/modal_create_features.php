<div>
    <div class="flex items-center justify-between mb-2">
        <label class="block text-xs font-semibold text-[#17211F]">Hak Akses Fitur Klien</label>
        <span class="text-[11px] text-[#697570]">Centang modul yang diaktifkan untuk klien ini</span>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 p-3 rounded-xl bg-[#F6F8F7] border border-[#E4EAE6]">
        <?php 
        $coreMods = [
            'crm' => 'Live Chat CRM',
            'send_message' => 'Kirim Pesan Manual',
            'autoreply' => 'Balas Otomatis',
            'broadcast' => 'Broadcast Blast',
            'api_keys' => 'REST API & Webhook'
        ];
        foreach ($coreMods as $k => $label): ?>
        <label class="flex items-center gap-2 cursor-pointer hover:text-[#16A36A] transition-colors text-xs text-[#17211F]">
            <input type="checkbox" name="features[]" value="<?= e($k) ?>" class="rounded border-[#E4EAE6] text-[#16A36A] focus:ring-[#16A36A] w-4 h-4 cursor-pointer" checked>
            <span class="truncate"><?= e($label) ?></span>
        </label>
        <?php endforeach; ?>
        <?php foreach (($features ?? []) as $feat): if (isset($coreMods[$feat['code']])) continue; ?>
        <label class="flex items-center gap-2 cursor-pointer hover:text-[#16A36A] transition-colors text-xs text-[#17211F]">
            <input type="checkbox" name="features[]" value="<?= e($feat['code']) ?>" class="rounded border-[#E4EAE6] text-[#16A36A] focus:ring-[#16A36A] w-4 h-4 cursor-pointer" checked>
            <span class="truncate" title="<?= e($feat['name']) ?>"><?= e($feat['name']) ?></span>
        </label>
        <?php endforeach; ?>
    </div>
</div>

<div>
    <label class="block text-xs font-semibold text-[#17211F] mb-1">Metode Pembayaran (Nota Tagihan Otomatis)</label>
    <select name="payment_method_id" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
        <?php foreach (($paymentMethods ?? []) as $pm): ?>
            <option value="<?= e($pm['id']) ?>"><?= e($pm['name']) ?> <?= !empty($pm['account_number']) ? '('.e($pm['account_number']).')' : '' ?></option>
        <?php endforeach; ?>
    </select>
</div>
