<!-- Product Preview Section (Authentic Dashboard Demonstration) -->
<section class="py-20 lg:py-24 bg-surface">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div class="max-w-2xl">
                <span class="text-xs uppercase tracking-wider text-primary font-semibold mb-2 block">Konsol / Bisnis</span>
                <h2 class="text-3xl font-bold text-on-surface mb-3">Tampilan Dashboard Operasional</h2>
                <p class="text-base text-on-surface-variant">Pantau traffic, kelola koneksi perangkat, dan periksa riwayat transmisi secara real-time dari satu tempat monitor terpadu.</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center gap-2 bg-surface-container-lowest px-3.5 py-1.5 rounded-full border border-surface-container shadow-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse"></span>
                <span class="text-xs text-on-surface-variant font-mono">Live Socket Streaming</span>
            </div>
        </div>
        <!-- Dashboard Mock Frame -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-xl overflow-hidden border border-surface-container-high/80">
            <!-- Top App Bar Mock -->
            <div class="bg-surface-container-high px-6 py-4 flex items-center justify-between border-b border-surface-container-highest/40">
                <div class="flex items-center gap-4">
                    <div class="flex gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-outline-variant/70"></span>
                        <span class="w-3 h-3 rounded-full bg-outline-variant/70"></span>
                        <span class="w-3 h-3 rounded-full bg-outline-variant/70"></span>
                    </div>
                    <div class="h-4 w-px bg-outline-variant/50"></div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant">dns</span>
                        <span class="text-xs font-mono text-on-surface">instance-jkt-04.nyautwa.internal</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded text-[11px] font-mono bg-surface-container-low text-primary font-medium">Baterai: 94%</span>
                    <span class="px-2.5 py-1 rounded text-[11px] font-mono bg-surface-container-low text-primary font-medium">Sinyal: Kuat</span>
                </div>
            </div>
            <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Metric & Sparkline Card -->
                <div class="lg:col-span-4 flex flex-col gap-5">
                    <div class="bg-surface p-5 rounded-xl border border-surface-container-high/60">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-on-surface-variant">Throughput Pesan / Jam</span>
                            <span class="text-xs text-primary font-mono font-semibold">+14.2%</span>
                        </div>
                        <div class="text-3xl font-bold text-on-surface mb-4">4,892 <span class="text-xs text-on-surface-variant font-normal">msg/h</span></div>
                        <svg class="w-full h-16 text-primary" fill="none" preserveaspectratio="none" viewbox="0 0 240 60">
                            <path d="M0 45 L30 38 L60 42 L90 28 L120 32 L150 15 L180 22 L210 8 L240 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                            <path d="M0 45 L30 38 L60 42 L90 28 L120 32 L150 15 L180 22 L210 8 L240 18 L240 60 L0 60 Z" fill="currentColor" fill-opacity="0.08"></path>
                        </svg>
                    </div>
                    <div class="bg-surface p-5 rounded-xl border border-surface-container-high/60 flex flex-col gap-3">
                        <span class="text-xs text-on-surface-variant">Penggunaan Kuota Bulanan</span>
                        <div class="w-full bg-surface-container rounded-full h-2.5 overflow-hidden">
                            <div class="bg-primary h-full rounded-full" style="width: 42%;"></div>
                        </div>
                        <div class="flex justify-between text-xs text-on-surface-variant font-mono">
                            <span>42,120 dikirim</span>
                            <span>100,000 kuota</span>
                        </div>
                    </div>
                </div>
                <!-- Live Log Stream Table -->
                <div class="lg:col-span-8 bg-surface rounded-xl p-5 border border-surface-container-high/60 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-surface-container">
                            <span class="text-sm font-semibold text-on-surface">Live Delivery Log</span>
                            <span class="text-xs text-on-surface-variant font-mono">Auto-refresh: 2s</span>
                        </div>
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left text-xs font-mono">
                                <thead>
                                    <tr class="text-on-surface-variant uppercase tracking-wider border-b border-surface-container/60">
                                        <th class="py-2.5 pr-4 font-medium">Req ID</th>
                                        <th class="py-2.5 px-4 font-medium">Tujuan</th>
                                        <th class="py-2.5 px-4 font-medium">Waktu</th>
                                        <th class="py-2.5 pl-4 text-right font-medium">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container text-[12px]">
                                    <tr><td class="py-2.5 pr-4 font-semibold">#msg_92381a</td><td class="py-2.5 px-4 text-on-surface-variant">+62 813-8821-9921</td><td class="py-2.5 px-4 text-on-surface-variant">14:02:41.112</td><td class="py-2.5 pl-4 text-right"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-surface-container-low text-primary font-semibold text-[11px]"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Terbaca</span></td></tr>
                                    <tr><td class="py-2.5 pr-4 font-semibold">#msg_92381b</td><td class="py-2.5 px-4 text-on-surface-variant">+62 856-1192-3001</td><td class="py-2.5 px-4 text-on-surface-variant">14:02:40.890</td><td class="py-2.5 pl-4 text-right"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-surface-container-low text-primary font-semibold text-[11px]"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Terkirim</span></td></tr>
                                    <tr><td class="py-2.5 pr-4 font-semibold">#msg_92381c</td><td class="py-2.5 px-4 text-on-surface-variant">+62 819-0023-4112</td><td class="py-2.5 px-4 text-on-surface-variant">14:02:39.540</td><td class="py-2.5 pl-4 text-right"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-surface-container text-on-surface-variant font-semibold text-[11px]"><span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Antrean</span></td></tr>
                                    <tr><td class="py-2.5 pr-4 font-semibold">#msg_92381d</td><td class="py-2.5 px-4 text-on-surface-variant">+62 878-5541-0029</td><td class="py-2.5 px-4 text-on-surface-variant">14:02:37.012</td><td class="py-2.5 pl-4 text-right"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-error-container text-on-error-container font-semibold text-[11px]"><span class="w-1.5 h-1.5 rounded-full bg-error"></span> Gagal</span></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
