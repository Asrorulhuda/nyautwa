<!-- Client Table -->
<div class="overflow-x-auto w-full">
    <table class="w-full text-left border-collapse text-xs">
        <thead>
            <tr class="bg-[#F6F8F7] text-[#697570] uppercase tracking-wider text-[11px] border-b border-[#E4EAE6]">
                <th class="py-3 px-4 font-semibold">Pengguna / Klien</th>
                <th class="py-3 px-4 font-semibold">Email & PIC</th>
                <th class="py-3 px-4 font-semibold">Paket & Tingkat</th>
                <th class="py-3 px-4 font-semibold">Batas Kuota</th>
                <th class="py-3 px-4 font-semibold">Status</th>
                <th class="py-3 px-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#E4EAE6] text-[#17211F]">
            <?php if (empty($clients)): ?>
            <tr><td colspan="6" class="py-8 text-center text-[#697570]">Belum ada pengguna / klien terdaftar.</td></tr>
            <?php else: ?>
                <?php foreach ($clients as $client): ?>
                <tr class="hover:bg-[#F6F8F7]/60 transition-colors">
                    <td class="py-3.5 px-4">
                        <div class="font-semibold text-[#17211F]"><?= e($client['name']) ?></div>
                        <div class="font-mono text-[10px] text-[#697570]">ID: <?= substr($client['id'], 0, 10) ?>...</div>
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="text-[#17211F] font-medium"><?= e($client['owner_name']) ?></div>
                        <div class="text-[#697570] text-[11px]"><?= e($client['owner_email']) ?></div>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="px-2.5 py-0.5 rounded-full font-mono text-[11px] font-semibold uppercase bg-[#EAF7F0] text-[#16A36A] border border-[#16A36A]/20">
                            <?= e($client['plan_id']) ?>
                        </span>
                        <div class="text-[10px] text-[#697570] capitalize mt-0.5"><?= e($client['role'] ?? 'user') ?></div>
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="font-mono text-[11px]">
                            <span class="text-[#16A36A] font-medium"><?= (int)($client['device_limit'] ?? 1) ?> node</span>
                            <span class="text-[#697570]"> / <?= number_format((int)($client['message_limit'] ?? 1000), 0, ',', '.') ?> pesan</span>
                        </div>
                    </td>
                    <td class="py-3.5 px-4">
                        <?php if ($client['status'] === 'active'): ?>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#EAF7F0] text-[#16A36A] font-semibold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16A36A] animate-pulse"></span> Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FDF0F0] text-[#D84B4B] font-semibold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D84B4B]"></span> Nonaktif
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3.5 px-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <?php if (!empty($client['latest_invoice_id'])): ?>
                            <a href="<?= url('/invoices/' . $client['latest_invoice_id']) ?>" target="_blank" class="p-1.5 rounded-lg hover:bg-[#EAF7F0] text-[#16A36A] transition-colors" title="Lihat Nota Pembayaran">
                                <span class="material-symbols-outlined text-[17px]">receipt_long</span>
                            </a>
                            <?php endif; ?>
                            <form action="<?= url('/clients/' . $client['id'] . '/toggle') ?>" method="POST" onsubmit="return confirm('Ubah status akun klien ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-[#F6F8F7] <?= $client['status'] === 'active' ? 'text-[#D99124]' : 'text-[#16A36A]' ?> transition-colors" title="Ubah Status">
                                    <span class="material-symbols-outlined text-[17px]"><?= $client['status'] === 'active' ? 'pause_circle' : 'play_circle' ?></span>
                                </button>
                            </form>
                            <button onclick="confirmDeleteClient('<?= e($client['id']) ?>', '<?= e($client['name']) ?>')" type="button" class="p-1.5 rounded-lg hover:bg-[#FDF0F0] text-[#D84B4B] transition-colors" title="Hapus Klien">
                                <span class="material-symbols-outlined text-[17px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
