<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-base font-bold text-on-surface">Klien Tenant Terbaru</h3>
            <p class="text-xs text-secondary mt-0.5">Daftar klien yang baru mendaftar atau aktif dalam gateway.</p>
        </div>
        <a href="<?= url('/clients') ?>" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
            <span>Kelola Semua Klien</span>
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-outline-variant/30 text-secondary font-medium">
                    <th class="py-2.5 px-3">Nama Tenant / Bisnis</th>
                    <th class="py-2.5 px-3">Paket</th>
                    <th class="py-2.5 px-3">Perangkat</th>
                    <th class="py-2.5 px-3">Pesan</th>
                    <th class="py-2.5 px-3">Status</th>
                    <th class="py-2.5 px-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                <?php if (empty($recent_tenants)): ?>
                    <tr>
                        <td colspan="6" class="py-6 text-center text-secondary">Belum ada data klien terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recent_tenants as $rt): ?>
                        <tr class="hover:bg-surface-container/50 transition-colors">
                            <td class="py-3 px-3">
                                <div class="font-semibold text-on-surface"><?= htmlspecialchars($rt['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="text-[11px] text-secondary font-mono"><?= htmlspecialchars($rt['owner_email'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded font-mono text-[11px] uppercase font-semibold bg-surface-container text-on-surface">
                                    <?= htmlspecialchars($rt['plan_id'] ?? 'starter', ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td class="py-3 px-3 font-mono text-on-surface"><?= $rt['device_count'] ?? 0 ?> Device</td>
                            <td class="py-3 px-3 font-mono text-on-surface"><?= number_format($rt['message_count'] ?? 0, 0, ',', '.') ?></td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full font-mono text-[10px] font-semibold <?= ($rt['status'] ?? '') === 'active' ? 'bg-emerald-500/15 text-primary' : 'bg-red-500/15 text-error' ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= ($rt['status'] ?? '') === 'active' ? 'bg-primary' : 'bg-error' ?>"></span>
                                    <?= ucfirst($rt['status'] ?? 'active') ?>
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <a href="<?= url('/clients') ?>" class="inline-flex items-center px-2.5 py-1 rounded-md bg-surface-container hover:bg-surface-container-high text-on-surface text-[11px] font-medium transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
