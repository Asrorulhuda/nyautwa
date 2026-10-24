<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#17211F]">Buku Kontak (Phonebook)</h1>
            <p class="text-sm text-[#697570] mt-1">Kelola data nomor WhatsApp pelanggan dan kelompokkan berdasarkan label tag.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="document.getElementById('modal-create-tag').classList.remove('hidden')" class="px-3 py-2 text-sm font-medium text-[#17211F] bg-white border border-[#E4EAE6] hover:bg-[#F6F8F7] rounded-md transition-colors shadow-sm">
                + Tambah Tag
            </button>
            <button type="button" onclick="document.getElementById('modal-create-contact').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors shadow-sm">
                + Tambah Kontak
            </button>
        </div>
    </div>

    <!-- Tag Filter Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <a href="/contacts" class="px-3 py-1.5 text-xs font-medium rounded-full transition-colors <?= empty($activeTag) ? 'bg-[#17211F] text-white' : 'bg-white border border-[#E4EAE6] text-[#697570] hover:text-[#17211F]' ?>">
            Semua Kontak (<?= count($contacts) ?>)
        </a>
        <?php foreach ($tags as $t): ?>
            <a href="/contacts?tag=<?= $t['id'] ?>" class="px-3 py-1.5 text-xs font-medium rounded-full transition-colors <?= $activeTag === $t['id'] ? 'bg-[#16A36A] text-white' : 'bg-white border border-[#E4EAE6] text-[#697570] hover:text-[#17211F]' ?>">
                <?= htmlspecialchars($t['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="bg-white border border-[#E4EAE6] rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm text-[#17211F]">
            <thead class="bg-[#F6F8F7] text-xs font-semibold uppercase text-[#697570] border-b border-[#E4EAE6]">
                <tr>
                    <th class="px-6 py-4">Nama Pelanggan</th>
                    <th class="px-6 py-4">Nomor WhatsApp</th>
                    <th class="px-6 py-4">Tag / Label</th>
                    <th class="px-6 py-4">Catatan</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4EAE6]">
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-[#697570]">
                            Belum ada kontak tersimpan. Klik "+ Tambah Kontak" untuk mencatat nomor pelanggan.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $c): ?>
                        <tr class="hover:bg-[#F6F8F7]/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-[#17211F]"><?= htmlspecialchars($c['name']) ?></td>
                            <td class="px-6 py-4 font-mono text-[#16A36A]"><?= htmlspecialchars($c['phone']) ?></td>
                            <td class="px-6 py-4">
                                <?php if ($c['tag_name']): ?>
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full text-white" style="background-color: <?= htmlspecialchars($c['tag_color'] ?? '#16A36A') ?>">
                                        <?= htmlspecialchars($c['tag_name']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-xs text-[#697570]">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-xs text-[#697570]"><?= htmlspecialchars($c['notes'] ?? '-') ?></td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="/contacts/delete/<?= $c['id'] ?>" onsubmit="return confirm('Hapus kontak ini?')">
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
