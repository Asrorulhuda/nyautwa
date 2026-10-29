<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#17211F]">Buku Kontak (Phonebook)</h1>
            <p class="text-sm text-[#697570] mt-1">Kelola data nomor WhatsApp pelanggan dan grup untuk pengiriman broadcast terarah.</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <button type="button" onclick="if(typeof openModal==='function'){openModal('modal-sync-contacts')}else{const m=document.getElementById('modal-sync-contacts');m.classList.remove('hidden');m.classList.add('flex');}" class="px-3 py-2 text-sm font-medium text-[#16A36A] bg-[#EAF7F0] hover:bg-[#16A36A] hover:text-white rounded-md transition-colors shadow-xs flex items-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">sync</span> Tarik Kontak & Grup WA
            </button>
            <button type="button" onclick="if(typeof openModal==='function'){openModal('modal-create-tag')}else{const m=document.getElementById('modal-create-tag');m.classList.remove('hidden');m.classList.add('flex');}" class="px-3 py-2 text-sm font-medium text-[#17211F] bg-white border border-[#E4EAE6] hover:bg-[#F6F8F7] rounded-md transition-colors shadow-xs cursor-pointer">
                + Tambah Tag
            </button>
            <button type="button" onclick="if(typeof openModal==='function'){openModal('modal-create-contact')}else{const m=document.getElementById('modal-create-contact');m.classList.remove('hidden');m.classList.add('flex');}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors shadow-xs cursor-pointer">
                + Tambah Kontak
            </button>
        </div>
    </div>

    <!-- Tag Filter Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <a href="<?= url('/contacts') ?>" class="px-3 py-1.5 text-xs font-medium rounded-full transition-colors <?= empty($activeTag) ? 'bg-[#17211F] text-white' : 'bg-white border border-[#E4EAE6] text-[#697570] hover:text-[#17211F]' ?>">
            Semua Kontak (<?= count($contacts) ?>)
        </a>
        <?php foreach ($tags as $t): ?>
            <a href="<?= url('/contacts?tag=' . $t['id']) ?>" class="px-3 py-1.5 text-xs font-medium rounded-full transition-colors <?= $activeTag === $t['id'] ? 'bg-[#16A36A] text-white' : 'bg-white border border-[#E4EAE6] text-[#697570] hover:text-[#17211F]' ?>">
                <?= htmlspecialchars($t['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="bg-white border border-[#E4EAE6] rounded-xl overflow-hidden shadow-xs">
        <table class="w-full text-left text-sm text-[#17211F]">
            <thead class="bg-[#F6F8F7] text-xs font-semibold uppercase text-[#697570] border-b border-[#E4EAE6]">
                <tr>
                    <th class="px-5 py-3.5">Nama Kontak / Grup</th>
                    <th class="px-5 py-3.5">Identitas WhatsApp</th>
                    <th class="px-5 py-3.5">Tag Label</th>
                    <th class="px-5 py-3.5">Keterangan</th>
                    <th class="px-5 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4EAE6]">
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-[#697570]">
                            Belum ada kontak tersimpan. Klik "+ Tambah Kontak" atau "Tarik Kontak & Grup WA" dari perangkat Anda.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $c): 
                        $isGrp = str_ends_with($c['phone'], '@g.us');
                    ?>
                        <tr class="hover:bg-[#F6F8F7]/50 transition-colors">
                            <td class="px-5 py-3 font-semibold text-[#17211F] flex items-center gap-1.5">
                                <?php if ($isGrp): ?>
                                    <span class="material-symbols-outlined text-[#6366F1] text-[18px]">groups</span>
                                <?php else: ?>
                                    <span class="material-symbols-outlined text-[#16A36A] text-[18px]">person</span>
                                <?php endif; ?>
                                <span><?= htmlspecialchars($c['name']) ?></span>
                            </td>
                            <td class="px-5 py-3 font-mono text-xs text-[#17211F]"><?= htmlspecialchars($c['phone']) ?></td>
                            <td class="px-5 py-3">
                                <?php if ($c['tag_name']): ?>
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full text-white" style="background-color: <?= htmlspecialchars($c['tag_color'] ?? '#16A36A') ?>">
                                        <?= htmlspecialchars($c['tag_name']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-xs text-[#697570]">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-3 text-xs text-[#697570]"><?= htmlspecialchars($c['notes'] ?? '-') ?></td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST" action="<?= url('/contacts/delete/' . $c['id']) ?>" onsubmit="return confirm('Hapus kontak ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-xs text-[#D84B4B] hover:underline font-medium cursor-pointer">Hapus</button>
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
<?php require __DIR__ . '/partials/modal_sync.php'; ?>
