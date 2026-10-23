<!-- Messages Data Table -->
<div class="bg-surface-container-lowest border border-surface-container-high/60 rounded-xl overflow-hidden shadow-xs">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-surface-container-low text-secondary uppercase font-mono text-[10px] tracking-wider border-b border-surface-container">
                <tr>
                    <th class="py-3 px-4 font-semibold">Waktu Antrean</th>
                    <th class="py-3 px-4 font-semibold">ID Pesan</th>
                    <th class="py-3 px-4 font-semibold">Tujuan</th>
                    <th class="py-3 px-4 font-semibold">Konten Ringkas</th>
                    <th class="py-3 px-4 font-semibold">Perangkat</th>
                    <th class="py-3 px-4 font-semibold">Status Transmisi</th>
                    <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container text-on-surface">
                <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="7" class="py-12 text-center text-secondary">
                        <span class="material-symbols-outlined text-4xl text-outline-variant block mb-2">mark_chat_read</span>
                        Belum ada riwayat pesan keluar yang cocok dengan kriteria pencarian.
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                    <tr class="hover:bg-surface-container-low/50 transition-colors h-12">
                        <td class="py-3 px-4 font-mono text-secondary whitespace-nowrap">
                            <?= date('d/m H:i:s', strtotime($msg['created_at'])) ?>
                        </td>
                        <td class="py-3 px-4 font-mono text-primary font-semibold">
                            <?= e($msg['id']) ?>
                        </td>
                        <td class="py-3 px-4 font-mono font-medium whitespace-nowrap">
                            <?= e($msg['to_from']) ?>
                        </td>
                        <td class="py-3 px-4 max-w-xs truncate text-on-surface-variant" title="<?= e($msg['body']) ?>">
                            <?= e($msg['body']) ?>
                        </td>
                        <td class="py-3 px-4 text-secondary whitespace-nowrap">
                            <?= e($msg['device_label'] ?? 'CS Utama') ?>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <?php if ($msg['status'] === 'read' || $msg['status'] === 'delivered'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-surface-container-low text-primary">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span> <?= ucfirst($msg['status']) ?>
                                </span>
                            <?php elseif ($msg['status'] === 'sent'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-surface-container-low text-primary">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Terkirim
                                </span>
                            <?php elseif ($msg['status'] === 'failed'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-error-container text-on-error-container" title="<?= e($msg['error'] ?? 'Gagal') ?>">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Gagal
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-secondary-container text-on-secondary-container">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span> Antrean
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-right whitespace-nowrap">
                            <span class="font-mono text-[11px] text-secondary">
                                <?= $msg['wa_message_id'] ? substr($msg['wa_message_id'], 0, 10) . '...' : '-' ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
