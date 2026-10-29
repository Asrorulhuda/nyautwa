<div class="py-12 md:py-16 bg-[#F6F8F7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="mb-10 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF7F0] text-[#16A36A] text-xs font-semibold mb-3">
                Dukungan Teknis & Kemitraan
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-[#17211F] font-['Geist'] tracking-tight">
                Hubungi Tim Support NyautWa
            </h1>
            <p class="text-sm text-[#697570] mt-2">
                Konsultasikan kebutuhan gateway WhatsApp, bantuan integrasi REST API, atau pertanyaan paket bisnis.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-5 space-y-4">
                <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 shadow-xs">
                    <h3 class="text-sm font-bold text-[#17211F] mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-[#16A36A]">support_agent</span>
                        Saluran Komunikasi Cepat
                    </h3>
                    <div class="space-y-4 text-xs">
                        <?php 
                        $phone = $settings['footer_contact_phone'] ?? '+62 812-3456-7890';
                        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
                        $email = $settings['footer_contact_email'] ?? 'halo@nyautwa.id';
                        $address = $settings['footer_address'] ?? 'Jakarta Selatan, DKI Jakarta, Indonesia';
                        ?>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[18px] text-[#16A36A] mt-0.5">chat</span>
                            <div>
                                <p class="font-semibold text-[#17211F]">WhatsApp Official Support</p>
                                <a href="https://wa.me/<?= e($cleanPhone) ?>" target="_blank" class="text-[#16A36A] font-['JetBrains_Mono'] hover:underline"><?= e($phone) ?></a>
                                <p class="text-[11px] text-[#697570] mt-0.5">Respons cepat untuk kendala teknis.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[18px] text-[#16A36A] mt-0.5">mail</span>
                            <div>
                                <p class="font-semibold text-[#17211F]">Email Bantuan & Bisnis</p>
                                <a href="mailto:<?= e($email) ?>" class="text-[#16A36A] hover:underline"><?= e($email) ?></a>
                                <p class="text-[11px] text-[#697570] mt-0.5">Kemitraan enterprise & faktur pajak.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[18px] text-[#16A36A] mt-0.5">location_on</span>
                            <div>
                                <p class="font-semibold text-[#17211F]">Alamat Kantor</p>
                                <p class="text-[#697570]"><?= e($address) ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[18px] text-[#16A36A] mt-0.5">schedule</span>
                            <div>
                                <p class="font-semibold text-[#17211F]">Jam Layanan Operasional</p>
                                <p class="text-[#697570]">Senin – Minggu (08.00 – 22.00 WIB)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 md:p-8 shadow-xs">
                <h3 class="text-base font-bold text-[#17211F] mb-1 font-['Geist']">Kirim Tiket Bantuan</h3>
                <p class="text-xs text-[#697570] mb-5">Tim teknis kami akan merespons melalui email bisnis Anda.</p>

                <form action="<?= url('/contact') ?>" method="POST" class="space-y-3.5">
                    <?= csrf_field() ?>
                    <div>
                        <label for="name" class="block text-xs font-semibold text-[#17211F] mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required placeholder="Budi Santoso" value="<?= e(old('name')) ?>" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-semibold text-[#17211F] mb-1">Email Bisnis</label>
                        <input type="email" id="email" name="email" required placeholder="budi@perusahaan.com" value="<?= e(old('email')) ?>" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
                    </div>
                    <div>
                        <label for="subject" class="block text-xs font-semibold text-[#17211F] mb-1">Topik Bantuan</label>
                        <select id="subject" name="subject" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
                            <option value="Kendala Teknis & Scan QR">Kendala Teknis & Scan QR Perangkat</option>
                            <option value="Integrasi REST API & Webhook">Integrasi REST API & Webhook</option>
                            <option value="Upgrade Paket & Faktur Langganan">Upgrade Paket & Faktur Langganan</option>
                            <option value="Kemitraan & Pertanyaan Lainnya">Kemitraan & Pertanyaan Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label for="message" class="block text-xs font-semibold text-[#17211F] mb-1">Pesan / Detail Kendala</label>
                        <textarea id="message" name="message" rows="4" required placeholder="Jelaskan pertanyaan atau kendala yang dihadapi secara rinci..." class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]"><?= e(old('message')) ?></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold py-2.5 rounded-md transition-colors shadow-xs">
                        Kirim Pesan ke Tim Support
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
