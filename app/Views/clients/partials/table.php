<!-- Client Table -->
<div class="overflow-x-auto w-full">
    <table class="w-full text-left border-collapse text-xs">
        <thead>
            <tr class="bg-surface-container-low text-secondary uppercase tracking-wider text-[11px] border-b border-surface-container">
                <th class="py-3 px-4 font-semibold">Perusahaan / Klien</th>
                <th class="py-3 px-4 font-semibold">Pemilik Akun</th>
                <th class="py-3 px-4 font-semibold">Paket</th>
                <th class="py-3 px-4 font-semibold">Node & Pesan</th>
                <th class="py-3 px-4 font-semibold">Status</th>
                <th class="py-3 px-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-surface-container text-on-surface">
            <?php if (empty($clients)): ?>
            <tr><td colspan="6" class="py-8 text-center text-secondary">Belum ada tenant klien terdaftar.</td></tr>
            <?php else: ?>
                <?php foreach ($clients as $client): ?>
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                    <td class="py-3.5 px-4">
                        <div class="font-semibold text-on-surface"><?= e($client['name']) ?></div>
                        <div class="font-mono text-[10px] text-secondary">ID: <?= substr($client['id'], 0, 12) ?>...</div>
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="text-on-surface font-medium"><?= e($client['owner_name']) ?></div>
                        <div class="text-secondary text-[11px]"><?= e($client['owner_email']) ?></div>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="px-2.5 py-0.5 rounded-full font-mono text-[11px] font-semibold uppercase <?= $client['plan_id'] === 'pro' ? 'bg-primary/10 text-primary border border-primary/20' : ($client['plan_id'] === 'business' ? 'bg-amber-500/10 text-amber-700 border border-amber-500/20' : 'bg-surface-container text-secondary') ?>">
                            <?= e($client['plan_id']) ?>
                        </span>
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="flex items-center gap-2 font-mono text-[11px]">
                            <span class="inline-flex items-center gap-1 text-primary"><span class="material-symbols-outlined text-[13px]">cell_tower</span> <?= $client['device_count'] ?></span>
                            <span class="text-outline-variant">|</span>
                            <span class="text-secondary"><?= number_format($client['message_count'], 0, ',', '.') ?> pesan</span>
                        </div>
                    </td>
                    <td class="py-3.5 px-4">
                        <?php if ($client['status'] === 'active'): ?>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-surface-container-low text-primary font-semibold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span> Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-error-container text-on-error-container font-semibold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Ditangguhkan
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3.5 px-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <button onclick="editClient(<?= htmlspecialchars(json_encode($client), ENT_QUOTES, 'UTF-8') ?>)" type="button" class="p-1.5 rounded-lg hover:bg-surface-container text-secondary hover:text-on-surface transition-colors" title="Ubah Detail">
                                <span class="material-symbols-outlined text-[17px]">edit</span>
                            </button>
                            <form action="<?= url('/clients/' . $client['id'] . '/toggle') ?>" method="POST" onsubmit="return confirm('Ubah status akun klien ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-surface-container <?= $client['status'] === 'active' ? 'text-amber-600 hover:text-amber-700' : 'text-primary hover:text-primary-container' ?> transition-colors" title="<?= $client['status'] === 'active' ? 'Tangguhkan Akun' : 'Aktifkan Akun' ?>">
                                    <span class="material-symbols-outlined text-[17px]"><?= $client['status'] === 'active' ? 'pause_circle' : 'play_circle' ?></span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
