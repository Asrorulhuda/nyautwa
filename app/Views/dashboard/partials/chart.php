<!-- Message Activity Chart Card -->
<div class="p-6 rounded-xl bg-surface-container-lowest shadow-xs flex flex-col border border-surface-container-high/60">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
        <div>
            <h2 class="text-base font-semibold text-on-surface">Tren Pengiriman Pesan (Harian)</h2>
            <p class="text-xs text-secondary">Distribusi volume pesan berhasil dan gagal selama 7 hari kalender</p>
        </div>
        <div class="flex items-center gap-4">
            <!-- Legend -->
            <div class="flex items-center gap-3 text-xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-xs bg-primary"></span>
                    <span>Berhasil</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-xs bg-error"></span>
                    <span>Gagal</span>
                </div>
            </div>
            <!-- Granularity Pill Toggles -->
            <div class="inline-flex p-0.5 rounded-lg bg-surface-container text-xs">
                <button class="px-2.5 py-1 text-secondary hover:text-on-surface rounded-md transition-colors" type="button">Per Jam</button>
                <button class="px-2.5 py-1 bg-surface-container-lowest text-primary font-semibold rounded-md shadow-xs" type="button">Harian</button>
                <button class="px-2.5 py-1 text-secondary hover:text-on-surface rounded-md transition-colors" type="button">Mingguan</button>
            </div>
        </div>
    </div>
    <!-- SVG Interactive Bar Visualization -->
    <div class="relative w-full h-56 pt-4">
        <div class="absolute inset-x-0 inset-y-4 flex flex-col justify-between pointer-events-none opacity-40">
            <div class="h-px bg-surface-container-highest w-full flex items-center justify-end"><span class="font-mono text-[10px] text-secondary pr-2">10k</span></div>
            <div class="h-px bg-surface-container-highest w-full flex items-center justify-end"><span class="font-mono text-[10px] text-secondary pr-2">7.5k</span></div>
            <div class="h-px bg-surface-container-highest w-full flex items-center justify-end"><span class="font-mono text-[10px] text-secondary pr-2">5k</span></div>
            <div class="h-px bg-surface-container-highest w-full flex items-center justify-end"><span class="font-mono text-[10px] text-secondary pr-2">2.5k</span></div>
            <div class="h-px bg-surface-container-highest w-full flex items-center justify-end"><span class="font-mono text-[10px] text-secondary pr-2">0</span></div>
        </div>
        <svg class="w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 700 200">
            <defs>
                <linearGradient id="barGrad" x1="0%" x2="0%" y1="0%" y2="100%">
                    <stop offset="0%" stop-color="#008655"></stop>
                    <stop offset="100%" stop-color="#006a42"></stop>
                </linearGradient>
            </defs>
            <g class="group cursor-pointer">
                <rect class="transition-opacity group-hover:opacity-85" fill="url(#barGrad)" height="120" rx="3" width="36" x="40" y="70"></rect>
                <rect fill="#ba1a1a" height="5" rx="1.5" width="36" x="40" y="65"></rect>
                <text class="text-[11px] fill-current text-secondary" text-anchor="middle" x="58" y="212">Sen (19)</text>
            </g>
            <g class="group cursor-pointer">
                <rect class="transition-opacity group-hover:opacity-85" fill="url(#barGrad)" height="146" rx="3" width="36" x="135" y="44"></rect>
                <rect fill="#ba1a1a" height="4" rx="1.5" width="36" x="135" y="40"></rect>
                <text class="text-[11px] fill-current text-secondary" text-anchor="middle" x="153" y="212">Sel (20)</text>
            </g>
            <g class="group cursor-pointer">
                <rect class="transition-opacity group-hover:opacity-85" fill="url(#barGrad)" height="174" rx="3" width="36" x="230" y="16"></rect>
                <rect fill="#ba1a1a" height="6" rx="1.5" width="36" x="230" y="10"></rect>
                <text class="text-[11px] fill-current text-secondary" text-anchor="middle" x="248" y="212">Rab (21)</text>
            </g>
            <g class="group cursor-pointer">
                <rect class="transition-opacity group-hover:opacity-85" fill="url(#barGrad)" height="158" rx="3" width="36" x="325" y="32"></rect>
                <rect fill="#ba1a1a" height="4" rx="1.5" width="36" x="325" y="28"></rect>
                <text class="text-[11px] fill-current text-secondary" text-anchor="middle" x="343" y="212">Kam (22)</text>
            </g>
            <g class="group cursor-pointer">
                <rect class="transition-opacity group-hover:opacity-85" fill="url(#barGrad)" height="182" rx="3" width="36" x="420" y="8"></rect>
                <rect fill="#ba1a1a" height="6" rx="1.5" width="36" x="420" y="2"></rect>
                <text class="text-[11px] fill-current text-secondary font-semibold" text-anchor="middle" x="438" y="212">Jum (23)</text>
            </g>
            <g class="group cursor-pointer">
                <rect class="transition-opacity group-hover:opacity-85" fill="url(#barGrad)" height="142" rx="3" width="36" x="515" y="48"></rect>
                <rect fill="#ba1a1a" height="4" rx="1.5" width="36" x="515" y="44"></rect>
                <text class="text-[11px] fill-current text-secondary" text-anchor="middle" x="533" y="212">Sab (24)</text>
            </g>
            <g class="group cursor-pointer">
                <rect class="transition-opacity group-hover:opacity-85" fill="url(#barGrad)" height="130" rx="3" width="36" x="610" y="60"></rect>
                <rect fill="#ba1a1a" height="3" rx="1.5" width="36" x="610" y="57"></rect>
                <text class="text-[11px] fill-current text-secondary" text-anchor="middle" x="628" y="212">Min (25)</text>
            </g>
        </svg>
    </div>
    <div class="mt-6 pt-3 grid grid-cols-3 gap-2 bg-surface-container-low/60 p-3 rounded-lg text-xs">
        <div><span class="text-secondary block">Puncak Tertinggi (Jumat)</span><span class="font-semibold text-on-surface">9.830 pesan</span></div>
        <div><span class="text-secondary block">Rata-rata Harian</span><span class="font-semibold text-on-surface">6.988 pesan/hari</span></div>
        <div><span class="text-secondary block">Error Terbanyak</span><span class="font-semibold text-error">WhatsApp 400 Bad Num</span></div>
    </div>
</div>
