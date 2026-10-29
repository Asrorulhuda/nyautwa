<div class="bg-white rounded-2xl border border-[#E4EAE6] p-8 shadow-xs max-w-3xl mx-auto print:border-none print:shadow-none print:p-0">
    <div class="flex items-start justify-between border-b border-[#E4EAE6] pb-6 mb-6">
        <div>
            <div class="flex items-center gap-2.5 mb-1">
                <img src="<?= url('/assets/images/logo.png') ?>" alt="NyautWa Logo" class="h-9 w-auto object-contain">
                <div class="flex flex-col">
                    <span class="font-['Geist'] text-lg font-bold text-[#17211F]">Nyaut<span class="text-[#16A36A]">Wa</span></span>
                    <span class="text-[9px] font-mono text-amber-600 font-bold tracking-wider">WA GATEWAY + CRM</span>
                </div>
            </div>
            <p class="text-[11px] text-[#697570] mt-0.5">support@nyautwa.com • https://nyautwa.com</p>
        </div>
        <div class="text-right">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-2 <?= ($invoice['status'] === 'paid') ? 'bg-[#EAF7F0] text-[#16A36A]' : 'bg-[#FEF6E7] text-[#D99124]' ?>">
                <?= ($invoice['status'] === 'paid') ? '✓ LUNAS' : 'MENUNGGU' ?>
            </span>
            <div class="font-mono text-sm font-bold text-[#17211F]"><?= e($invoice['invoice_no']) ?></div>
            <?php $invDate = (!empty($invoice['created_at']) && strtotime((string)$invoice['created_at'])) ? date('d M Y H:i', strtotime((string)$invoice['created_at'])) : '-'; ?>
            <div class="text-xs text-[#697570]">Tanggal: <?= e($invDate) ?></div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 pb-6 border-b border-[#E4EAE6] text-xs">
        <div>
            <div class="text-[#697570] font-semibold uppercase text-[10px] tracking-wider mb-1">Diterbitkan Untuk:</div>
            <div class="font-bold text-sm text-[#17211F]"><?= e($invoice['tenant']['name'] ?? 'Klien Bisnis') ?></div>
            <div class="text-[#17211F]"><?= e($invoice['owner']['name'] ?? '-') ?></div>
            <div class="text-[#697570]"><?= e($invoice['owner']['email'] ?? '-') ?></div>
        </div>
        <div>
            <div class="text-[#697570] font-semibold uppercase text-[10px] tracking-wider mb-1">Metode Pembayaran:</div>
            <div class="font-bold text-[#17211F]"><?= e($invoice['payment_method']['name'] ?? 'Transfer Bank') ?></div>
            <?php if (!empty($invoice['payment_method']['account_number'])): ?>
                <div class="font-mono text-[#17211F]">No. Rek: <?= e($invoice['payment_method']['account_number']) ?></div>
                <div class="text-[#697570]">a.n. <?= e($invoice['payment_method']['account_name']) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="py-6 border-b border-[#E4EAE6]">
        <table class="w-full text-xs text-left">
            <thead>
                <tr class="text-[#697570] uppercase text-[10px] tracking-wider border-b border-[#E4EAE6]">
                    <th class="pb-2">Rincian Paket / Layanan</th>
                    <th class="pb-2 text-center">Batas Node</th>
                    <th class="pb-2 text-center">Batas Pesan</th>
                    <th class="pb-2 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4EAE6]/60 text-[#17211F]">
                <tr>
                    <td class="py-3 font-semibold">
                        Paket Langganan <?= ucfirst(e($invoice['plan_id'])) ?>
                        <div class="font-normal text-[11px] text-[#697570]"><?= e($invoice['notes'] ?? '') ?></div>
                    </td>
                    <td class="py-3 text-center font-mono"><?= (int)($invoice['tenant']['device_limit'] ?? 1) ?> Device</td>
                    <td class="py-3 text-center font-mono"><?= number_format((int)($invoice['tenant']['message_limit'] ?? 1000), 0, ',', '.') ?> /hari</td>
                    <td class="py-3 text-right font-mono font-semibold">Rp <?= number_format((int)$invoice['amount'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php if (!empty($invoice['payment_proof'])): ?>
    <div class="py-4 border-b border-[#E4EAE6] text-xs flex items-center justify-between">
        <div>
            <div class="text-[#697570] font-semibold uppercase text-[10px] tracking-wider mb-1">Bukti Transfer:</div>
            <a href="<?= e(url($invoice['payment_proof'])) ?>" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#EAF7F0] text-[#16A36A] font-semibold hover:underline">
                <span class="material-symbols-outlined text-[15px]">receipt_long</span> Lihat Bukti
            </a>
        </div>
        <?php if (!empty($adminPhone)): $cp = preg_replace('/[^0-9]/', '', (string)$adminPhone); if (str_starts_with($cp, '0')) $cp = '62'.substr($cp,1); ?>
        <a href="https://wa.me/<?= e($cp) ?>?text=<?= urlencode('Halo Admin NyautWa, saya telah unggah bukti bayar untuk invoice ' . ($invoice['invoice_no'] ?? '')) ?>" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#16A36A] text-white font-semibold text-xs hover:bg-[#128557]">
            <span class="material-symbols-outlined text-[15px]">chat</span> Chat WA Admin
        </a>
        <?php endif; ?>
    </div>
    <?php elseif ($invoice['status'] !== 'paid'): ?>
    <div class="py-4 border-b border-[#E4EAE6] text-xs print:hidden">
        <form action="<?= url('/invoices/' . $invoice['id'] . '/proof') ?>" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3 rounded-xl bg-[#F6F8F7] border border-[#E4EAE6]">
            <?= csrf_field() ?>
            <div><span class="font-bold text-[#17211F] block">Unggah Bukti Transfer</span><span class="text-[11px] text-[#697570]">Lampirkan struk transfer di sini.</span></div>
            <div class="flex items-center gap-2">
                <input type="file" name="proof" required accept="image/*,application/pdf" class="text-xs text-[#697570] cursor-pointer">
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#16A36A] text-white font-semibold text-xs hover:bg-[#128557]">Kirim</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="pt-6 flex justify-between items-center text-xs">
        <div class="text-[11px] text-[#697570]"><p>Nota pembayaran sah yang diterbitkan sistem NyautWa.</p></div>
        <div class="text-right">
            <span class="text-xs text-[#697570]">Total Tagihan:</span>
            <div class="font-mono text-xl font-bold text-[#16A36A]">Rp <?= number_format((int)$invoice['amount'], 0, ',', '.') ?></div>
        </div>
    </div>
</div>
