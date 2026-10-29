<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between h-full">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/20 mb-4">
            <h3 class="text-sm font-bold text-on-surface">Distribusi Paket SaaS</h3>
            <span class="text-[11px] font-mono text-secondary"><?= $total_clients ?> Tenant</span>
        </div>

        <div class="space-y-3">
            <?php foreach ($plan_distribution as $plan): ?>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-medium text-on-surface"><?= htmlspecialchars($plan['name']) ?> (<?= $plan['devices'] ?> Device)</span>
                        <span class="font-mono text-secondary"><?= $plan['count'] ?> Klien</span>
                    </div>
                    <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                        <div class="bg-primary h-full rounded-full transition-all" style="width: <?= $plan['percentage'] ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Cluster Engine Health -->
    <div class="mt-6 pt-4 border-t border-outline-variant/20">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-secondary">Baileys Cluster Engine</span>
            <span class="inline-flex items-center gap-1 text-[11px] font-mono <?= !empty($engine_status['online']) ? 'text-primary' : 'text-error' ?> font-semibold">
                <span class="w-2 h-2 rounded-full <?= !empty($engine_status['online']) ? 'bg-primary animate-pulse' : 'bg-error' ?>"></span>
                <?= htmlspecialchars((string)($engine_status['latency'] ?? '-')) ?>
            </span>
        </div>
        <div class="p-3 rounded-xl bg-surface-container flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined <?= !empty($engine_status['online']) ? 'text-primary' : 'text-error' ?> text-[18px]">dns</span>
                <span class="font-mono text-on-surface font-medium"><?= htmlspecialchars((string)($engine_status['name'] ?? 'Engine')) ?></span>
            </div>
            <span class="text-secondary font-mono text-[11px]"><?= htmlspecialchars((string)($engine_status['uptime'] ?? '-')) ?></span>
        </div>
    </div>
</div>
