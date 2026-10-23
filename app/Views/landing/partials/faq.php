<!-- FAQ Section (Interactive Accordion) -->
<section class="py-20 lg:py-24 bg-surface-container-lowest scroll-mt-20" id="faq">
    <div class="max-w-4xl mx-auto px-6 md:px-12">
        <div class="flex flex-col items-center text-center mb-14">
            <span class="text-xs uppercase tracking-wider text-primary font-semibold mb-2">Pertanyaan Umum</span>
            <h2 class="text-3xl font-bold text-on-surface">Jawaban untuk Pertanyaan Anda</h2>
        </div>
        <div class="space-y-4" id="faq-accordion">
            <div class="rounded-xl bg-surface shadow-sm overflow-hidden border border-surface-container-high/60">
                <button class="faq-toggle w-full px-6 py-5 flex items-center justify-between text-left text-base text-on-surface font-medium hover:text-primary transition-colors">
                    <span><?= e($settings['faq_1_q'] ?? 'Apa itu NyautWa?') ?></span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                </button>
                <div class="faq-content px-6 pb-5 text-on-surface-variant text-sm leading-relaxed border-t border-surface-container/50 pt-3">
                    <?= e($settings['faq_1_a'] ?? 'NyautWa adalah platform WhatsApp Gateway API yang memungkinkan developer dan pemilik bisnis mengintegrasikan pengiriman pesan, notifikasi otomatis, dan penerimaan webhook dari aplikasi mereka langsung ke pengguna WhatsApp secara efisien dan andal.') ?>
                </div>
            </div>
            <div class="rounded-xl bg-surface shadow-sm overflow-hidden border border-surface-container-high/60">
                <button class="faq-toggle w-full px-6 py-5 flex items-center justify-between text-left text-base text-on-surface font-medium hover:text-primary transition-colors">
                    <span><?= e($settings['faq_2_q'] ?? 'Apakah mendukung multi-device dan multi-nomor WhatsApp?') ?></span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-on-surface-variant text-sm leading-relaxed border-t border-surface-container/50 pt-3">
                    <?= e($settings['faq_2_a'] ?? 'Ya, paket Pro dan Business mendukung pengelolaan multi-device untuk nomor CS, notifikasi transaksi, dan marketing terpisah.') ?>
                </div>
            </div>
            <div class="rounded-xl bg-surface shadow-sm overflow-hidden border border-surface-container-high/60">
                <button class="faq-toggle w-full px-6 py-5 flex items-center justify-between text-left text-base text-on-surface font-medium hover:text-primary transition-colors">
                    <span><?= e($settings['faq_3_q'] ?? 'Bagaimana sistem mencegah nomor WhatsApp terblokir (Anti-Ban)?') ?></span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-on-surface-variant text-sm leading-relaxed border-t border-surface-container/50 pt-3">
                    <?= e($settings['faq_3_a'] ?? 'NyautWa menerapkan human-like delay acak, batch throttling otomatis, dan rekomendasi rotasi nomor.') ?>
                </div>
            </div>
            <div class="rounded-xl bg-surface shadow-sm overflow-hidden border border-surface-container-high/60">
                <button class="faq-toggle w-full px-6 py-5 flex items-center justify-between text-left text-base text-on-surface font-medium hover:text-primary transition-colors">
                    <span>Bagaimana cara memantau status pesan?</span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-on-surface-variant text-sm leading-relaxed border-t border-surface-container/50 pt-3">
                    Setiap kali status pesan berubah (dikirim, terkirim ke server, dibaca), server NyautWa akan menembakkan payload Webhook secara real-time ke URL callback yang Anda daftarkan di dashboard. Anda juga dapat memantaunya di tabel Live Log pada dashboard.
                </div>
            </div>
            <div class="rounded-xl bg-surface shadow-sm overflow-hidden border border-surface-container-high/60">
                <button class="faq-toggle w-full px-6 py-5 flex items-center justify-between text-left text-base text-on-surface font-medium hover:text-primary transition-colors">
                    <span>Bagaimana sistem paket dan batas penggunaan bekerja?</span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_more</span>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-on-surface-variant text-sm leading-relaxed border-t border-surface-container/50 pt-3">
                    Setiap paket memiliki alokasi kuota pesan bulanan dan batas jumlah nomor yang dapat terhubung bersamaan. Jika kuota Anda mendekati batas, sistem memberikan peringatan dan Anda dapat melakukan penyesuaian paket sewaktu-waktu tanpa gangguan layanan.
                </div>
            </div>
        </div>
    </div>
</section>
