<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-base font-bold text-on-surface">Tren Pengiriman Pesan Bisnis</h2>
            <p class="text-xs text-secondary mt-0.5">Pantau volume pengiriman pesan WhatsApp hari ini.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-surface-container text-xs font-mono text-secondary">
                <span class="w-2 h-2 rounded-full bg-primary"></span>
                Terkirim: <?= number_format($sent_today, 0, ',', '.') ?>
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-surface-container text-xs font-mono text-secondary">
                <span class="w-2 h-2 rounded-full bg-error"></span>
                Gagal: <?= number_format($failed_today, 0, ',', '.') ?>
            </span>
        </div>
    </div>
    
    <!-- SVG Area Chart -->
    <div class="relative h-56 w-full pt-4">
        <svg class="w-full h-full overflow-visible" viewBox="0 0 700 180" preserveAspectRatio="none">
            <defs>
                <linearGradient id="clientChartGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#16A36A" stop-opacity="0.25"/>
                    <stop offset="100%" stop-color="#16A36A" stop-opacity="0.0"/>
                </linearGradient>
            </defs>
            <line x1="0" y1="40" x2="700" y2="40" stroke="#E4EAE6" stroke-dasharray="3 3"/>
            <line x1="0" y1="90" x2="700" y2="90" stroke="#E4EAE6" stroke-dasharray="3 3"/>
            <line x1="0" y1="140" x2="700" y2="140" stroke="#E4EAE6" stroke-dasharray="3 3"/>

            <path d="M 0,145 Q 120,130 220,110 T 420,80 T 560,50 T 700,35 L 700,180 L 0,180 Z" fill="url(#clientChartGrad)"/>
            <path d="M 0,145 Q 120,130 220,110 T 420,80 T 560,50 T 700,35" fill="none" stroke="#16A36A" stroke-width="2.5" stroke-linecap="round"/>

            <circle cx="220" cy="110" r="4" fill="#FFFFFF" stroke="#16A36A" stroke-width="2"/>
            <circle cx="420" cy="80" r="4" fill="#FFFFFF" stroke="#16A36A" stroke-width="2"/>
            <circle cx="560" cy="50" r="4" fill="#FFFFFF" stroke="#16A36A" stroke-width="2"/>
            <circle cx="700" cy="35" r="5" fill="#16A36A" stroke="#FFFFFF" stroke-width="2"/>
        </svg>
    </div>
    
    <div class="flex justify-between text-[11px] text-secondary font-mono pt-3 border-t border-outline-variant/20 mt-2">
        <span>00:00</span>
        <span>04:00</span>
        <span>08:00</span>
        <span>12:00</span>
        <span>16:00</span>
        <span>20:00</span>
        <span>Sekarang</span>
    </div>
</div>
