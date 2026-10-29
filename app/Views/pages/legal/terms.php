<div class="py-12 md:py-16 bg-[#F6F8F7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="mb-10 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF7F0] text-[#16A36A] text-xs font-semibold mb-3">
                Dokumen Legal Resmi
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-[#17211F] font-['Geist'] tracking-tight">
                Syarat & Ketentuan Layanan
            </h1>
            <p class="text-sm text-[#697570] mt-2">
                Terakhir diperbarui: 25 Oktober 2026 • Berlaku untuk seluruh pengguna platform NyautWa
            </p>
        </div>

        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 md:p-10 shadow-xs space-y-8 text-sm text-[#17211F] leading-relaxed">
            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">1</span>
                    Definisi & Ruang Lingkup Layanan
                </h2>
                <p class="text-[#697570]">
                    NyautWa adalah platform software-as-a-service (SaaS) penyedia WhatsApp Gateway dan Live Chat CRM yang memfasilitasi pengiriman notifikasi transaksional, integrasi REST API, dan manajemen percakapan pelanggan bisnis. Layanan ini memanfaatkan protokol multi-device independen.
                </p>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">2</span>
                    Kewajiban & Kebijakan Penggunaan Wajar (AUP)
                </h2>
                <p class="text-[#697570] mb-2">Pengguna dilarang keras memanfaatkan layanan NyautWa untuk:</p>
                <ul class="list-disc pl-5 space-y-1 text-[#697570]">
                    <li>Mengirimkan pesan spam massal tanpa persetujuan eksplisit (opt-in) dari penerima.</li>
                    <li>Aktivitas penipuan (phishing), perjudian online, materi pornografi, atau konten ilegal sesuai UU ITE.</li>
                    <li>Tindakan eksploitasi yang memicu pemblokiran massal nomor telepon oleh pihak penyedia perpesanan.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">3</span>
                    Kuota, Pembayaran, & Langganan
                </h2>
                <p class="text-[#697570]">
                    Layanan ditagihkan berbasis paket bulanan atau tahunan. Penyesuaian kuota pesan harian berlaku otomatis sesuai paket aktif (Starter, Professional, atau Enterprise). Pembayaran diverifikasi otomatis via QRIS dan Virtual Account perbankan nasional.
                </p>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">4</span>
                    Batasan Tanggung Jawab (Disclaimer)
                </h2>
                <p class="text-[#697570]">
                    NyautWa tidak berafiliasi resmi dengan WhatsApp LLC atau Meta Platforms Inc. Risiko penangguhan nomor akibat pengiriman konten spam yang melanggar ketentuan WhatsApp merupakan tanggung jawab penuh pemilik nomor WhatsApp.
                </p>
            </section>

            <div class="pt-6 border-t border-[#E4EAE6] flex flex-col sm:flex-row items-center justify-between text-xs text-[#697570] gap-4">
                <span>Pertanyaan mengenai syarat ketentuan? Hubungi <strong class="text-[#17211F]"><?= e($settings['footer_contact_email'] ?? 'halo@nyautwa.id') ?></strong></span>
                <a href="<?= url('/contact') ?>" class="text-[#16A36A] font-semibold hover:underline">Pusat Bantuan Support →</a>
            </div>
        </div>
    </div>
</div>
