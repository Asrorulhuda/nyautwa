<!-- Keys Management View (Search & Card Stack) -->
<div class="flex flex-col gap-4">
    <!-- Filter & Search Bar Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-surface-container-lowest p-2 rounded-xl shadow-xs border border-surface-container-high/60">
        <div class="flex items-center gap-2 flex-1 max-w-md bg-surface-container-low px-3 py-1.5 rounded-lg">
            <span class="material-symbols-outlined text-secondary text-[18px]">search</span>
            <input class="bg-transparent border-0 outline-hidden text-xs text-on-surface placeholder:text-secondary w-full" placeholder="Cari nama token atau identifier..." type="text">
        </div>
        <div class="flex items-center gap-1 self-end sm:self-auto">
            <div class="flex items-center bg-surface-container-low p-0.5 rounded-lg text-xs">
                <button class="px-2.5 py-1 rounded-md font-semibold bg-surface-container-lowest text-on-surface shadow-xs" type="button">Semua (<?= count($keys) ?>)</button>
                <button class="px-2.5 py-1 rounded-md text-secondary hover:text-on-surface transition-colors" type="button">Production</button>
                <button class="px-2.5 py-1 rounded-md text-secondary hover:text-on-surface transition-colors" type="button">Staging</button>
            </div>
        </div>
    </div>

    <!-- Keys Cards Grid / Stack -->
    <div class="space-y-4">
        <?php foreach ($keys as $k): ?>
        <div class="group bg-surface-container-lowest rounded-xl p-5 shadow-xs hover:shadow-md transition-all flex flex-col gap-4 border border-surface-container-high/60">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[22px]">dns</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-sm text-on-surface font-bold"><?= e($k['name']) ?></h3>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full font-mono text-[10px] bg-surface-container-low text-primary font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                Production
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-1 flex-wrap text-xs text-secondary">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[13px]">lock_open</span> Full Access</span>
                            <span>•</span>
                            <span class="font-mono text-[11px]">Dibuat <?= date('d M Y', strtotime($k['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 px-2 py-1 rounded-lg bg-surface-container-low self-start text-xs">
                    <span class="material-symbols-outlined text-primary text-[14px]">network_ping</span>
                    <span class="font-mono text-[11px]">Terakhir: <strong class="text-primary font-semibold"><?= $k['last_used_at'] ? date('H:i', strtotime($k['last_used_at'])) : 'Baru saja' ?></strong></span>
                </div>
            </div>
            <!-- Token String Panel -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-surface-container-low/60 p-3 rounded-lg border border-surface-container">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="text-xs font-mono text-secondary select-none">TOKEN:</span>
                    <code class="text-xs font-mono text-on-surface font-semibold tracking-wider truncate">
                        <?= e($k['prefix']) ?>••••••••••••••••••••••••3b9c
                    </code>
                </div>
                <div class="flex items-center gap-2 self-end sm:self-auto shrink-0">
                    <button onclick="copyToClipboard('<?= e($k['prefix']) ?>••••••••••••')" class="px-2.5 py-1.5 rounded-md bg-surface-container-lowest text-on-surface hover:text-primary text-xs font-semibold shadow-xs flex items-center gap-1 transition-colors cursor-pointer" type="button">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        <span>Salin</span>
                    </button>
                    <form action="<?= url('/api-keys/delete') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut kunci ini?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e($k['id']) ?>">
                        <button type="submit" class="px-2.5 py-1.5 rounded-md bg-error-container text-on-error-container hover:bg-error hover:text-white text-xs font-medium transition-colors cursor-pointer flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">delete_sweep</span>
                            <span>Cabut</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
