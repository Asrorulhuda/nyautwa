<!-- Recent Message Activity Table Container -->
<div class="rounded-xl bg-surface-container-lowest shadow-xs flex flex-col overflow-hidden border border-surface-container-high/60">
    <div class="p-5 flex items-center justify-between pb-3 border-b border-surface-container-high/40">
        <div>
            <h2 class="text-base font-semibold text-on-surface">Aktivitas Pesan Terbaru</h2>
            <p class="text-xs text-secondary">Log transmisi pesan masuk & keluar secara realtime</p>
        </div>
        <a class="inline-flex items-center gap-1 text-xs text-primary hover:text-primary-container font-semibold transition-colors" href="<?= url('/messages') ?>">
            Lihat Semua <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </a>
    </div>
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-surface-container-low text-secondary uppercase tracking-wider text-[11px]">
                    <th class="py-3 px-4 font-semibold">Penerima</th>
                    <th class="py-3 px-4 font-semibold">Preview Pesan</th>
                    <th class="py-3 px-4 font-semibold">Koneksi</th>
                    <th class="py-3 px-4 font-semibold">Status</th>
                    <th class="py-3 px-4 font-semibold">Waktu</th>
                    <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container text-on-surface">
                <?php if (empty($recentMessages)): ?>
                <tr>
                    <td colspan="6" class="py-6 text-center text-secondary">Belum ada aktivitas pesan keluar terbaru.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($recentMessages as $msg): ?>
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="py-3 px-4 font-mono font-medium"><?= e($msg['phone']) ?></td>
                        <td class="py-3 px-4 max-w-xs truncate text-on-surface-variant"><?= e($msg['message']) ?></td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-surface-container text-on-surface"><?= e($msg['device_label'] ?? 'CS Utama') ?></span></td>
                        <td class="py-3 px-4">
                            <?php if ($msg['status'] === 'read' || $msg['status'] === 'delivered'): ?>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-container-low text-primary font-semibold text-[11px]"><span class="material-symbols-outlined text-[13px]">done_all</span> <?= ucfirst($msg['status']) ?></span>
                            <?php elseif ($msg['status'] === 'sent'): ?>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-container-low text-primary font-medium text-[11px]"><span class="material-symbols-outlined text-[13px]">done</span> Sent</span>
                            <?php elseif ($msg['status'] === 'failed'): ?>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-error-container text-on-error-container font-semibold text-[11px]"><span class="material-symbols-outlined text-[13px]">error</span> Gagal</span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container text-[11px]"><span class="material-symbols-outlined text-[13px]">schedule</span> Antrean</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-secondary whitespace-nowrap"><?= date('H:i', strtotime($msg['created_at'])) ?></td>
                        <td class="py-3 px-4 text-right">
                            <a href="<?= url('/messages') ?>" class="p-1 rounded hover:bg-surface-container text-secondary inline-block" title="Detail">
                                <span class="material-symbols-outlined text-[16px]">data_object</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
