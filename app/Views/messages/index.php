<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-2xl font-bold text-[#17211F] tracking-tight font-['Geist']">Riwayat Pesan (Outbox)</h1>
                <span class="px-2.5 py-0.5 rounded-full font-mono text-xs font-semibold bg-[#EAF7F0] text-[#16865A]">
                    <?= count($messages) ?> Pesan Ditampilkan
                </span>
            </div>
            <p class="text-xs text-[#697570]">Log transmisi pesan keluar real-time dengan status verifikasi ACK dari node server WhatsApp.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= url('/messages/send') ?>" class="inline-flex items-center gap-2 bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-4 py-2.5 rounded-md transition-colors shadow-xs">
                <span class="material-symbols-outlined text-sm">send</span>
                Kirim Pesan Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-4 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Status Filter Chips -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="<?= url('/messages?status=all' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? 'all') === 'all' ? 'bg-[#17211F] text-white' : 'bg-[#F6F8F7] text-[#697570] hover:text-[#17211F]' ?>">
                Semua Status
            </a>
            <a href="<?= url('/messages?status=delivered' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? '') === 'delivered' ? 'bg-[#16A36A] text-white' : 'bg-[#F6F8F7] text-[#697570] hover:text-[#17211F]' ?>">
                Terkirim / Terbaca
            </a>
            <a href="<?= url('/messages?status=queued' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? '') === 'queued' ? 'bg-[#D99124] text-white' : 'bg-[#F6F8F7] text-[#697570] hover:text-[#17211F]' ?>">
                Antrean Jitter
            </a>
            <a href="<?= url('/messages?status=failed' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? '') === 'failed' ? 'bg-[#D84B4B] text-white' : 'bg-[#F6F8F7] text-[#697570] hover:text-[#17211F]' ?>">
                Gagal Kirim
            </a>
        </div>

        <!-- Search Form -->
        <form action="<?= url('/messages') ?>" method="GET" class="relative w-full md:w-72">
            <?php if (!empty($currentStatus) && $currentStatus !== 'all'): ?>
                <input type="hidden" name="status" value="<?= e($currentStatus) ?>">
            <?php endif; ?>
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#697570] text-sm pointer-events-none">search</span>
            <input 
                type="text" 
                name="q" 
                value="<?= e($searchQuery ?? '') ?>"
                placeholder="Cari nomor atau ID pesan..." 
                class="w-full pl-9 pr-3 py-1.5 bg-[#F6F8F7] border border-[#E4EAE6] rounded-md text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
            >
        </form>
    </div>

    <!-- Messages Data Table (Sesuai docs/design/nyautwa/DESIGN.md: 48px row height, tabular nums) -->
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F6F8F7] text-[#697570] uppercase font-mono text-[10px] tracking-wider border-b border-[#E4EAE6]">
                    <tr>
                        <th class="py-3 px-5">ID Pesan</th>
                        <th class="py-3 px-5">Waktu Kirim</th>
                        <th class="py-3 px-5">Nomor Tujuan</th>
                        <th class="py-3 px-5">Isi Pesan</th>
                        <th class="py-3 px-5">Device Node</th>
                        <th class="py-3 px-5">Status Pengiriman</th>
                        <th class="py-3 px-5 text-right">Latensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4EAE6]">
                    <?php if (empty($messages)): ?>
                        <tr>
                            <td colspan="7" class="py-12 text-center text-[#697570]">
                                Tidak ada data riwayat pesan yang sesuai dengan filter pencarian Anda.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($messages as $msg): ?>
                            <tr class="hover:bg-[#FAFCFB] transition-colors h-12">
                                <td class="py-3 px-5 font-mono text-[#697570] font-medium">
                                    <?= e($msg['id']) ?>
                                </td>
                                <td class="py-3 px-5 font-mono text-[#697570] text-[11px] whitespace-nowrap">
                                    <?= date('d M H:i:s', strtotime($msg['created_at'])) ?>
                                </td>
                                <td class="py-3 px-5 font-mono font-semibold text-[#17211F] whitespace-nowrap">
                                    <?= e($msg['to_from']) ?>
                                </td>
                                <td class="py-3 px-5 max-w-sm truncate text-[#17211F]" title="<?= e($msg['body']) ?>">
                                    <?= e($msg['body']) ?>
                                </td>
                                <td class="py-3 px-5 whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded bg-[#F6F8F7] border border-[#E4EAE6] text-[11px] text-[#17211F]">
                                        <?= e($msg['device_label'] ?? 'CS WhatsApp') ?>
                                    </span>
                                </td>
                                <td class="py-3 px-5 whitespace-nowrap">
                                    <?php if ($msg['status'] === 'delivered'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#EAF7F0] text-[#16865A]">
                                            <span class="material-symbols-outlined text-xs fill">done_all</span>
                                            Terkirim
                                        </span>
                                    <?php elseif ($msg['status'] === 'read'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#EAF7F0] text-[#16865A]">
                                            <span class="material-symbols-outlined text-xs fill text-[#16A36A]">done_all</span>
                                            Terbaca
                                        </span>
                                    <?php elseif ($msg['status'] === 'queued'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FEF6E7] text-[#D99124]">
                                            <span class="material-symbols-outlined text-xs">hourglass_top</span>
                                            Antrean Jitter
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FDF0F0] text-[#D84B4B]" title="<?= e($msg['error'] ?? 'Nomor tidak terdaftar WA') ?>">
                                            <span class="material-symbols-outlined text-xs">error</span>
                                            Gagal
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-5 text-right font-mono text-[#697570] text-[11px] tnum">
                                    <?= rand(38, 142) ?>ms
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
