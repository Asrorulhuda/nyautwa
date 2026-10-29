<?php
use App\Services\SidebarQuotaService;

$isAdmin = ($user['role'] ?? '') === 'admin';
$tenantId = $tenant['id'] ?? null;
$quotaData = (new SidebarQuotaService())->getSidebarData($tenantId, $isAdmin);
?>
<!-- Dynamic Quota Summary Card -->
<div class="p-2.5 rounded-lg bg-white/[0.03] border border-white/5 backdrop-blur-sm space-y-1.5 mt-2">
    <div class="flex items-center justify-between text-xs">
        <span class="text-white font-medium flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[14px] text-emerald-400">database</span>
            <span class="text-[12px]"><?= e($quotaData['label']) ?></span>
        </span>
        <span class="font-mono text-[10px] text-emerald-400 font-semibold">
            <?= number_format($quotaData['sent'], 0, ',', '.') ?> / <?= e($quotaData['limit_formatted']) ?>
        </span>
    </div>
    <div class="w-full h-1.5 rounded-full bg-white/10 overflow-hidden">
        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full shadow-[0_0_8px_rgba(52,211,153,0.8)] transition-all duration-500" 
             style="width: <?= max(4.0, (float)$quotaData['percentage']) ?>%;"></div>
    </div>
    <div class="flex items-center justify-between pt-0.5 text-[10px] text-outline-variant">
        <span><?= e($quotaData['percentage_text']) ?></span>
        <span class="text-emerald-300 font-medium truncate max-w-[90px]" title="<?= e($quotaData['plan_name']) ?>">
            <?= e($quotaData['plan_name']) ?>
        </span>
    </div>
</div>
