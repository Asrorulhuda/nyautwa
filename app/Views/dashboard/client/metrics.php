<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card 1: Kuota Pesan Bulan Ini -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Kuota Pesan Bulan Ini</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= number_format($sent_month, 0, ',', '.') ?></span>
                    <span class="text-xs text-secondary font-mono">/ <?= number_format($message_limit, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">data_usage</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Sisa: <strong class="text-on-surface font-mono"><?= number_format($remaining_quota, 0, ',', '.') ?></strong></span>
            <span class="font-mono text-primary font-semibold"><?= $quota_percentage ?>% terpakai</span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-primary rounded-r" style="width: <?= min(100, $quota_percentage) ?>%"></div>
        </div>
    </div>

    <!-- Card 2: Status WhatsApp -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Status WhatsApp</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= $connected_devices ?></span>
                    <span class="text-xs text-secondary font-mono">/ <?= $total_devices ?> online</span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg <?= $connected_devices > 0 ? 'bg-emerald-500/15 text-primary' : 'bg-surface-container text-secondary' ?> flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]">phone_android</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary"><?= $primary_device ? htmlspecialchars($primary_device['phone'] ?? 'Device Siap', ENT_QUOTES, 'UTF-8') : 'Belum scan QR' ?></span>
            <span class="inline-flex items-center gap-1 font-semibold <?= $connected_devices > 0 ? 'text-primary' : 'text-secondary' ?>">
                <span class="w-2 h-2 rounded-full <?= $connected_devices > 0 ? 'bg-primary' : 'bg-outline-variant' ?>"></span>
                <?= $connected_devices > 0 ? 'Connected' : 'Offline' ?>
            </span>
        </div>
    </div>

    <!-- Card 3: Pesan Terkirim Sukses -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Pesan Berhasil</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-primary font-bold tracking-tight font-mono"><?= number_format($sent_today, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">done_all</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Delivered & Read</span>
            <?php if ($success_rate !== null): ?>
                <span class="px-1.5 py-0.5 rounded bg-surface-container-low text-primary font-mono text-[11px] font-semibold"><?= $success_rate ?>% SLA</span>
            <?php else: ?>
                <span class="px-1.5 py-0.5 rounded bg-surface-container-low text-secondary font-mono text-[11px] font-medium">Belum Ada Trafik</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Card 4: Antrean & Gagal -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Dalam Antrean</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= number_format($queued_count, 0, ',', '.') ?></span>
                    <span class="text-xs text-error font-mono font-medium"><?= $failed_today ?> gagal</span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[20px]">schedule_send</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs text-secondary">
            <span>Buffer Outbox</span>
            <span class="font-mono text-primary font-semibold"><?= $queued_count > 0 ? 'Memproses...' : 'Lancar' ?></span>
        </div>
    </div>
</div>
