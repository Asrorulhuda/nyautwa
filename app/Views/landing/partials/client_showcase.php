<?php
/** @var array $clients */
$clientsList = !empty($clients) ? $clients : [
    ['name' => 'PT Maju Bersama Digital', 'industry' => 'Teknologi & Digital', 'logo' => null],
    ['name' => 'Kopi Nusantara Group', 'industry' => 'Kuliner & F&B', 'logo' => null],
    ['name' => 'Klinik Sehat Medika', 'industry' => 'Kesehatan & Klinik', 'logo' => null],
    ['name' => 'FastPay Finansial', 'industry' => 'Finansial & Fintech', 'logo' => null],
];
?>
<section class="py-16 md:py-20 border-b border-[#E4EAE6] bg-[#FFFFFF]">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF7F0] border border-[#d2efe0] text-[#16A36A] text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-[#16A36A] animate-pulse"></span>
                    Ekosistem Mitra NyautWa
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-[#17211F] tracking-tight font-['Geist']">
                    Bisnis & Pengusaha yang Telah Bergabung
                </h2>
                <p class="text-sm text-[#697570] mt-1.5 max-w-xl">
                    Dipercaya oleh ratusan bisnis di Indonesia untuk otomatisasi notifikasi, CS multi-agen, dan gateway WhatsApp andal.
                </p>
            </div>
            <a href="<?= url('/register') ?>" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md bg-[#F6F8F7] hover:bg-[#EAF7F0] border border-[#E4EAE6] text-xs font-semibold text-[#17211F] hover:text-[#16A36A] transition-colors w-fit">
                <span>Daftarkan Bisnis Anda</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3.5">
            <?php foreach (array_slice($clientsList, 0, 12) as $c): ?>
                <?php 
                $name = $c['name'] ?? 'Mitra Usaha';
                $industry = $c['industry'] ?? 'Bisnis';
                $logo = $c['logo'] ?? null;
                $initial = strtoupper(mb_substr($name, 0, 2));
                ?>
                <div class="group flex flex-col items-center text-center p-4 rounded-xl border border-[#E4EAE6] bg-[#F6F8F7] hover:bg-[#FFFFFF] hover:border-[#16A36A] hover:shadow-xs transition-all duration-200">
                    <div class="w-14 h-14 rounded-xl bg-[#FFFFFF] border border-[#E4EAE6] flex items-center justify-center p-2 mb-3 shadow-2xs group-hover:scale-105 transition-transform overflow-hidden">
                        <?php if (!empty($logo) && file_exists(dirname(__DIR__, 4) . '/public' . $logo)): ?>
                            <img src="<?= url(e($logo)) ?>" alt="<?= e($name) ?>" class="w-full h-full object-contain">
                        <?php else: ?>
                            <div class="w-full h-full rounded-lg bg-[#EAF7F0] text-[#16A36A] font-bold text-xs flex items-center justify-center font-['JetBrains_Mono']">
                                <?= e($initial) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="w-full">
                        <div class="flex items-center justify-center gap-1">
                            <h3 class="text-xs font-bold text-[#17211F] truncate group-hover:text-[#16A36A] transition-colors max-w-[120px]" title="<?= e($name) ?>">
                                <?= e($name) ?>
                            </h3>
                            <span class="material-symbols-outlined text-[13px] text-[#16A36A]" title="Terverifikasi">verified</span>
                        </div>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-[#FFFFFF] border border-[#E4EAE6] text-[#697570] truncate max-w-full">
                            <?= e($industry) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-8 pt-6 border-t border-[#E4EAE6] flex flex-wrap items-center justify-between text-xs text-[#697570] gap-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px] text-[#16A36A]">shield</span>
                <span>Data sesi & percakapan bisnis dienkripsi penuh sesuai standar ISO 27001.</span>
            </div>
            <div class="flex items-center gap-4">
                <span>⚡ Rata-rata respons gateway <strong class="text-[#17211F] font-['JetBrains_Mono']">&lt; 200ms</strong></span>
                <span>🛡️ Perlindungan Anti-Blokir AI 99.8%</span>
            </div>
        </div>
    </div>
</section>
