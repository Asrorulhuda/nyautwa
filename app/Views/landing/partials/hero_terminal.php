<!-- Hero Section Right Column (Realistic Product Preview) -->
<div class="lg:col-span-5 relative w-full">
    <div class="relative bg-surface-container-lowest rounded-xl shadow-xl overflow-hidden p-6 border border-surface-container-high/60">
        <!-- Node Status Header -->
        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 mb-5 border-b border-surface-container-high">
            <div class="flex items-center gap-3">
                <div class="w-3.5 h-3.5 rounded-full bg-primary relative flex items-center justify-center">
                    <span class="absolute w-4 h-4 rounded-full bg-primary/30 animate-ping"></span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-on-surface"><?= e($settings['node_name'] ?? 'Server Node Jakarta 01') ?></span>
                        <span class="px-2 py-0.5 rounded bg-surface-container-low text-primary text-xs font-mono font-medium">Aktif</span>
                    </div>
                    <span class="text-xs text-on-surface-variant font-mono"><?= e($settings['node_phone'] ?? 'Terhubung (+62 812-9843-XXXX)') ?></span>
                </div>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-low text-on-surface border border-surface-container">
                <span class="material-symbols-outlined text-[14px] text-primary">bolt</span>
                <span class="text-xs font-mono"><?= e($settings['node_uptime'] ?? '99.8% (1.2s avg)') ?></span>
            </div>
        </div>
        <!-- Code Simulation Card -->
        <div class="rounded-lg bg-inverse-surface text-inverse-on-surface p-4 shadow-inner mb-4 overflow-x-auto">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-surface-container-highest/10 text-secondary-fixed-dim text-xs font-mono">
                <div class="flex items-center gap-2">
                    <span class="px-1.5 py-0.5 rounded bg-primary text-white font-mono text-[10px] font-bold">POST</span>
                    <span class="font-mono text-inverse-on-surface">/api/v1/messages</span>
                </div>
                <span class="font-mono text-[11px] text-tertiary-fixed-dim">HTTPS JSON</span>
            </div>
            <pre class="text-xs font-mono leading-relaxed text-surface-container-lowest"><code><span class="text-tertiary-fixed-dim">Authorization:</span> Bearer nwt_live_8f7b...
<span class="text-tertiary-fixed-dim">Content-Type:</span> application/json

{
  <span class="text-primary-fixed-dim">"to"</span>: <span class="text-secondary-fixed">"6281234567890"</span>,
  <span class="text-primary-fixed-dim">"message"</span>: <span class="text-secondary-fixed">"Pesanan #TRX-9482 berhasil dikonfirmasi."</span>
}</code></pre>
        </div>
        <!-- Webhook Receipt Indicator -->
        <div class="flex items-center justify-between px-4 py-3 rounded-lg bg-surface-container-low border border-surface-container">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-primary text-[20px]">verified</span>
                <span class="text-xs text-on-surface font-medium">Pesan terkirim via Webhook</span>
            </div>
            <span class="text-xs text-primary font-mono font-semibold">200 OK • 84ms</span>
        </div>
    </div>
</div>
