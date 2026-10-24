<div class="bg-white rounded-2xl border border-[#E4EAE6] p-8 shadow-xs max-w-3xl mx-auto print:border-none print:shadow-none print:p-0">
    <div class="flex items-start justify-between border-b border-[#E4EAE6] pb-6 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-3 h-3 rounded-full bg-[#16A36A]"></span>
                <span class="font-['Geist'] text-lg font-bold text-[#17211F]">NyautWa Gateway</span>
            </div>
            <p class="text-xs text-[#697570]">Platform WhatsApp Gateway & API SaaS Indonesia</p>
            <p class="text-[11px] text-[#697570] mt-0.5">support@nyautwa.com • https://nyautwa.com</p>
        </div>
        <div class="text-right">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-2 <?= ($invoice['status'] === 'paid') ? 'bg-[#EAF7F0] text-[#16A36A]' : 'bg-[#FEF6E7] text-[#D99124]' ?>">
                <?= ($invoice['status'] === 'paid') ? '✓ LUNAS' : 'MENUNGGU' ?>
            </span>
            <div class="font-mono text-sm font-bold text-[#17211F]"><?= e($invoice['invoice_no']) ?></div>
            <div class="text-xs text-[#697570]">Tanggal: <?= date('d M Y H:i', strtotime($invoice['created_at'])) ?></div>
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

    <div class="pt-6 flex justify-between items-center text-xs">
        <div class="text-[11px] text-[#697570]">
            <p>Nota pembayaran ini adalah bukti transaksi sah yang diterbitkan otomatis oleh sistem NyautWa.</p>
        </div>
        <div class="text-right">
            <span class="text-xs text-[#697570]">Total Tagihan:</span>
            <div class="font-mono text-xl font-bold text-[#16A36A]">Rp <?= number_format((int)$invoice['amount'], 0, ',', '.') ?></div>
        </div>
    </div>
</div>
