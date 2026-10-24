<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#17211F]">Broadcast Massal (Campaign Blast)</h1>
            <p class="text-sm text-[#697570] mt-1">Kirim pesan promosi atau pengumuman ke ratusan kontak dengan delay acak anti-ban.</p>
        </div>
        <button type="button" onclick="document.getElementById('modal-create-campaign').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Kampanye Baru
        </button>
    </div>

    <div class="bg-white border border-[#E4EAE6] rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm text-[#17211F]">
            <thead class="bg-[#F6F8F7] text-xs font-semibold uppercase text-[#697570] border-b border-[#E4EAE6]">
                <tr>
                    <th class="px-6 py-4">Nama Kampanye</th>
                    <th class="px-6 py-4">Node Pengirim</th>
                    <th class="px-6 py-4">Jumlah Target</th>
                    <th class="px-6 py-4">Jeda Anti-Ban</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4EAE6]">
                <?php if (empty($campaigns)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-[#697570]">
                            Belum ada kampanye broadcast blast. Klik "+ Buat Kampanye Baru" untuk memulai promosi massal.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($campaigns as $c): ?>
                        <tr class="hover:bg-[#F6F8F7]/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-[#17211F]"><?= htmlspecialchars($c['name']) ?></td>
                            <td class="px-6 py-4 text-xs text-[#697570]"><?= htmlspecialchars($c['device_label'] ?? 'Default Node') ?></td>
                            <td class="px-6 py-4 font-mono font-medium"><?= (int) $c['total_recipients'] ?> nomor</td>
                            <td class="px-6 py-4 text-xs font-mono text-[#697570]"><?= (int) $c['delay_min'] ?>s - <?= (int) $c['delay_max'] ?>s</td>
                            <td class="px-6 py-4">
                                <?php
                                $badgeClass = match($c['status']) {
                                    'completed' => 'bg-[#EAF7F0] text-[#16865A]',
                                    'processing' => 'bg-[#E0F2FE] text-[#0369A1]',
                                    default => 'bg-[#FEF6E7] text-[#D99124]'
                                };
                                ?>
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full <?= $badgeClass ?>">
                                    <?= ucfirst($c['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <?php if ($c['status'] !== 'completed'): ?>
                                    <a href="/campaigns/start/<?= $c['id'] ?>" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors">
                                        ▶ Kirim Sekarang
                                    </a>
                                <?php else: ?>
                                    <span class="text-xs text-[#16865A] font-medium">✓ Selesai Terkirim</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/partials/modal_create.php'; ?>
