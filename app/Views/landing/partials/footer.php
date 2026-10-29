<!-- Comprehensive Footer Section -->
<footer class="bg-surface text-on-surface-variant pt-16 pb-12 border-t border-surface-container-high">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 mb-12">
            <!-- Brand identity -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="<?= url('/assets/images/logo.png') ?>" alt="NyautWa Logo" class="h-11 w-11 object-contain drop-shadow-xs">
                    <div class="flex flex-col">
                        <span class="text-xl font-black text-on-surface leading-tight">Nyaut<span class="text-primary font-bold">Wa</span></span>
                        <span class="text-[10px] text-amber-600 font-mono font-bold tracking-wider">WA GATEWAY + CRM • by asr_production</span>
                    </div>
                </div>
                <p class="text-xs text-on-surface-variant max-w-sm mb-4 leading-relaxed">
                    <?= e($settings['footer_tagline'] ?? 'WhatsApp Gateway berkecepatan tinggi & Live Chat CRM Pelanggan. Pesan masuk langsung nyaut, komunikasi bisnis makin lancar dan loyal.') ?>
                </p>
                <div class="space-y-1.5 text-xs text-secondary mb-4">
                    <?php if (!empty($settings['footer_contact_phone'])): ?>
                        <?php $cleanPhone = preg_replace('/[^0-9]/', '', $settings['footer_contact_phone']); ?>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[15px] text-primary">chat</span>
                            <a href="https://wa.me/<?= e($cleanPhone) ?>" target="_blank" class="font-mono hover:text-primary transition-colors"><?= e($settings['footer_contact_phone']) ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($settings['footer_contact_email'])): ?>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[15px] text-primary">mail</span>
                            <a href="mailto:<?= e($settings['footer_contact_email']) ?>" class="hover:text-primary transition-colors"><?= e($settings['footer_contact_email']) ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($settings['footer_address'])): ?>
                        <div class="flex items-start gap-2 text-[11px]">
                            <span class="material-symbols-outlined text-[15px] text-primary mt-0.5">location_on</span>
                            <span><?= e($settings['footer_address']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
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
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/terms') ?>">Syarat & Ketentuan</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/privacy') ?>">Kebijakan Privasi</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/sla') ?>">Jaminan Layanan (SLA)</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= url('/contact') ?>">Hubungi Support</a></li>
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
