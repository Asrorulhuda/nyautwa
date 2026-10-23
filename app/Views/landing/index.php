<!-- Hero Section -->
<section class="py-20 md:py-28 px-6 max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#EAF7F0] border border-[#16A36A]/20 rounded-full text-xs font-semibold text-[#16865A] mb-6">
                <span class="w-2 h-2 rounded-full bg-[#16A36A] status-pulse"></span>
                Baileys Engine Multi-Device v1.0 Ready
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#17211F] tracking-tight leading-[1.15] mb-6 font-['Geist']">
                Infrastruktur WhatsApp Gateway untuk Aplikasi & Bisnis Anda.
            </h1>
            <p class="text-base text-[#697570] leading-relaxed mb-8 max-w-xl">
                Kirim notifikasi transaksi, verifikasi OTP, dan integrasi webhook dua arah tanpa biaya per-pesan yang mahal. Mudah diintegrasikan dengan cURL, PHP, Node.js, atau Python dalam waktu kurang dari 5 menit.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="<?= url('/register') ?>" class="bg-[#16A36A] hover:bg-[#128557] text-white text-sm font-semibold px-6 py-3 rounded-md transition-colors shadow-sm inline-flex items-center gap-2">
                    <span>Mulai Uji Coba Gratis</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <a href="<?= url('/login') ?>" class="bg-[#FFFFFF] hover:bg-[#F6F8F7] border border-[#E4EAE6] text-[#17211F] text-sm font-medium px-5 py-3 rounded-md transition-colors inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">terminal</span>
                    Buka Dashboard Demo
                </a>
            </div>
            
            <div class="mt-8 pt-8 border-t border-[#E4EAE6] grid grid-cols-3 gap-6">
                <div>
                    <span class="block text-2xl font-bold text-[#17211F] font-mono tnum">99.4%</span>
                    <span class="text-xs text-[#697570]">Tingkat Kirim Sukses</span>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-[#17211F] font-mono tnum">&lt; 150ms</span>
                    <span class="text-xs text-[#697570]">Rata-rata Latensi Antrean</span>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-[#17211F] font-mono tnum">Multi</span>
                    <span class="text-xs text-[#697570]">Device & Sesi Paralel</span>
                </div>
            </div>
        </div>

        <!-- Terminal Playground Code Preview -->
        <div class="lg:col-span-5">
            <div class="bg-[#17211F] border border-[#28332F] rounded-xl overflow-hidden shadow-xl text-xs font-mono">
                <div class="flex items-center justify-between px-4 py-3 bg-[#131E1A] border-b border-[#28332F]">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#D84B4B]/80 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-[#D99124]/80 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-[#16A36A]/80 inline-block"></span>
                        <span class="text-[#8E9995] text-[11px] ml-2">POST /api/v1/messages</span>
                    </div>
                    <button data-copy="curl -X POST http://localhost:8000/api/v1/messages \
  -H 'Authorization: Bearer nyaut_live_948f2178ad99e120' \
  -H 'Content-Type: application/json' \
  -d '{&quot;phone&quot;: &quot;+6281234567890&quot;, &quot;message&quot;: &quot;Halo dari NyautWa!&quot;}'" class="text-[#8E9995] hover:text-white inline-flex items-center gap-1 text-[11px]">
                        <span class="material-symbols-outlined text-xs">content_copy</span>
                        Salin
                    </button>
                </div>
                <div class="p-4 text-[#E7F4ED] space-y-3 leading-relaxed">
                    <p class="text-[#8E9995]"># Contoh Request Pengiriman Pesan WhatsApp</p>
                    <p class="text-[#62DD9E]">curl <span class="text-white">-X POST</span> https://api.nyautwa.com/v1/messages \</p>
                    <p class="pl-4 text-white">-H <span class="text-[#E7F4ED]">'Authorization: Bearer nyaut_live_...'</span> \</p>
                    <p class="pl-4 text-white">-H <span class="text-[#E7F4ED]">'Content-Type: application/json'</span> \</p>
                    <p class="pl-4 text-white">-d '{</p>
                    <p class="pl-8 text-[#80FAB9]">"phone": <span class="text-white">"+6281234567890"</span>,</p>
                    <p class="pl-8 text-[#80FAB9]">"message": <span class="text-white">"Kode OTP Anda: 849-210"</span>,</p>
                    <p class="pl-8 text-[#80FAB9]">"idempotency_key": <span class="text-white">"req_99214a"</span></p>
                    <p class="pl-4 text-white">}'</p>
                    
                    <div class="mt-4 pt-4 border-t border-[#28332F] text-[11px]">
                        <p class="text-[#8E9995] mb-1"># HTTP 200 OK Response:</p>
                        <p class="text-[#62DD9E]">{ "status": "queued", "id": "msg_8912a", "estimated_delivery": "3s" }</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jujur Soal Risiko Anti-Ban (Sesuai docs/04-ui-ux.md) -->
<section id="risiko" class="py-12 bg-[#FEF6E7] border-y border-[#D99124]/30 px-6">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-[#D99124]/20 text-[#D99124] flex items-center justify-center shrink-0 mt-0.5">
            <span class="material-symbols-outlined text-xl">shield</span>
        </div>
        <div>
            <h3 class="text-base font-bold text-[#17211F] mb-1">Pernyataan Transparansi & Kebijakan Anti-Banned</h3>
            <p class="text-xs text-[#697570] leading-relaxed">
                NyautWa Gateway dibangun di atas engine Baileys (multi-device protokol). Karena WhatsApp tidak merilis API gratis tanpa batas, pengiriman pesan massal spam berisiko terkena pemblokiran nomor oleh sistem AI WhatsApp. NyautWa menyematkan sistem <strong>Jeda Acak (Random Jitter 3–15 detik)</strong>, <strong>Pemanasan Nomor Otomatis (Warm-up Mode)</strong>, dan <strong>Batas Kuota Harian</strong> guna menjaga nomor WhatsApp Anda tetap sehat dan terhindar dari pemblokiran.
            </p>
        </div>
    </div>
</section>

<!-- Paket Harga Transparan -->
<section id="harga" class="py-20 px-6 max-w-6xl mx-auto">
    <div class="text-center max-w-xl mx-auto mb-16">
        <h2 class="text-3xl font-bold text-[#17211F] tracking-tight mb-3">Paket Langganan Transparan</h2>
        <p class="text-sm text-[#697570]">Tanpa biaya tersembunyi per pesan. Kuota terhubung langsung ke batas aman pengiriman harian.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Starter Plan -->
        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-8 flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-[#697570] uppercase tracking-wider block mb-2">Starter</span>
                <div class="flex items-baseline gap-1 mb-4">
                    <span class="text-3xl font-extrabold text-[#17211F] font-mono">Rp 99.000</span>
                    <span class="text-xs text-[#697570]">/ bulan</span>
                </div>
                <p class="text-xs text-[#697570] mb-6">Cocok untuk toko online dan developer pemula yang membutuhkan notifikasi order.</p>

                <ul class="space-y-3 text-xs text-[#17211F] mb-8">
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span><strong>1 Nomor WhatsApp</strong> Terhubung</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Hingga <strong>1.000 pesan / hari</strong></span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>REST API & Webhook Masuk</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Mode Pemanasan Anti-Ban</span>
                    </li>
                </ul>
            </div>

            <a href="<?= url('/register?plan=starter') ?>" class="w-full text-center bg-[#F6F8F7] hover:bg-[#EAF7F0] hover:text-[#16865A] text-[#17211F] border border-[#E4EAE6] text-xs font-semibold py-2.5 rounded-md transition-colors block">
                Pilih Starter
            </a>
        </div>

        <!-- Pro Plan (Recommended) -->
        <div class="bg-[#FFFFFF] border-2 border-[#16A36A] rounded-xl p-8 flex flex-col justify-between relative shadow-sm">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#16A36A] text-white text-[11px] font-bold px-3 py-0.5 rounded-full uppercase tracking-wider">
                Paling Diminati
            </div>
            <div>
                <span class="text-xs font-semibold text-[#16865A] uppercase tracking-wider block mb-2">Professional</span>
                <div class="flex items-baseline gap-1 mb-4">
                    <span class="text-3xl font-extrabold text-[#17211F] font-mono">Rp 249.000</span>
                    <span class="text-xs text-[#697570]">/ bulan</span>
                </div>
                <p class="text-xs text-[#697570] mb-6">Untuk SaaS, platform kursus, atau toko berskala menengah dengan multi-admin.</p>

                <ul class="space-y-3 text-xs text-[#17211F] mb-8">
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span><strong>5 Nomor WhatsApp</strong> Simultan</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Hingga <strong>10.000 pesan / hari</strong></span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Rotasi Device & Failover Antrean</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Webhook dengan Retry Otomatis</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Prioritas Bandwidth Engine</span>
                    </li>
                </ul>
            </div>

            <a href="<?= url('/register?plan=pro') ?>" class="w-full text-center bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold py-2.5 rounded-md transition-colors block shadow-xs">
                Mulai Uji Coba Pro
            </a>
        </div>

        <!-- Enterprise Plan -->
        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-8 flex flex-col justify-between">
            <div>
                <span class="text-xs font-semibold text-[#697570] uppercase tracking-wider block mb-2">Enterprise</span>
                <div class="flex items-baseline gap-1 mb-4">
                    <span class="text-3xl font-extrabold text-[#17211F] font-mono">Rp 799.000</span>
                    <span class="text-xs text-[#697570]">/ bulan</span>
                </div>
                <p class="text-xs text-[#697570] mb-6">Kapasitas tinggi untuk ERP, CRM perbankan mikro, dan instansi dengan volume besar.</p>

                <ul class="space-y-3 text-xs text-[#17211F] mb-8">
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span><strong>20 Nomor WhatsApp</strong> Dedicated</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Hingga <strong>50.000 pesan / hari</strong></span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Server Node.js Baileys Terisolasi</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#16865A] text-sm">check</span>
                        <span>Dukungan Teknis Langsung via WA</span>
                    </li>
                </ul>
            </div>

            <a href="<?= url('/register?plan=enterprise') ?>" class="w-full text-center bg-[#F6F8F7] hover:bg-[#EAF7F0] hover:text-[#16865A] text-[#17211F] border border-[#E4EAE6] text-xs font-semibold py-2.5 rounded-md transition-colors block">
                Pilih Enterprise
            </a>
        </div>
    </div>
</section>
