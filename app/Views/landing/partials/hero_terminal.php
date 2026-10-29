<?php
$realDevice = \App\Core\Database::fetchOne("SELECT label, phone, status FROM devices WHERE status = 'connected' LIMIT 1");
$nodeLabel = $realDevice['label'] ?? ($settings['node_name'] ?? 'NyautWa Engine Jakarta');
$nodePhone = !empty($realDevice['phone']) ? 'Terhubung (+' . substr($realDevice['phone'], 0, 4) . '***' . substr($realDevice['phone'], -3) . ')' : ($settings['node_phone'] ?? 'Gateway + CRM by asr_production');
$isLive = !empty($realDevice) || ($settings['node_status'] ?? 'ONLINE') === 'ONLINE';
?>
<!-- Hero Section Right Column (Realistic Product Preview) -->
<div class="lg:col-span-5 relative w-full">
    <div class="relative bg-surface-container-lowest rounded-xl shadow-xl overflow-hidden p-6 border border-surface-container-high/60">
        <!-- Mascot & Node Status Header -->
        <div class="flex items-center justify-between gap-3 pb-4 mb-4 border-b border-surface-container-high">
            <div class="flex items-center gap-3">
                <img src="<?= url('/assets/images/logo.png') ?>" alt="NyautWa Mascot" class="w-12 h-12 object-contain drop-shadow-sm flex-shrink-0">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-on-surface"><?= e($nodeLabel) ?></span>
                        <span class="px-2 py-0.5 rounded-full <?= $isLive ? 'bg-emerald-500/10 text-emerald-700' : 'bg-amber-500/10 text-amber-800' ?> text-[10px] font-mono font-bold">● <?= $isLive ? 'ONLINE' : 'STANDBY' ?></span>
                    </div>
                    <span class="text-[11px] text-on-surface-variant font-mono"><?= e($nodePhone) ?></span>
                </div>
            </div>
            <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-800 border border-amber-500/25">
                <span class="material-symbols-outlined text-[14px] text-amber-600">bolt</span>
                <span class="text-[11px] font-mono font-bold"><?= e($settings['node_uptime'] ?? '42ms latency') ?></span>
            </div>
        </div>
        <!-- Code Simulation Card -->
        <div class="rounded-lg bg-inverse-surface text-inverse-on-surface p-4 shadow-inner mb-4 overflow-x-auto">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-surface-container-highest/10 text-secondary-fixed-dim text-xs font-mono">
                <div class="flex items-center gap-2">
                    <span class="px-1.5 py-0.5 rounded bg-primary text-white font-mono text-[10px] font-bold">POST</span>
                    <span class="font-mono text-inverse-on-surface">/api/v1/messages/send</span>
                </div>
                <span class="font-mono text-[11px] text-amber-400">REST API + CRM</span>
            </div>
            <pre class="text-xs font-mono leading-relaxed text-surface-container-lowest"><code><span class="text-tertiary-fixed-dim">Authorization:</span> Bearer nwt_live_8f7b...
<span class="text-tertiary-fixed-dim">Content-Type:</span> application/json

{
  <span class="text-primary-fixed-dim">"to"</span>: <span class="text-secondary-fixed">"6281234567890"</span>,
  <span class="text-primary-fixed-dim">"message"</span>: <span class="text-secondary-fixed">"Halo! Pesanan #INV-9482 siap dikirim. Langsung nyaut via WhatsApp!"</span>
}</code></pre>
        </div>
        <!-- Webhook Receipt Indicator -->
        <div class="flex items-center justify-between px-3.5 py-2.5 rounded-lg bg-surface-container-low border border-surface-container">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[19px]">verified</span>
                <span class="text-xs text-on-surface font-semibold">Terkirim ke WhatsApp & Sinkron ke CRM</span>
            </div>
            <span class="text-xs text-primary font-mono font-bold">200 OK • Centang 2</span>
        </div>
    </div>
</div>
