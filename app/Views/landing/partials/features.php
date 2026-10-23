<!-- Product Benefits Section -->
<section class="py-20 lg:py-24 bg-surface-container-lowest scroll-mt-20" id="fitur">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-wider text-primary font-semibold mb-2">Keandalan Utama</span>
            <h2 class="text-3xl font-bold text-on-surface mb-4">Infrastruktur Pesan yang Andal & Terukur</h2>
            <p class="text-base text-on-surface-variant">Arsitektur gateway dirancang khusus untuk memastikan skalabilitas tinggi, keamanan komunikasi, dan fleksibilitas integrasi.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Benefit 1 -->
            <div class="bg-surface p-7 rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container-high/60">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined text-[24px]">code</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-3 font-semibold"><?= e($settings['feature_1_title'] ?? 'Integrasi API yang sederhana') ?></h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_1_desc'] ?? 'REST API standar dengan dokumentasi interaktif, SDK, dan contoh kode curl, Node.js, Python, & PHP.') ?>
                    </p>
                </div>
                <div class="mt-8 pt-4 flex items-center text-primary text-xs font-semibold border-t border-surface-container/60">
                    <span>SDK Siap Pakai</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
            <!-- Benefit 2 -->
            <div class="bg-surface p-7 rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container-high/60">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined text-[24px]">done_all</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-3 font-semibold"><?= e($settings['feature_2_title'] ?? 'Pantau status pengiriman pesan') ?></h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_2_desc'] ?? 'Real-time webhook delivery callback untuk status pending, sent, delivered, dan read tanpa polling manual.') ?>
                    </p>
                </div>
                <div class="mt-8 pt-4 flex items-center text-primary text-xs font-semibold border-t border-surface-container/60">
                    <span>Event Streaming</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
            <!-- Benefit 3 -->
            <div class="bg-surface p-7 rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container-high/60">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined text-[24px]">smartphone</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-3 font-semibold"><?= e($settings['feature_3_title'] ?? 'Kelola koneksi WhatsApp') ?></h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_3_desc'] ?? 'Multi-device session manager dengan instant QR code pairing dan auto-reconnect failover otomatis.') ?>
                    </p>
                </div>
                <div class="mt-8 pt-4 flex items-center text-primary text-xs font-semibold border-t border-surface-container/60">
                    <span>Auto Re-connect</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
            <!-- Benefit 4 -->
            <div class="bg-surface p-7 rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-surface-container-high/60">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined text-[24px]">security</span>
                    </div>
                    <h3 class="text-base text-on-surface mb-3 font-semibold"><?= e($settings['feature_4_title'] ?? 'Anti-blokir & rate limit cerdas') ?></h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        <?= e($settings['feature_4_desc'] ?? 'Algoritma antrean pesan dengan dynamic delay acak dan proteksi lonjakan trafik untuk menjaga keamanan nomor.') ?>
                    </p>
                </div>
                <div class="mt-8 pt-4 flex items-center text-primary text-xs font-semibold border-t border-surface-container/60">
                    <span>Audit Trail 30 Hari</span>
                    <span class="material-symbols-outlined text-[16px] ml-1">chevron_right</span>
                </div>
            </div>
        </div>
    </div>
</section>
