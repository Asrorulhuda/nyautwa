<!-- Device Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php foreach ($devices as $dev): ?>
        <div class="bg-surface-container-lowest border border-surface-container-high/60 rounded-xl p-6 shadow-xs flex flex-col justify-between hover:border-primary/50 transition-all">
            <div>
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-11 h-11 rounded-lg bg-surface-container-low text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-2xl">phonelink_ring</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-on-surface"><?= e($dev['label']) ?></h3>
                            <p class="text-xs font-mono font-semibold text-on-surface mt-0.5"><?= e($dev['phone'] ?? 'Belum Terhubung') ?></p>
                            <span class="text-[11px] font-mono text-secondary">Sesi: <?= e($dev['session_ref']) ?></span>
                        </div>
                    </div>
                    <?php if ($dev['status'] === 'connected'): ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-surface-container-low text-primary">
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Terhubung
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-error-container text-on-error-container">
                            <span class="w-2 h-2 rounded-full bg-error"></span> Terputus
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Telemetry Indicators -->
                <div class="grid grid-cols-3 gap-2 p-3 bg-surface border border-surface-container rounded-lg text-xs mb-4">
                    <div>
                        <span class="text-[10px] text-secondary block">Baterai Ponsel</span>
                        <span class="font-mono font-semibold text-on-surface">88% Normal</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-secondary block">Sinyal Jaringan</span>
                        <span class="font-mono font-semibold text-primary">WiFi 5G</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-secondary block">Batas Harian</span>
                        <span class="font-mono font-semibold text-on-surface"><?= number_format((int)$dev['daily_limit']) ?> pesan</span>
                    </div>
                </div>
            </div>

            <!-- Action Controls -->
            <div class="pt-4 border-t border-surface-container flex items-center justify-between">
                <a href="<?= url('/devices/connect?id=' . $dev['id']) ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:underline">
                    <span class="material-symbols-outlined text-base">qr_code_scanner</span> Scan QR Sesi
                </a>
                <?php if ($dev['status'] === 'connected'): ?>
                    <form action="<?= url('/devices/disconnect/' . $dev['id']) ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memutuskan perangkat ini?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="text-xs text-error hover:underline font-medium">Putuskan Sesi</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
