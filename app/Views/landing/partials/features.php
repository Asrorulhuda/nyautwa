<!-- Product Benefits Section -->
<section class="py-20 lg:py-24 bg-surface-container-lowest scroll-mt-20" id="fitur">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-wider text-amber-700 bg-amber-500/10 px-3 py-1 rounded-full font-mono font-bold mb-3 border border-amber-500/25">EKOSISTEM WA GATEWAY + CRM</span>
            <h2 class="text-3xl font-bold text-on-surface mb-3">Solusi Komunikasi WhatsApp yang Lengkap & Sigap</h2>
            <p class="text-base text-on-surface-variant">Dari pengiriman notifikasi otomatis hingga Live Chat CRM dua arah, semua dirancang agar pesan bisnis langsung nyaut tanpa hambatan.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Benefit 1 -->
            <div class="bg-surface p-6 rounded-xl shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container-high/60">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-surface-container-low flex items-center justify-center text-primary mb-5">
                        <span class="material-symbols-outlined text-[24px]">api</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-2 font-semibold"><?= e($settings['feature_1_title'] ?? 'REST API & Webhook Cepat') ?></h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_1_desc'] ?? 'Kirim notifikasi OTP, broadcast, dan terima callback status delivery (sent, delivered, read) via JSON payload terstruktur.') ?>
                    </p>
                </div>
                <div class="mt-6 pt-3 flex items-center text-primary text-xs font-semibold border-t border-surface-container/60">
                    <span>Dokumentasi Lengkap</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
            <!-- Benefit 2 -->
            <div class="bg-surface p-6 rounded-xl shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between border border-amber-500/30 ring-1 ring-amber-500/10">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-600 mb-5">
                        <span class="material-symbols-outlined text-[24px]">forum</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-2 font-semibold flex items-center gap-1.5">
                        <span><?= e($settings['feature_2_title'] ?? 'Live Chat CRM Pelanggan') ?></span>
                        <span class="text-[9px] bg-amber-500/20 text-amber-800 font-mono font-bold px-1.5 py-0.5 rounded">NEW</span>
                    </h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_2_desc'] ?? 'Interaksi langsung dua arah dengan pelanggan, sinkronisasi buku kontak, filter multi-device, dan tanggapi pesan masuk seketika.') ?>
                    </p>
                </div>
                <div class="mt-6 pt-3 flex items-center text-amber-700 text-xs font-semibold border-t border-surface-container/60">
                    <span>CRM Terintegrasi</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
            <!-- Benefit 3 -->
            <div class="bg-surface p-6 rounded-xl shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container-high/60">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-surface-container-low flex items-center justify-center text-primary mb-5">
                        <span class="material-symbols-outlined text-[24px]">smart_toy</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-2 font-semibold"><?= e($settings['feature_3_title'] ?? 'Auto Reply & Menu Interaktif') ?></h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_3_desc'] ?? 'Balasan otomatis cerdas berbasis kata kunci, navigasi menu angka parent-child, dan import ribuan aturan dari file Excel.') ?>
                    </p>
                </div>
                <div class="mt-6 pt-3 flex items-center text-primary text-xs font-semibold border-t border-surface-container/60">
                    <span>Import Excel Ready</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
            <!-- Benefit 4 -->
            <div class="bg-surface p-6 rounded-xl shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container-high/60">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-surface-container-low flex items-center justify-center text-primary mb-5">
                        <span class="material-symbols-outlined text-[24px]">security</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-2 font-semibold"><?= e($settings['feature_4_title'] ?? 'Anti-Blokir & Multi-Device') ?></h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_4_desc'] ?? 'Algoritma human-like delay acak, batch throttling, dan auto-reconnect failover otomatis untuk menjaga keamanan nomor WhatsApp Anda.') ?>
                    </p>
                </div>
                <div class="mt-6 pt-3 flex items-center text-primary text-xs font-semibold border-t border-surface-container/60">
                    <span>Proteksi Akun Aman</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
        </div>
    </div>
</section>
