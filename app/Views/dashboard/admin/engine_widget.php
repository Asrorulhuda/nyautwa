<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between h-full">
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/20 mb-4">
            <h3 class="text-sm font-bold text-on-surface">Distribusi Paket SaaS</h3>
            <span class="text-[11px] font-mono text-secondary"><?= $total_clients ?> Tenant</span>
        </div>

        <div class="space-y-3">
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-medium text-on-surface">Starter (1 Device)</span>
                    <span class="font-mono text-secondary"><?= $plan_counts['starter'] ?> Klien</span>
                </div>
                <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                    <div class="bg-primary/70 h-full rounded-full" style="width: <?= $total_clients > 0 ? ($plan_counts['starter'] / $total_clients) * 100 : 0 ?>%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-medium text-on-surface">Professional (5 Devices)</span>
                    <span class="font-mono text-secondary"><?= $plan_counts['pro'] ?> Klien</span>
                </div>
                <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                    <div class="bg-primary h-full rounded-full" style="width: <?= $total_clients > 0 ? ($plan_counts['pro'] / $total_clients) * 100 : 0 ?>%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-medium text-on-surface">Enterprise (20 Devices)</span>
                    <span class="font-mono text-secondary"><?= $plan_counts['enterprise'] ?> Klien</span>
                </div>
                <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-600 h-full rounded-full" style="width: <?= $total_clients > 0 ? ($plan_counts['enterprise'] / $total_clients) * 100 : 0 ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cluster Engine Health -->
    <div class="mt-6 pt-4 border-t border-outline-variant/20">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-secondary">Baileys Cluster Engine</span>
            <span class="inline-flex items-center gap-1 text-[11px] font-mono text-primary font-semibold">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <?= $engine_status['latency'] ?>
            </span>
        </div>
        <div class="p-3 rounded-xl bg-surface-container flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">dns</span>
                <span class="font-mono text-on-surface font-medium"><?= $engine_status['name'] ?></span>
            </div>
            <span class="text-secondary font-mono text-[11px]"><?= $engine_status['uptime'] ?> SLA</span>
        </div>
    </div>
</div>
