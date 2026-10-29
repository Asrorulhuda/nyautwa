<!-- Invoice Filters -->
<div class="flex items-center justify-between pb-4 mb-4 border-b border-[#E4EAE6]">
    <div class="flex items-center gap-1.5">
        <a href="<?= url('/billing?tab=invoices&status=all') ?>" class="px-3 py-1 rounded-lg text-xs font-medium <?= $status === 'all' ? 'bg-[#17211F] text-white' : 'bg-[#F6F8F7] text-[#697570] hover:text-[#17211F]' ?>">Semua (<?= count($invoices) ?>)</a>
        <a href="<?= url('/billing?tab=invoices&status=unpaid') ?>" class="px-3 py-1 rounded-lg text-xs font-medium <?= $status === 'unpaid' ? 'bg-[#D99124] text-white' : 'bg-[#F6F8F7] text-[#697570] hover:text-[#17211F]' ?>">Belum Bayar</a>
        <a href="<?= url('/billing?tab=invoices&status=paid') ?>" class="px-3 py-1 rounded-lg text-xs font-medium <?= $status === 'paid' ? 'bg-[#16A36A] text-white' : 'bg-[#F6F8F7] text-[#697570] hover:text-[#17211F]' ?>">Lunas</a>
    </div>
</div>

<div class="overflow-x-auto w-full">
    <table class="w-full text-left border-collapse text-xs">
        <thead>
            <tr class="bg-[#F6F8F7] text-[#697570] uppercase tracking-wider text-[11px] border-b border-[#E4EAE6]">
                <th class="py-3 px-4 font-semibold">No. Invoice & Tanggal</th>
                <th class="py-3 px-4 font-semibold">Klien / Tenant</th>
                <th class="py-3 px-4 font-semibold">Paket</th>
                <th class="py-3 px-4 font-semibold">Nominal</th>
                <th class="py-3 px-4 font-semibold">Bukti Bayar</th>
                <th class="py-3 px-4 font-semibold">Status</th>
                <th class="py-3 px-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#E4EAE6] text-[#17211F]">
            <?php if (empty($invoices)): ?>
            <tr><td colspan="7" class="py-8 text-center text-[#697570]">Belum ada invoice pada kategori ini.</td></tr>
            <?php else: ?>
                <?php foreach ($invoices as $inv): ?>
                <tr class="hover:bg-[#F6F8F7]/60 transition-colors">
                    <td class="py-3 px-4">
                        <div class="font-mono font-semibold text-[#17211F]"><?= e($inv['invoice_no'] ?: $inv['id']) ?></div>
                        <div class="font-mono text-[10px] text-[#697570]"><?= date('d M Y H:i', strtotime($inv['created_at'])) ?></div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-semibold text-[#17211F]"><?= e($inv['tenant_name'] ?? 'Klien') ?></div>
                        <div class="text-[#697570] text-[11px]"><?= e($inv['owner_name'] ?? '-') ?> <?= !empty($inv['owner_phone']) ? '('.e($inv['owner_phone']).')' : '' ?></div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-0.5 rounded-full font-mono text-[10px] font-semibold uppercase bg-[#EAF7F0] text-[#16A36A] border border-[#16A36A]/20">
                            <?= e($inv['plan_id']) ?>
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-mono font-semibold text-[#17211F]">Rp <?= number_format((float)$inv['amount'], 0, ',', '.') ?></div>
                        <div class="text-[10px] text-[#697570]"><?= e($inv['method_name'] ?? 'Transfer Bank') ?></div>
                    </td>
                    <td class="py-3 px-4">
                        <?php if (!empty($inv['payment_proof'])): ?>
                            <button onclick="viewPaymentProof('<?= e(url($inv['payment_proof'])) ?>', '<?= e($inv['invoice_no'] ?: $inv['id']) ?>')" type="button" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-[#EAF7F0] text-[#16A36A] font-semibold text-[11px] hover:bg-[#16A36A]/20 transition-colors" title="Lihat Bukti Transfer">
                                <span class="material-symbols-outlined text-[15px]">receipt</span> Cek Bukti
                            </button>
                        <?php else: ?>
                            <button onclick="uploadPaymentProof('<?= e($inv['id']) ?>', '<?= e($inv['invoice_no'] ?: $inv['id']) ?>')" type="button" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-[#F6F8F7] text-[#697570] hover:text-[#17211F] text-[10px] border border-[#E4EAE6]" title="Unggah Bukti Bayar">
                                <span class="material-symbols-outlined text-[13px]">upload_file</span> Unggah
                            </button>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full <?= $inv['status'] === 'paid' ? 'bg-[#EAF7F0] text-[#16A36A]' : 'bg-[#FEF6E7] text-[#D99124]' ?> font-semibold text-[11px]">
                            <span class="w-1.5 h-1.5 rounded-full <?= $inv['status'] === 'paid' ? 'bg-[#16A36A]' : 'bg-[#D99124] animate-pulse' ?>"></span>
                            <?= $inv['status'] === 'paid' ? 'Lunas' : 'Belum Bayar' ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <?php if ($inv['status'] !== 'paid'): ?>
                            <form action="<?= url('/billing/invoices/' . $inv['id'] . '/pay') ?>" method="POST" onsubmit="return confirm('Tandai invoice LUNAS dan perpanjang masa aktif klien?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-[#EAF7F0] text-[#16A36A] transition-colors" title="Tandai Lunas">
                                    <span class="material-symbols-outlined text-[17px]">check_circle</span>
                                </button>
                            </form>
                            <?php endif; ?>
                            <?php if (!empty($inv['owner_phone'])): ?>
                            <form action="<?= url('/billing/invoices/' . $inv['id'] . '/send-wa') ?>" method="POST" onsubmit="return confirm('Kirim tagihan via WhatsApp?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-[#FEF6E7] text-[#D99124] transition-colors" title="Kirim Tagihan via WA">
                                    <span class="material-symbols-outlined text-[17px]">send_to_mobile</span>
                                </button>
                            </form>
                            <?php endif; ?>
                            <a href="<?= url('/invoices/' . $inv['id']) ?>" target="_blank" class="p-1.5 rounded-lg hover:bg-[#F6F8F7] text-[#17211F] transition-colors" title="Lihat & Cetak Nota">
                                <span class="material-symbols-outlined text-[17px]">receipt_long</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
