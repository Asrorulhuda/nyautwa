<div class="py-12 md:py-16 bg-[#F6F8F7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="mb-10 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF7F0] text-[#16A36A] text-xs font-semibold mb-3">
                Service Level Agreement (SLA)
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-[#17211F] font-['Geist'] tracking-tight">
                Jaminan Ketersediaan Layanan
            </h1>
            <p class="text-sm text-[#697570] mt-2">
                Komitmen keandalan operasional, latensi gateway, dan SLA dukungan teknis NyautWa
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 text-center">
                <span class="text-3xl font-bold text-[#16A36A] font-['JetBrains_Mono']">99.9%</span>
                <p class="text-xs font-semibold text-[#17211F] mt-1">Target Uptime Tahunan</p>
                <p class="text-[11px] text-[#697570] mt-0.5">Infrastruktur cloud multi-zona</p>
            </div>
            <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 text-center">
                <span class="text-3xl font-bold text-[#17211F] font-['JetBrains_Mono']">&lt; 200ms</span>
                <p class="text-xs font-semibold text-[#17211F] mt-1">Latensi Eksekusi API</p>
                <p class="text-[11px] text-[#697570] mt-0.5">Pemrosesan antrean asinkron</p>
            </div>
            <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 text-center">
                <span class="text-3xl font-bold text-[#D99124] font-['JetBrains_Mono']">&lt; 15 Mnt</span>
                <p class="text-xs font-semibold text-[#17211F] mt-1">Waktu Respons Insiden</p>
                <p class="text-[11px] text-[#697570] mt-0.5">Tiket darurat prioritas kritis</p>
            </div>
        </div>

        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 md:p-10 shadow-xs space-y-7 text-sm text-[#17211F] leading-relaxed">
            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">1</span>
                    Cakupan Jaminan Uptime Platform
                </h2>
                <p class="text-[#697570]">
                    NyautWa berkomitmen menyediakan ketersediaan API Gateway minimal 99.9% per bulan kalender. Uptime dihitung berdasarkan kemampuan sistem menerima permintaan REST API dan memproses antrean pesan ke gateway.
                </p>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">2</span>
                    Tingkat Urgensi Dukungan (Severity Levels)
                </h2>
                <div class="space-y-2 mt-3 text-xs">
                    <div class="p-3 rounded-lg bg-[#FDF0F0] border border-[#f5c6c6] text-[#17211F]">
                        <strong class="text-[#D84B4B]">Tingkat 1 — Kritis (Downtime Total):</strong> Respons maksimal 15 menit, perbaikan berkelanjutan hingga pulih.
                    </div>
                    <div class="p-3 rounded-lg bg-[#FEF6E7] border border-[#fae2b8] text-[#17211F]">
                        <strong class="text-[#D99124]">Tingkat 2 — Degradasi Layanan:</strong> Respons maksimal 2 jam kerja untuk kendala latensi atau sinkronisasi webhook.
                    </div>
                    <div class="p-3 rounded-lg bg-[#F6F8F7] border border-[#E4EAE6] text-[#17211F]">
                        <strong class="text-[#697570]">Tingkat 3 — Bantuan Umum & Konsultasi:</strong> Respons dalam 1x24 jam kerja melalui sistem tiket atau WhatsApp resmi.
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-base font-bold text-[#17211F] mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center text-xs font-bold font-['JetBrains_Mono']">3</span>
                    Kompensasi Layanan (Service Credit)
                </h2>
                <p class="text-[#697570]">
                    Apabila uptime bulanan berada di bawah komitmen 99.9% di luar pemeliharaan terjadwal, tenant berhak memperoleh penambahan kuota aktif atau perpanjangan masa aktif langganan gratis hingga 20% dari nilai tagihan bulanan terkait.
                </p>
            </section>

            <div class="pt-6 border-t border-[#E4EAE6] flex flex-col sm:flex-row items-center justify-between text-xs text-[#697570] gap-4">
                <span>Pantau operasional sistem real-time di status.nyautwa.com</span>
                <a href="<?= url('/contact') ?>" class="text-[#16A36A] font-semibold hover:underline">Hubungi Tim Layanan Pelanggan →</a>
            </div>
        </div>
    </div>
</div>
