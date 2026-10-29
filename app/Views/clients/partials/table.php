<!-- Client Table -->
<div class="overflow-x-auto w-full">
    <table class="w-full text-left border-collapse text-xs">
        <thead>
            <tr class="bg-[#F6F8F7] text-[#697570] uppercase tracking-wider text-[11px] border-b border-[#E4EAE6]">
                <th class="py-3 px-4 font-semibold">Pengguna / Klien</th>
                <th class="py-3 px-4 font-semibold">Kontak PIC</th>
                <th class="py-3 px-4 font-semibold">Paket & Batas</th>
                <th class="py-3 px-4 font-semibold">Masa Aktif</th>
                <th class="py-3 px-4 font-semibold">Status</th>
                <th class="py-3 px-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#E4EAE6] text-[#17211F]">
            <?php if (empty($clients)): ?>
            <tr><td colspan="6" class="py-8 text-center text-[#697570]">Belum ada pengguna / klien terdaftar.</td></tr>
            <?php else: foreach ($clients as $client): ?>
                <tr class="hover:bg-[#F6F8F7]/60 transition-colors">
                    <td class="py-3.5 px-4">
                        <div class="font-semibold text-[#17211F]"><?= e($client['name']) ?></div>
                        <div class="font-mono text-[10px] text-[#697570]">ID: <?= e(substr((string)$client['id'], 0, 10)) ?>...</div>
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="text-[#17211F] font-medium"><?= e($client['owner_name']) ?></div>
                        <div class="text-[#697570] text-[11px]"><?= e($client['owner_email']) ?></div>
                        <?php if (!empty($client['owner_phone']) && $client['owner_phone'] !== '-'): ?>
                        <div class="font-mono text-[10px] text-[#16A36A] flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[12px]">call</span><?= e($client['owner_phone']) ?>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="px-2 py-0.5 rounded-full font-mono text-[10px] font-semibold uppercase bg-[#EAF7F0] text-[#16A36A] border border-[#16A36A]/20">
                            <?= e($client['plan_name'] ?? $client['plan_id']) ?>
                        </span>
                        <div class="font-mono text-[11px] text-[#697570] mt-1">
                            <?= (int)($client['device_limit'] ?? 1) ?> node / <?= number_format((int)($client['message_limit'] ?? 1000), 0, ',', '.') ?> pesan
                        </div>
                    </td>
                    <td class="py-3.5 px-4">
                        <?php $days = $client['days_left'] ?? null; ?>
                        <?php if ($days === null): ?>
                            <span class="text-[#697570] text-[11px]">Tidak Terbatas</span>
                        <?php elseif ($days > 3): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#EAF7F0] text-[#16A36A] font-semibold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16A36A]"></span> Sisa <?= (int)$days ?> Hari
                            </span>
                        <?php elseif ($days >= 0): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#FEF6E7] text-[#D99124] font-semibold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D99124] animate-pulse"></span> Sisa <?= (int)$days ?> Hari
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#FDF0F0] text-[#D84B4B] font-semibold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D84B4B]"></span> Kadaluwarsa
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3.5 px-4">
                        <?php $isActive = ($client['status'] ?? '') === 'active'; ?>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full <?= $isActive ? 'bg-[#EAF7F0] text-[#16A36A]' : 'bg-[#FDF0F0] text-[#D84B4B]' ?> font-semibold text-[11px]">
                            <span class="w-1.5 h-1.5 rounded-full <?= $isActive ? 'bg-[#16A36A] animate-pulse' : 'bg-[#D84B4B]' ?>"></span>
                            <?= $isActive ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <button onclick="editClient(<?= htmlspecialchars(json_encode($client), ENT_QUOTES) ?>)" type="button" class="p-1.5 rounded-lg hover:bg-[#EAF7F0] text-[#16A36A] transition-colors" title="Ubah Klien & Paket">
                                <span class="material-symbols-outlined text-[17px]">edit</span>
                            </button>
                            <?php if (!empty($client['owner_phone']) && $client['owner_phone'] !== '-'): ?>
                            <form action="<?= url('/clients/' . $client['id'] . '/send-reminder') ?>" method="POST" class="inline" onsubmit="return confirm('Kirim pesan pengingat masa aktif via WhatsApp?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-[#FEF6E7] text-[#D99124] transition-colors" title="Kirim Pengingat WA">
                                    <span class="material-symbols-outlined text-[17px]">send_to_mobile</span>
                                </button>
                            </form>
                            <?php endif; ?>
                            <?php if (!empty($client['latest_invoice_id'])): ?>
                            <a href="<?= url('/invoices/' . $client['latest_invoice_id']) ?>" target="_blank" class="p-1.5 rounded-lg hover:bg-[#F6F8F7] text-[#17211F] transition-colors" title="Lihat Nota Pembayaran">
                                <span class="material-symbols-outlined text-[17px]">receipt_long</span>
                            </a>
                            <?php endif; ?>
                            <form action="<?= url('/clients/' . $client['id'] . '/toggle') ?>" method="POST" onsubmit="return confirm('Ubah status akun klien ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-[#F6F8F7] <?= $isActive ? 'text-[#D99124]' : 'text-[#16A36A]' ?> transition-colors" title="Ubah Status">
                                    <span class="material-symbols-outlined text-[17px]"><?= $isActive ? 'pause_circle' : 'play_circle' ?></span>
                                </button>
                            </form>
                            <button onclick="confirmDeleteClient(<?= htmlspecialchars(json_encode((string)$client['id']), ENT_QUOTES) ?>, <?= htmlspecialchars(json_encode((string)$client['name']), ENT_QUOTES) ?>)" type="button" class="p-1.5 rounded-lg hover:bg-[#FDF0F0] text-[#D84B4B] transition-colors" title="Hapus Klien">
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
