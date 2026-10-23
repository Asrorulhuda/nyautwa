<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card 1: Total Klien SaaS -->
    <div class="p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Total Klien SaaS</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= number_format($total_clients, 0, ',', '.') ?></span>
                    <span class="text-xs text-primary font-mono font-medium"><?= $active_clients ?> aktif</span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">corporate_fare</span>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-xs text-secondary">
            <span>Ditangguhkan: <strong class="text-on-surface font-mono"><?= $suspended_clients ?></strong></span>
            <a href="<?= url('/clients') ?>" class="text-primary hover:underline font-medium">Buka Klien &rarr;</a>
        </div>
    </div>

    <!-- Card 2: Perangkat WA Global -->
    <div class="p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Perangkat WA Global</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= $connected_devices ?></span>
                    <span class="text-xs text-secondary font-mono">/ <?= $total_devices ?> online</span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">devices</span>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-xs">
            <span class="text-secondary">Koneksi Sesi Baileys</span>
            <span class="px-2 py-0.5 rounded-full <?= $connected_devices > 0 ? 'bg-emerald-500/15 text-primary' : 'bg-surface-container text-secondary' ?> font-mono text-[11px] font-semibold">
                <?= $total_devices > 0 ? round(($connected_devices / max(1, $total_devices)) * 100) : 0 ?>% Terhubung
            </span>
        </div>
    </div>

    <!-- Card 3: Pesan Terproses Hari Ini -->
    <div class="p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Pesan Global Hari Ini</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-primary font-bold tracking-tight font-mono"><?= number_format($sent_today, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">outgoing_mail</span>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-xs text-secondary">
            <span>SLA Delivery</span>
            <span class="font-mono text-primary font-semibold"><?= $success_rate ?>% Berhasil</span>
        </div>
    </div>

    <!-- Card 4: Estimasi MRR SaaS -->
    <div class="p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Estimasi MRR SaaS</span>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-xs text-secondary font-mono">Rp</span>
                    <span class="text-2xl text-on-surface font-bold tracking-tight font-mono"><?= number_format($estimated_mrr, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">payments</span>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-xs text-secondary">
            <span>Paket Aktif: <strong class="text-on-surface font-mono"><?= $active_clients ?></strong></span>
            <span class="font-mono text-[11px] text-primary font-medium">Per Bulan</span>
        </div>
    </div>
</div>
