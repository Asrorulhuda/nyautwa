<div class="flex flex-col w-full space-y-6">
    <!-- Top Header Ribbon -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 rounded-2xl bg-white border border-[#E4EAE6] shadow-xs">
        <div>
            <h1 class="text-lg font-bold text-[#17211F] tracking-tight">Riwayat Pembayaran & Tagihan</h1>
            <p class="text-xs text-[#697570] mt-0.5">Pantau status tagihan langganan, unduh nota resmi, dan lakukan perpanjangan layanan.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= url('/onboarding/plan') ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold shadow-xs transition-colors">
                <span class="material-symbols-outlined text-[17px]">rocket_launch</span> Perpanjang / Upgrade Paket
            </a>
        </div>
    </div>

    <!-- Active Subscription Summary Banner -->
    <div class="p-4 rounded-xl bg-[#EAF7F0] border border-[#16A36A]/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-[#16A36A] text-white flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[22px]">workspace_premium</span>
            </div>
            <div>
                <div class="text-xs font-bold text-[#17211F]">Paket Aktif Saat Ini: <span class="text-[#16A36A]"><?= e($subscription['plan_name'] ?? 'Free Trial') ?></span></div>
                <div class="text-[11px] text-[#697570]">
                    <?php if (($subscription['days_left'] ?? null) !== null): ?>
                        Masa aktif berlaku hingga <span class="font-semibold text-[#17211F]"><?= date('d M Y', strtotime($subscription['ends_at'])) ?></span> (Sisa <?= $subscription['days_left'] ?> Hari)
                    <?php else: ?>
                        Masa aktif tidak terbatas (Admin)
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-white text-[#16A36A] border border-[#16A36A]/20 font-bold text-xs">
            <span class="w-2 h-2 rounded-full bg-[#16A36A] animate-pulse"></span> <?= strtoupper($subscription['status'] ?? 'active') ?>
        </span>
    </div>

    <!-- Invoices Table Bento Card -->
    <div class="p-6 rounded-2xl bg-white shadow-xs border border-[#E4EAE6]">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F6F8F7] text-[#697570] uppercase tracking-wider text-[11px] border-b border-[#E4EAE6]">
                        <th class="py-3 px-4 font-semibold">No. Invoice & Tanggal</th>
                        <th class="py-3 px-4 font-semibold">Paket</th>
                        <th class="py-3 px-4 font-semibold">Total Tagihan</th>
                        <th class="py-3 px-4 font-semibold">Metode Pembayaran</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4EAE6] text-[#17211F]">
                    <?php if (empty($invoices)): ?>
                    <tr><td colspan="6" class="py-8 text-center text-[#697570]">Belum ada riwayat tagihan invoice untuk akun Anda.</td></tr>
                    <?php else: ?>
                        <?php foreach ($invoices as $inv): ?>
                        <tr class="hover:bg-[#F6F8F7]/60 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-mono font-bold text-[#17211F]"><?= e($inv['invoice_no'] ?: $inv['id']) ?></div>
                                <div class="font-mono text-[10px] text-[#697570]"><?= date('d M Y H:i', strtotime($inv['created_at'])) ?></div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full font-mono text-[10px] font-semibold uppercase bg-[#EAF7F0] text-[#16A36A] border border-[#16A36A]/20">
                                    <?= e($inv['plan_id']) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-[#17211F]">Rp <?= number_format((float)$inv['amount'], 0, ',', '.') ?></td>
                            <td class="py-3.5 px-4 text-[#697570]"><?= e($inv['method_name'] ?? 'Transfer Bank') ?></td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full <?= $inv['status'] === 'paid' ? 'bg-[#EAF7F0] text-[#16A36A]' : 'bg-[#FEF6E7] text-[#D99124]' ?> font-semibold text-[11px]">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $inv['status'] === 'paid' ? 'bg-[#16A36A]' : 'bg-[#D99124] animate-pulse' ?>"></span>
                                    <?= $inv['status'] === 'paid' ? 'Lunas' : 'Menunggu Verifikasi' ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="<?= url('/invoices/' . $inv['id']) ?>" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg <?= $inv['status'] === 'paid' ? 'bg-[#F6F8F7] hover:bg-[#E4EAE6] text-[#17211F]' : 'bg-[#16A36A] hover:bg-[#128557] text-white' ?> font-semibold text-xs transition-colors">
                                    <span class="material-symbols-outlined text-[15px]"><?= $inv['status'] === 'paid' ? 'receipt_long' : 'payments' ?></span>
                                    <?= $inv['status'] === 'paid' ? 'Lihat Nota' : 'Bayar / Unggah Bukti' ?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
