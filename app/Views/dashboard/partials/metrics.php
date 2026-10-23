<!-- KPI METRICS (4 COLUMNS) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card 1: Total Pesan Terkirim -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Total Pesan Terkirim</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono"><?= number_format($stats['total_messages'] ?? 48920, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">outgoing_mail</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Dalam periode ini</span>
            <span class="inline-flex items-center gap-0.5 text-primary font-semibold">
                <span class="material-symbols-outlined text-[14px]">arrow_upward</span> +12.4%
            </span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-primary w-4/5 rounded-r"></div>
        </div>
    </div>

    <!-- Card 2: Pesan Berhasil -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Pesan Berhasil</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-primary font-bold tracking-tight font-mono"><?= number_format($stats['delivered_messages'] ?? 48140, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">done_all</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Delivered & Read</span>
            <span class="px-1.5 py-0.5 rounded bg-surface-container-low text-primary font-mono text-[11px] font-semibold">98.4% rasio</span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-primary-container w-[98.4%] rounded-r"></div>
        </div>
    </div>

    <!-- Card 3: Pesan Gagal -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Pesan Gagal</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-error font-bold tracking-tight font-mono"><?= number_format($stats['failed_messages'] ?? 780, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-error-container/40 flex items-center justify-center text-error">
                <span class="material-symbols-outlined text-[20px]">error_outline</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary truncate max-w-[130px]">Invalid / Timeout</span>
            <span class="inline-flex items-center gap-0.5 text-primary font-semibold">
                <span class="material-symbols-outlined text-[14px]">arrow_downward</span> -2.1%
            </span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-error w-[1.6%] rounded-r"></div>
        </div>
    </div>

    <!-- Card 4: Tingkat Keberhasilan -->
    <div class="relative overflow-hidden p-5 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col justify-between border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-wider text-secondary font-medium">Tingkat Keberhasilan</span>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-3xl text-on-surface font-bold tracking-tight font-mono">98.4%</span>
                    <span class="text-xs text-secondary font-mono">SLA: 99%</span>
                </div>
            </div>
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[20px]">speed</span>
            </div>
        </div>
        <div class="mt-4 pt-3 flex items-center justify-between text-xs">
            <span class="text-secondary">Latensi gateway</span>
            <span class="font-mono text-[11px] text-on-surface font-semibold bg-surface-container px-2 py-0.5 rounded">1.14 dtk</span>
        </div>
        <div class="absolute -bottom-1 left-0 right-0 h-1 bg-surface-container-high overflow-hidden">
            <div class="h-full bg-primary-fixed-dim w-full rounded-r"></div>
        </div>
    </div>
</div>
