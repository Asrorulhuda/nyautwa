<div class="py-12 md:py-16 bg-[#F6F8F7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="mb-10 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF7F0] text-[#16A36A] text-xs font-semibold mb-3">
                Keamanan & Perlindungan Privasi
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-[#17211F] font-['Geist'] tracking-tight">
                Kebijakan Privasi
            </h1>
            <p class="text-sm text-[#697570] mt-2">
                Kepatuhan UU Perlindungan Data Pribadi (UU PDP No. 27/2022) • Enkripsi End-to-End
            </p>
        </div>

        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 md:p-10 shadow-xs space-y-8 text-sm text-[#17211F] leading-relaxed">
            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">1</span>
                    Data yang Kami Kumpulkan
                </h2>
                <p class="text-[#697570] mb-2">Saat menggunakan platform NyautWa, kami memproses data terbatas yang diperlukan:</p>
                <ul class="list-disc pl-5 space-y-1 text-[#697570]">
                    <li>Informasi akun tenant: Nama bisnis, logo usaha, alamat email, dan credential login terenkripsi.</li>
                    <li>Metadata sesi WhatsApp: Identitas perangkat (JID), status koneksi real-time, dan log pengiriman pesan (timestamp & status delivery).</li>
                    <li>Kami <strong>tidak pernah menjual atau menyewakan</strong> data kontak nomor pelanggan Anda ke pihak ketiga manapun.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">2</span>
                    Enkripsi & Keamanan Sesi WhatsApp
                </h2>
                <p class="text-[#697570]">
                    Semua session token WhatsApp yang dibuat melalui scan QR dienkripsi menggunakan protokol cipher AES-256 pada level internal engine. Komunikasi antar backend PHP dan engine Baileys terlindungi dengan shared secret header bertingkat di jaringan private lokal.
                </p>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">3</span>
                    Penyimpanan & Retensi Log Percakapan
                </h2>
                <p class="text-[#697570]">
                    Log pesan outbox dan pesan masuk pada Live Chat CRM disimpan secara aman di database tenant Anda. Pengguna memiliki kontrol penuh untuk mengekspor atau menghapus riwayat chat dan kontak kapan saja melalui dashboard admin.
                </p>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">4</span>
                    Hak Pengguna atas Data
                </h2>
                <p class="text-[#697570]">
                    Sesuai undang-undang PDP, Anda berhak meminta salinan data akun, memperbarui informasi profil usaha, atau meminta penghapusan akun beserta seluruh sesi perangkat terhubung secara permanen.
                </p>
            </section>

            <div class="pt-6 border-t border-[#E4EAE6] flex flex-col sm:flex-row items-center justify-between text-xs text-[#697570] gap-4">
                <span>Keluhan privasi? Email kami di <strong class="text-[#17211F]"><?= e($settings['footer_contact_email'] ?? 'halo@nyautwa.id') ?></strong></span>
                <a href="<?= url('/terms') ?>" class="text-[#16A36A] font-semibold hover:underline">Syarat & Ketentuan →</a>
            </div>
        </div>
    </div>
</div>
