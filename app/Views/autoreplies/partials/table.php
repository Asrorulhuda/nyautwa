<div class="bg-white border border-[#E4EAE6] rounded-xl overflow-hidden shadow-sm">
    <table class="w-full text-left text-sm text-[#17211F]">
        <thead class="bg-[#F6F8F7] text-xs font-semibold uppercase text-[#697570] border-b border-[#E4EAE6]">
            <tr>
                <th class="px-4 py-4 w-10 text-center">
                    <input type="checkbox" id="check-all" class="rounded border-[#E4EAE6] text-[#16A36A] focus:ring-[#16A36A] cursor-pointer" onclick="toggleSelectAll(this)">
                </th>
                <th class="px-6 py-4">Kata Kunci</th>
                <th class="px-6 py-4">Perangkat</th>
                <th class="px-6 py-4">Kecocokan</th>
                <th class="px-6 py-4">Tipe Balasan</th>
                <th class="px-6 py-4">Isi Pesan Balasan</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#E4EAE6]">
            <?php if (empty($replies)): ?>
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-[#697570]">
                        Belum ada aturan balas otomatis. Klik tombol "Tambah Balas Otomatis" atau "Import Excel" untuk memulai.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($replies as $r): ?>
                    <tr class="hover:bg-[#F6F8F7]/50 transition-colors">
                        <td class="px-4 py-4 text-center">
                            <input type="checkbox" value="<?= htmlspecialchars($r['id']) ?>" class="reply-checkbox rounded border-[#E4EAE6] text-[#16A36A] focus:ring-[#16A36A] cursor-pointer" onchange="updateSelectionBar()">
                        </td>
                        <td class="px-6 py-4 font-mono font-medium text-[#16A36A]"><?= htmlspecialchars($r['keyword']) ?></td>
                        <td class="px-6 py-4 text-xs text-[#17211F]">
                            <?php if (!empty($r['device_label'])): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-[#F0F4F2] text-[#17211F] font-medium border border-[#E4EAE6]">
                                    <?= htmlspecialchars($r['device_label']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-[#697570] text-xs italic">Semua (Global)</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-[#EAF7F0] text-[#16865A]">
                                <?= $r['match_type'] === 'exact' ? 'Persis Sama' : 'Mengandung' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-medium bg-[#F0F4F2] text-[#17211F] border border-[#E4EAE6]">
                                <?= htmlspecialchars(strtoupper($r['type'])) ?>
                                <?php if (!empty($r['media_url'])): ?>
                                    <a href="<?= htmlspecialchars($r['media_url']) ?>" target="_blank" class="text-[#16A36A] hover:underline" title="Lihat Berkas">📎</a>
                                <?php endif; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-xs truncate text-[#17211F]"><?= htmlspecialchars($r['response']) ?></td>
                        <td class="px-6 py-4">
                            <a href="<?= url('/autoreplies/toggle/' . $r['id']) ?>" class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-md <?= $r['status'] === 'active' ? 'bg-[#EAF7F0] text-[#16865A]' : 'bg-[#FEF6E7] text-[#D99124]' ?>">
                                <?= $r['status'] === 'active' ? '● Aktif' : '○ Non-Aktif' ?>
                            </a>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button type="button" onclick="editAutoReply(<?= htmlspecialchars(json_encode($r), ENT_QUOTES, 'UTF-8') ?>)" class="text-xs text-[#16A36A] hover:underline font-semibold cursor-pointer">Edit</button>
                                <form method="POST" action="<?= url('/autoreplies/delete/' . $r['id']) ?>" onsubmit="return confirm('Hapus aturan balas otomatis ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-xs text-[#D84B4B] hover:underline font-medium cursor-pointer">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
