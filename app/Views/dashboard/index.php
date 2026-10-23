<div class="space-y-8">
    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#17211F] tracking-tight font-['Geist']">Ringkasan Operasional Gateway</h1>
            <p class="text-xs text-[#697570] mt-1">Pemantauan telemetri real-time, status engine Baileys, dan throughput antrean pesan.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/devices/connect" class="inline-flex items-center gap-2 bg-[#FFFFFF] hover:bg-[#F6F8F7] border border-[#E4EAE6] text-xs font-semibold px-3.5 py-2 rounded-md transition-colors text-[#17211F]">
                <span class="material-symbols-outlined text-sm text-[#16A36A]">qr_code_scanner</span>
                Scan QR Device Baru
            </a>
            <a href="/messages/send" class="inline-flex items-center gap-2 bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-4 py-2 rounded-md transition-colors shadow-xs">
                <span class="material-symbols-outlined text-sm">send</span>
                Kirim Pesan Uji
            </a>
        </div>
    </div>

    <!-- Telemetry Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Metric 1: Engine Status -->
        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-[#697570]">Koneksi Device Utama</span>
                <span class="w-7 h-7 rounded-md bg-[#EAF7F0] text-[#16865A] flex items-center justify-center">
                    <span class="material-symbols-outlined text-base">phonelink_ring</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2 mb-1">
                <?php if ($primary_device && $primary_device['status'] === 'connected'): ?>
                    <span class="text-xl font-bold text-[#16865A] font-['Geist'] flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#16A36A] status-pulse"></span>
                        Terhubung
                    </span>
                <?php else: ?>
                    <span class="text-xl font-bold text-[#D84B4B] font-['Geist'] flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#D84B4B]"></span>
                        Terputus
                    </span>
                <?php endif; ?>
            </div>
            <p class="text-[11px] text-[#697570] font-mono mt-2 flex items-center justify-between">
                <span>Latensi: 42ms</span>
                <span class="text-[#16865A]">Baileys Ready</span>
            </p>
        </div>

        <!-- Metric 2: Messages Sent -->
        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-[#697570]">Pesan Sukses Terkirim</span>
                <span class="w-7 h-7 rounded-md bg-[#EAF7F0] text-[#16865A] flex items-center justify-center">
                    <span class="material-symbols-outlined text-base">mark_email_read</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2 mb-1">
                <span class="text-2xl font-bold text-[#17211F] font-mono tnum"><?= number_format($sent_today, 0, ',', '.') ?></span>
                <span class="text-xs text-[#697570] font-mono">/ <?= number_format($daily_limit, 0, ',', '.') ?></span>
            </div>
            <div class="w-full bg-[#E4EAE6] h-1.5 rounded-full overflow-hidden mt-3">
                <?php $pct = min(100, round(($sent_today / max(1, $daily_limit)) * 100)); ?>
                <div class="bg-[#16A36A] h-full rounded-full" style="width: <?= $pct ?>%"></div>
            </div>
        </div>

        <!-- Metric 3: Queue Status -->
        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-[#697570]">Antrean Outbox (Jitter)</span>
                <span class="w-7 h-7 rounded-md bg-[#FEF6E7] text-[#D99124] flex items-center justify-center">
                    <span class="material-symbols-outlined text-base">hourglass_top</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2 mb-1">
                <span class="text-2xl font-bold text-[#17211F] font-mono tnum"><?= $queued_count ?></span>
                <span class="text-xs text-[#697570]">Pesan Menunggu</span>
            </div>
            <p class="text-[11px] text-[#D99124] mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">shield</span>
                Jeda aman 3–8 dtk aktif
            </p>
        </div>

        <!-- Metric 4: Failed messages -->
        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-[#697570]">Pesan Gagal (Tindakan)</span>
                <span class="w-7 h-7 rounded-md bg-[#FDF0F0] text-[#D84B4B] flex items-center justify-center">
                    <span class="material-symbols-outlined text-base">error_outline</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2 mb-1">
                <span class="text-2xl font-bold text-[#D84B4B] font-mono tnum"><?= $failed_today ?></span>
                <span class="text-xs text-[#697570]">Pesan</span>
            </div>
            <p class="text-[11px] text-[#697570] mt-2">
                <?= $failed_today > 0 ? 'Nomor tujuan tidak terdaftar WA' : 'Semua nomor tujuan valid' ?>
            </p>
        </div>
    </div>

    <!-- Active Device Card (Sesuai docs/design/nyautwa/DESIGN.md & code.html) -->
    <?php if ($primary_device): ?>
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-[#E4EAE6]">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#EAF7F0] text-[#16865A] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">smartphone</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-bold text-[#17211F]"><?= e($primary_device['label']) ?></h2>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#EAF7F0] text-[#16865A]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#16A36A] status-pulse"></span>
                            Live Connected
                        </span>
                    </div>
                    <p class="text-xs text-[#697570] font-mono mt-0.5">
                        <?= e($primary_device['phone'] ?? '+62 812-8899-0011') ?> • Sesi: <?= e($primary_device['session_ref']) ?>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="/devices/connect?id=<?= e($primary_device['id']) ?>" class="bg-[#FFFFFF] hover:bg-[#F6F8F7] border border-[#E4EAE6] text-[#17211F] text-xs font-semibold px-3 py-2 rounded-md transition-colors inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                    Scan Ulang QR
                </a>
                <form action="/devices/<?= e($primary_device['id']) ?>/disconnect" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memutuskan sambungan sesi WhatsApp ini?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="bg-[#FFFFFF] hover:bg-[#FDF0F0] text-[#D84B4B] border border-[#F2D0D0] text-xs font-semibold px-3 py-2 rounded-md transition-colors inline-flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">power_settings_new</span>
                        Putuskan Sambungan
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 text-xs">
            <div>
                <span class="text-[#697570] block mb-1">Webhook URL Tujuan:</span>
                <span class="font-mono text-[11px] text-[#17211F] truncate block bg-[#F6F8F7] p-2 rounded border border-[#E4EAE6]">
                    <?= e($primary_device['webhook_url'] ?? 'Belum disetel') ?>
                </span>
            </div>
            <div>
                <span class="text-[#697570] block mb-1">Batas Aman Harian:</span>
                <span class="font-mono text-sm font-semibold text-[#17211F] block pt-1.5 tnum">
                    <?= number_format($primary_device['daily_limit'] ?? 5000, 0, ',', '.') ?> Pesan / Hari
                </span>
            </div>
            <div>
                <span class="text-[#697570] block mb-1">Protokol Engine:</span>
                <span class="font-mono text-xs font-semibold text-[#16865A] block pt-1.5">
                    Node.js 20 LTS + Baileys Multi-Device
                </span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recent Outbox Delivery Log Table -->
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-[#E4EAE6] flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-[#17211F]">Riwayat Pengiriman Pesan Terakhir</h3>
                <p class="text-xs text-[#697570]">Log outbox real-time dengan status pengiriman ack dari WhatsApp server.</p>
            </div>
            <a href="/messages" class="text-xs font-semibold text-[#16A36A] hover:underline flex items-center gap-1">
                Lihat Seluruh Log
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F6F8F7] text-[#697570] uppercase font-mono text-[10px] tracking-wider border-b border-[#E4EAE6]">
                    <tr>
                        <th class="py-3 px-5">ID Pesan</th>
                        <th class="py-3 px-5">Nomor Tujuan</th>
                        <th class="py-3 px-5">Isi Pesan</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4EAE6]">
                    <?php if (empty($recent_messages)): ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-[#697570]">
                                Belum ada riwayat pengiriman pesan. Klik "Kirim Pesan Uji" untuk memulai.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_messages as $msg): ?>
                            <tr class="hover:bg-[#FAFCFB] transition-colors">
                                <td class="py-3 px-5 font-mono text-[#697570]"><?= e($msg['id']) ?></td>
                                <td class="py-3 px-5 font-mono font-medium text-[#17211F]"><?= e($msg['to_from']) ?></td>
                                <td class="py-3 px-5 max-w-xs truncate text-[#17211F]"><?= e($msg['body']) ?></td>
                                <td class="py-3 px-5">
                                    <?php if (in_array($msg['status'], ['delivered', 'read', 'sent'])): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#EAF7F0] text-[#16865A]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#16A36A]"></span>
                                            <?= ucfirst($msg['status']) ?>
                                        </span>
                                    <?php elseif ($msg['status'] === 'queued'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#FEF6E7] text-[#D99124]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#D99124]"></span>
                                            Antrean
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#FDF0F0] text-[#D84B4B]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#D84B4B]"></span>
                                            Gagal
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-5 font-mono text-[#697570] text-[11px]">
                                    <?= date('H:i:s • d M', strtotime($msg['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
