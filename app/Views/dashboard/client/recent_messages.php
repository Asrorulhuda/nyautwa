<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-base font-bold text-on-surface">Riwayat Pesan Terakhir</h3>
            <p class="text-xs text-secondary mt-0.5">Daftar pesan terbaru yang dikirim melalui akun WhatsApp bisnis Anda.</p>
        </div>
        <a href="<?= url('/messages') ?>" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
            <span>Lihat Semua Pesan</span>
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-outline-variant/30 text-secondary font-medium">
                    <th class="py-2.5 px-3">Tujuan (Nomor WA)</th>
                    <th class="py-2.5 px-3">Isi Pesan</th>
                    <th class="py-2.5 px-3">Status</th>
                    <th class="py-2.5 px-3 text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                <?php if (empty($recent_messages)): ?>
                    <tr>
                        <td colspan="4" class="py-8 text-center text-secondary">
                            <span class="material-symbols-outlined text-3xl text-outline-variant mb-1 block">chat_bubble_outline</span>
                            Belum ada riwayat pengiriman pesan hari ini.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recent_messages as $msg): ?>
                        <tr class="hover:bg-surface-container/50 transition-colors">
                            <td class="py-3 px-3 font-mono text-on-surface font-medium">
                                <?= htmlspecialchars($msg['to_from'] ?? $msg['recipient'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </td>
                            <td class="py-3 px-3 text-secondary max-w-[240px] truncate">
                                <?= htmlspecialchars($msg['body'] ?? $msg['message'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </td>
                            <td class="py-3 px-3">
                                <?php
                                $st = $msg['status'] ?? 'pending';
                                $badgeClass = match($st) {
                                    'sent', 'delivered', 'read' => 'bg-emerald-500/15 text-primary',
                                    'failed' => 'bg-red-500/15 text-error',
                                    'queued' => 'bg-amber-500/15 text-amber-700',
                                    default => 'bg-surface-container text-secondary',
                                };
                                ?>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full font-mono text-[10px] font-semibold <?= $badgeClass ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= ($st === 'failed') ? 'bg-error' : (($st === 'queued') ? 'bg-amber-500' : 'bg-primary') ?>"></span>
                                    <?= ucfirst($st) ?>
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right text-secondary font-mono text-[11px]">
                                <?= date('H:i:s', strtotime($msg['created_at'] ?? 'now')) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
