<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#17211F]">Balas Otomatis (Auto-Reply)</h1>
            <p class="text-sm text-[#697570] mt-1">Konfigurasi pesan balasan otomatis instan saat pelanggan mengirimkan kata kunci tertentu.</p>
        </div>
        <button type="button" onclick="document.getElementById('modal-create-reply').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Balas Otomatis
        </button>
    </div>

    <div class="bg-white border border-[#E4EAE6] rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm text-[#17211F]">
            <thead class="bg-[#F6F8F7] text-xs font-semibold uppercase text-[#697570] border-b border-[#E4EAE6]">
                <tr>
                    <th class="px-6 py-4">Kata Kunci</th>
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
                        <td colspan="6" class="px-6 py-12 text-center text-[#697570]">
                            Belum ada aturan balas otomatis. Klik tombol "Tambah Balas Otomatis" untuk memulai.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($replies as $r): ?>
                        <tr class="hover:bg-[#F6F8F7]/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-medium text-[#16A36A]"><?= htmlspecialchars($r['keyword']) ?></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-[#EAF7F0] text-[#16865A]">
                                    <?= $r['match_type'] === 'exact' ? 'Persis Sama' : 'Mengandung Kata' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 uppercase text-xs font-semibold text-[#697570]"><?= htmlspecialchars($r['type']) ?></td>
                            <td class="px-6 py-4 max-w-xs truncate text-[#17211F]"><?= htmlspecialchars($r['response']) ?></td>
                            <td class="px-6 py-4">
                                <a href="/autoreplies/toggle/<?= $r['id'] ?>" class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-md <?= $r['status'] === 'active' ? 'bg-[#EAF7F0] text-[#16865A]' : 'bg-[#FEF6E7] text-[#D99124]' ?>">
                                    <?= $r['status'] === 'active' ? '● Aktif' : '○ Non-Aktif' ?>
                                </a>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="/autoreplies/delete/<?= $r['id'] ?>" onsubmit="return confirm('Hapus aturan balas otomatis ini?')">
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                    <button type="submit" class="text-xs text-[#D84B4B] hover:underline font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/partials/modal_create.php'; ?>
