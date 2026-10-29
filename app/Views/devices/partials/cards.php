<?php if (empty($devices)): ?>
<div class="bg-surface-container-lowest border border-dashed border-surface-container-high rounded-2xl p-12 text-center max-w-lg mx-auto">
    <div class="w-16 h-16 rounded-full bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center mx-auto mb-4">
        <span class="material-symbols-outlined text-3xl">phonelink_setup</span>
    </div>
    <h3 class="text-base font-bold text-on-surface">Belum Ada Perangkat WhatsApp</h3>
    <p class="text-xs text-secondary mt-1.5 mb-6 leading-relaxed">
        Tambahkan nomor WhatsApp pertama Anda untuk mulai mengirim pesan broadcast, balas otomatis (auto-reply), dan integrasi API.
    </p>
    <button onclick="openModal('modal-add-device')" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white text-xs font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-colors">
        <span class="material-symbols-outlined text-sm">add_circle</span>
        Tambah Perangkat Pertama
    </button>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php foreach ($devices as $dev): ?>
        <?php 
            $isConnected = ($dev['status'] ?? '') === 'connected';
            $isPending = ($dev['status'] ?? '') === 'pending_qr';
            $todaySent = (int) ($dev['today_sent'] ?? 0);
            $dailyLimit = (int) ($dev['daily_limit'] ?? 1000);
            $inbound = (int) ($dev['inbound_count'] ?? 0);
            $lastActive = !empty($dev['updated_at']) ? date('d M Y H:i', strtotime($dev['updated_at'])) : '-';
        ?>
        <div class="bg-surface-container-lowest border border-surface-container-high/60 rounded-xl p-5 shadow-xs flex flex-col justify-between hover:border-primary/50 transition-all">
            <div>
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg <?= $isConnected ? 'bg-[#EAF7F0] text-[#16A36A]' : 'bg-surface-container-low text-secondary' ?> flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-2xl"><?= $isConnected ? 'smartphone' : 'phonelink_ring' ?></span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-on-surface"><?= e($dev['label']) ?></h3>
                            <p class="text-xs font-mono font-semibold text-on-surface mt-0.5"><?= e($dev['phone'] ?? 'Nomor Belum Ditautkan') ?></p>
                            <span class="text-[10.5px] font-mono text-secondary">Sesi: <?= e($dev['session_ref']) ?></span>
                        </div>
                    </div>
                    <?php if ($isConnected): ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF7F0] text-[#16865A] border border-[#16A36A]/20">
                            <span class="w-2 h-2 rounded-full bg-[#16865A] animate-pulse"></span> Terhubung
                        </span>
                    <?php elseif ($isPending): ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#FEF6E7] text-[#D99124] border border-[#D99124]/30">
                            <span class="w-2 h-2 rounded-full bg-[#D99124] animate-pulse"></span> Menunggu QR
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#FDF0F0] text-[#D84B4B] border border-[#D84B4B]/20">
                            <span class="w-2 h-2 rounded-full bg-[#D84B4B]"></span> Terputus
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Real Metrics Grid (No hardcoded data) -->
                <div class="grid grid-cols-3 gap-2 p-3 bg-surface border border-surface-container rounded-lg text-xs mb-4">
                    <div>
                        <span class="text-[10px] text-secondary block font-medium" title="Batas harian nomor ini untuk mencegah banned WhatsApp">Limit Harian No WA</span>
                        <span class="font-mono font-semibold text-on-surface"><?= number_format($todaySent) ?> <span class="text-[10px] text-secondary font-normal">/ <?= number_format($dailyLimit) ?></span></span>
                    </div>
                    <div>
                        <span class="text-[10px] text-secondary block font-medium">Pesan Masuk</span>
                        <span class="font-mono font-semibold text-primary"><?= number_format($inbound) ?> pesan</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-secondary block font-medium">Sinkronisasi</span>
                        <span class="font-mono text-[11px] text-secondary truncate block" title="<?= e($lastActive) ?>"><?= e($lastActive) ?></span>
                    </div>
                </div>
            </div>

            <!-- Action Controls -->
            <div class="pt-3 border-t border-surface-container flex items-center justify-between gap-2 flex-wrap">
                <a href="<?= url('/devices/connect?id=' . $dev['id']) ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:underline">
                    <span class="material-symbols-outlined text-base">qr_code_scanner</span>
                    <?= $isConnected ? 'Scan Ulang Sesi' : 'Hubungkan Perangkat' ?>
                </a>
                <div class="flex items-center gap-3">
                    <?php if ($isConnected): ?>
                        <form action="<?= url('/devices/disconnect/' . $dev['id']) ?>" method="POST" onsubmit="return confirm('Putuskan sesi WhatsApp perangkat ini?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-xs text-[#D99124] hover:underline font-medium">Putuskan</button>
                        </form>
                    <?php endif; ?>
                    <form action="<?= url('/devices/delete/' . $dev['id']) ?>" method="POST" onsubmit="return confirm('Hapus perangkat WhatsApp ini beserta riwayat sesinya?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="text-xs text-[#D84B4B] hover:underline font-medium flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-[14px]">delete</span> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
