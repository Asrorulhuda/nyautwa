<!-- Pricing Comparison Section -->
<section class="py-20 lg:py-24 bg-surface" id="harga">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-wider text-primary font-semibold mb-2">Pilihan Paket</span>
            <h2 class="text-3xl font-bold text-on-surface mb-4">Investasi Transparan untuk Skala Bisnis Anda</h2>
            <p class="text-base text-on-surface-variant">Pilih paket yang sesuai dengan volume pengiriman pesan sistem Anda tanpa biaya tersembunyi.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            <!-- Starter Tier -->
            <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-sm flex flex-col justify-between border border-surface-container-high/70 hover:shadow-md transition-shadow">
                <div>
                    <h3 class="text-2xl text-on-surface font-semibold mb-3">Starter</h3>
                    <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Cocok untuk eksplorasi teknis, pembuatan prototipe, dan testing integrasi.</p>
                    <div class="mb-6 pb-6 border-b border-surface-container">
                        <span class="text-4xl text-on-surface font-bold">Rp 99.000</span>
                        <span class="text-xs text-on-surface-variant">/ bulan</span>
                    </div>
                    <ul class="space-y-3.5 mb-8 text-xs text-on-surface">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Hingga 5.000 pesan / bulan</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>1 Koneksi nomor WhatsApp aktif</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Webhooks callback standar</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Community & Forum Support</span></li>
                    </ul>
                </div>
                <a class="w-full inline-flex items-center justify-center py-3 px-4 rounded-lg bg-surface-container text-on-surface text-sm font-semibold hover:bg-surface-container-high transition-colors" href="<?= url('/register?plan=starter') ?>">
                    Mulai Uji Coba
                </a>
            </div>
            <!-- Pro Tier (Popular) -->
            <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-lg relative flex flex-col justify-between ring-2 ring-primary">
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-3.5 py-1 rounded-full bg-primary text-white text-xs font-semibold tracking-wide shadow-sm">
                    Paling Populer
                </div>
                <div>
                    <h3 class="text-2xl text-on-surface font-semibold mb-3">Pro</h3>
                    <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Dirancang untuk bisnis bertumbuh dengan kebutuhan notifikasi rutin transaksi.</p>
                    <div class="mb-6 pb-6 border-b border-surface-container">
                        <span class="text-4xl text-on-surface font-bold">Rp 349.000</span>
                        <span class="text-xs text-on-surface-variant">/ bulan</span>
                    </div>
                    <ul class="space-y-3.5 mb-8 text-xs text-on-surface">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Hingga 50.000 pesan / bulan</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>3 Koneksi nomor WhatsApp simultan</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Priority instant webhooks</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>SLA Uptime 99.9%</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Bantuan teknis WhatsApp & Email</span></li>
                    </ul>
                </div>
                <a class="w-full inline-flex items-center justify-center py-3 px-4 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container shadow transition-all" href="<?= url('/register?plan=pro') ?>">
                    Pilih Paket Pro
                </a>
            </div>
            <!-- Business Tier -->
            <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-sm flex flex-col justify-between border border-surface-container-high/70 hover:shadow-md transition-shadow">
                <div>
                    <h3 class="text-2xl text-on-surface font-semibold mb-3">Business</h3>
                    <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Skala enterprise dengan volume jutaan pesan, keandalan khusus, & SLA.</p>
                    <div class="mb-6 pb-6 border-b border-surface-container">
                        <span class="text-4xl text-on-surface font-bold">Kustom</span>
                        <span class="text-xs text-on-surface-variant">/ disesuaikan</span>
                    </div>
                    <ul class="space-y-3.5 mb-8 text-xs text-on-surface">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Volume pesan kustom tanpa batas</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Unlimited multi-device instances</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Dedicated gateway IP & custom limit</span></li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-[18px]">check</span><span>Dedicated Account Manager 24/7</span></li>
                    </ul>
                </div>
                <a class="w-full inline-flex items-center justify-center py-3 px-4 rounded-lg bg-surface-container text-on-surface text-sm font-semibold hover:bg-surface-container-high transition-colors" href="<?= url('/register?plan=enterprise') ?>">
                    Hubungi Sales
                </a>
            </div>
        </div>
    </div>
</section>
