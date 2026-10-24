<!-- Comprehensive Footer Section -->
<footer class="bg-surface text-on-surface-variant pt-16 pb-12 border-t border-surface-container-high">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
            <!-- Brand identity -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white shadow-sm">
                        <span class="material-symbols-outlined text-lg">chat</span>
                    </div>
                    <span class="text-xl font-bold text-on-surface">Nyaut<span class="text-primary font-semibold">Wa</span></span>
                </div>
                <p class="text-xs text-on-surface-variant max-w-sm mb-6 leading-relaxed">
                    <?= e($settings['footer_tagline'] ?? 'Infrastruktur WhatsApp Gateway API berkecepatan tinggi untuk kebutuhan notifikasi aplikasi, sistem verifikasi OTP, dan automasi obrolan bisnis.') ?>
                </p>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-container-low text-primary text-xs font-mono border border-surface-container">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    <span>Semua Sistem Operasional</span>
                </div>
            </div>
            <!-- Links column 1 -->
            <div>
                <h4 class="text-xs font-semibold text-on-surface uppercase tracking-wider mb-4">Produk</h4>
                <ul class="space-y-3 text-xs">
                    <li><a class="hover:text-primary transition-colors" href="#fitur">Fitur Platform</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/devices') ?>">Multi-Device Gateway</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/api-keys') ?>">Real-time Webhook</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#harga">Harga & Kuota</a></li>
                </ul>
            </div>
            <!-- Links column 2 -->
            <div>
                <h4 class="text-xs font-semibold text-on-surface uppercase tracking-wider mb-4">Developer</h4>
                <ul class="space-y-3 text-xs">
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/api-keys') ?>">Dokumentasi API</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/dashboard') ?>">Status Server</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#api">Panduan Integrasi</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#api">SDK & Libraries</a></li>
                </ul>
            </div>
            <!-- Links column 3 -->
            <div>
                <h4 class="text-xs font-semibold text-on-surface uppercase tracking-wider mb-4">Legal & Kontak</h4>
                <ul class="space-y-3 text-xs">
                    <li><a class="hover:text-primary transition-colors" href="#">Syarat & Ketentuan</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Kebijakan Privasi</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Jaminan Layanan (SLA)</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Hubungi Support</a></li>
                </ul>
            </div>
        </div>
        <div class="pt-8 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between text-xs text-on-surface-variant gap-4">
            <p>© <?= date('Y') ?> NyautWa. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="flex items-center gap-6 font-mono text-[11px]">
                <span>v2.15.0-webhook-ready</span>
                <span>Infrastruktur Jakarta (IDC 3D)</span>
            </div>
        </div>
    </div>
</footer>
