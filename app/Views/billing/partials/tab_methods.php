<!-- Payment Methods Management -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if (empty($methods)): ?>
    <div class="col-span-full py-8 text-center text-[#697570] text-xs">Belum ada metode pembayaran yang dikonfigurasi.</div>
    <?php else: ?>
        <?php foreach ($methods as $pm): ?>
        <div class="p-4 rounded-xl border border-[#E4EAE6] bg-[#F6F8F7]/50 flex flex-col justify-between space-y-3">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full bg-white border border-[#E4EAE6] text-[#697570]"><?= e($pm['type']) ?></span>
                    <h4 class="text-sm font-bold text-[#17211F] mt-1"><?= e($pm['name']) ?></h4>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $pm['is_active'] ? 'bg-[#EAF7F0] text-[#16A36A]' : 'bg-[#FDF0F0] text-[#D84B4B]' ?>">
                    <span class="w-1.5 h-1.5 rounded-full <?= $pm['is_active'] ? 'bg-[#16A36A]' : 'bg-[#D84B4B]' ?>"></span>
                    <?= $pm['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                </span>
            </div>
            <div>
                <div class="text-[11px] text-[#697570]">Nomor Rekening / Akun:</div>
                <div class="font-mono text-sm font-bold text-[#17211F] tracking-wide select-all"><?= e($pm['account_number'] ?: '-') ?></div>
                <div class="text-[11px] text-[#697570] mt-0.5">a.n. <span class="font-semibold text-[#17211F]"><?= e($pm['account_name'] ?: '-') ?></span></div>
            </div>
            <div class="pt-3 border-t border-[#E4EAE6] flex items-center justify-between">
                <form action="<?= url('/billing/methods/' . $pm['id'] . '/toggle') ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="text-xs font-semibold <?= $pm['is_active'] ? 'text-[#D99124] hover:text-[#B57416]' : 'text-[#16A36A] hover:text-[#128557]' ?>">
                        <?= $pm['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                    </button>
                </form>
                <div class="flex items-center gap-1">
                    <button onclick="editMethod(<?= htmlspecialchars(json_encode($pm), ENT_QUOTES) ?>)" type="button" class="p-1.5 rounded-lg text-[#697570] hover:text-[#17211F] hover:bg-white" title="Ubah">
                        <span class="material-symbols-outlined text-[17px]">edit</span>
                    </button>
                    <form action="<?= url('/billing/methods/' . $pm['id'] . '/delete') ?>" method="POST" onsubmit="return confirm('Hapus metode pembayaran ini?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="p-1.5 rounded-lg text-[#D84B4B] hover:bg-[#FDF0F0]" title="Hapus">
                            <span class="material-symbols-outlined text-[17px]">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
