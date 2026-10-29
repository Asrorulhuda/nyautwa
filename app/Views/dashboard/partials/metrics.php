<?php
$total = (int)($stats['total_messages'] ?? 0);
$delivered = (int)($stats['delivered_messages'] ?? 0);
$failed = (int)($stats['failed_messages'] ?? 0);
$ratio = $total > 0 ? round(($delivered / $total) * 100, 1) : 100.0;
$failedRatio = $total > 0 ? round(($failed / $total) * 100, 1) : 0.0;
?>
<!-- KPI METRICS (4 COLUMNS) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card 1: Total Pesan Terkirim -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Total Pesan</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= number_format($total, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">outgoing_mail</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Periode aktif</span>
            <span class="inline-flex items-center gap-0.5 text-primary font-semibold font-mono">Live</span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-primary w-full rounded-r"></div>
        </div>
    </div>

    <!-- Card 2: Pesan Berhasil -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Pesan Berhasil</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-primary font-bold tracking-tight font-mono"><?= number_format($delivered, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">done_all</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Terkirim / Terbaca</span>
            <span class="px-1.5 py-0.5 rounded bg-surface-container-low text-primary font-mono text-[11px] font-semibold"><?= $ratio ?>% rasio</span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-primary-container rounded-r" style="width: <?= min(100, max(0, $ratio)) ?>%"></div>
        </div>
    </div>

    <!-- Card 3: Pesan Gagal -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Pesan Gagal</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-error font-bold tracking-tight font-mono"><?= number_format($failed, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-error-container/40 flex items-center justify-center text-error">
                <span class="material-symbols-outlined text-[20px]">error_outline</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary truncate max-w-[130px]">Gagal / Timeout</span>
            <span class="px-1.5 py-0.5 rounded bg-[#FDF0F0] text-[#D84B4B] font-mono text-[11px] font-semibold"><?= $failedRatio ?>%</span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-error rounded-r" style="width: <?= min(100, max(0, $failedRatio)) ?>%"></div>
        </div>
    </div>

    <!-- Card 4: Tingkat Keberhasilan -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Rasio Keberhasilan</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= $ratio ?>%</span>
                    <span class="text-xs text-secondary font-mono">Target: 99%</span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[20px]">speed</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Kondisi gateway</span>
            <span class="font-mono text-[11px] text-[#16865A] font-semibold bg-[#EAF7F0] px-2 py-0.5 rounded">Optimal</span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-primary-fixed-dim rounded-r" style="width: <?= min(100, max(0, $ratio)) ?>%"></div>
        </div>
    </div>
</div>
