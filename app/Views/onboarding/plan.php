<div class="py-12 md:py-16 bg-[#F6F8F7] min-h-[calc(100vh-64px)]">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EAF7F0] text-[#16A36A] text-xs font-semibold mb-3">
                Langkah 2 dari 2 • Aktivasi Akun Bisnis
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#17211F] font-['Geist'] tracking-tight">
                Pilih Paket Layanan WhatsApp Gateway
            </h1>
            <p class="text-xs sm:text-sm text-[#697570] mt-2 leading-relaxed">
                Halo, <strong><?= e($tenant['name'] ?? 'Mitra') ?></strong>! Pilih paket yang sesuai skala pengiriman pesan bisnis Anda. Kuota & fitur dapat disesuaikan kapan saja.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            <?php foreach ($plans as $p): ?>
                <?php 
                $isCurrent = ($currentPlan ?? 'trial') === $p['id'];
                $isPopular = !empty($p['popular']);
                ?>
                <div class="bg-[#FFFFFF] rounded-2xl p-6 flex flex-col justify-between border <?= $isPopular ? 'border-[#16A36A] shadow-md ring-2 ring-[#16A36A]/20 relative' : 'border-[#E4EAE6] shadow-xs' ?> hover:border-[#16A36A] transition-all">
                    <?php if ($isPopular): ?>
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-[#16A36A] text-white text-[10px] font-bold tracking-wider uppercase font-mono shadow-xs">
                            Paling Populer
                        </div>
                    <?php endif; ?>
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <h3 class="text-lg font-bold text-[#17211F] font-['Geist']"><?= e($p['name']) ?></h3>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-[#F6F8F7] border border-[#E4EAE6] text-[#697570]"><?= e($p['badge']) ?></span>
                        </div>
                        <div class="mb-4 pb-4 border-b border-[#E4EAE6]">
                            <span class="text-2xl lg:text-3xl font-extrabold text-[#17211F] font-['JetBrains_Mono']"><?= e($p['price_label']) ?></span>
                            <span class="text-xs text-[#697570]"><?= e($p['period']) ?></span>
                        </div>
                        <div class="space-y-1.5 text-xs text-[#17211F] mb-6">
                            <div class="font-semibold text-[#16A36A] flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">devices</span>
                                <span><?= e($p['devices']) ?> Perangkat WhatsApp</span>
                            </div>
                            <div class="text-[#697570] flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-amber-600">bolt</span>
                                <span><?= e($p['quota']) ?></span>
                            </div>
                        </div>
                        <ul class="space-y-2 mb-6 text-xs text-[#697570]">
                            <?php foreach ($p['features'] as $f): ?>
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[#16A36A] text-[16px] shrink-0 mt-0.5">check_circle</span>
                                    <span><?= e($f) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <form action="<?= url('/onboarding/plan') ?>" method="POST" class="w-full">
                        <?= csrf_field() ?>
                        <input type="hidden" name="plan_id" value="<?= e($p['id']) ?>">
                        <?php if ($p['price'] > 0): ?>
                        <div class="mb-3">
                            <label class="block text-[10.5px] font-semibold text-[#17211F] mb-1">Pilih Metode Pembayaran:</label>
                            <select name="payment_method_id" class="w-full h-8 px-2 rounded-lg bg-white border border-[#E4EAE6] text-[11px] text-[#17211F] focus:border-[#16A36A]">
                                <?php foreach (($methods ?? []) as $pm): ?>
                                <option value="<?= e($pm['id']) ?>"><?= e($pm['name']) ?> (<?= e($pm['type']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        <button type="submit" class="w-full py-2.5 px-4 rounded-lg text-xs font-semibold transition-all shadow-xs <?= $isPopular ? 'bg-[#16A36A] hover:bg-[#128557] text-white' : 'bg-[#F6F8F7] hover:bg-[#EAF7F0] border border-[#E4EAE6] text-[#17211F] hover:text-[#16A36A]' ?>">
                            <?= $p['price'] <= 0 ? 'Gunakan Free Trial' : 'Pilih ' . e($p['name']) ?>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-10 text-center">
            <a href="<?= url('/dashboard') ?>" class="text-xs text-[#697570] hover:text-[#16A36A] hover:underline font-medium inline-flex items-center gap-1">
                <span>Lewati sementara & langsung masuk ke Dashboard</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
        </div>
    </div>
</div>
