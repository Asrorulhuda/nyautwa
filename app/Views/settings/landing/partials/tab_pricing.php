<!-- Pricing / Plans Settings -->
<div class="space-y-6">
    <div class="border-b border-surface-container-high pb-3">
        <h3 class="text-sm font-semibold text-on-surface">Paket Langganan & Fitur Modular</h3>
        <p class="text-xs text-secondary">Atur nama paket, nominal harga, kuota pesan, batas device, masa aktif, dan hak akses fitur per paket.</p>
    </div>

    <?php
    $tiers = [
        ['k' => 'starter', 'def_n' => 'Starter', 'def_p' => 'Rp 149.000', 'def_d' => '2', 'def_q' => '10.000 pesan / bulan', 'dur' => '30', 'pop' => false, 'mods' => ['crm'=>1,'send_message'=>1,'autoreply'=>1,'broadcast'=>0,'api_keys'=>1]],
        ['k' => 'pro', 'def_n' => 'Pro Business', 'def_p' => 'Rp 349.000', 'def_d' => '5', 'def_q' => '50.000 pesan / bulan', 'dur' => '30', 'pop' => true, 'mods' => ['crm'=>1,'send_message'=>1,'autoreply'=>1,'broadcast'=>1,'api_keys'=>1]],
        ['k' => 'biz', 'def_n' => 'Enterprise', 'def_p' => 'Rp 899.000', 'def_d' => '20', 'def_q' => 'Kuota Unlimited', 'dur' => '30', 'pop' => false, 'mods' => ['crm'=>1,'send_message'=>1,'autoreply'=>1,'broadcast'=>1,'api_keys'=>1]],
    ];
    ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <?php foreach ($tiers as $t): 
            $k = $t['k'];
            $pop = $t['pop'];
        ?>
        <div class="p-4 rounded-xl bg-surface-container-low/40 border <?= $pop ? 'border-primary/40 ring-1 ring-primary/20' : 'border-surface-container' ?> space-y-3">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <div class="flex items-center justify-between mb-0.5">
                        <label class="block text-[11px] font-bold <?= $pop ? 'text-primary' : 'text-on-surface' ?>">Nama Paket</label>
                        <?php if ($pop): ?><span class="text-[9px] px-1 py-0.2 rounded bg-primary text-white font-bold">Populer</span><?php endif; ?>
                    </div>
                    <input type="text" name="pricing_<?= $k ?>_name" value="<?= e($settings['pricing_' . $k . '_name'] ?? $t['def_n']) ?>" class="w-full h-8 px-2.5 rounded bg-surface-container-lowest border <?= $pop ? 'border-primary/40 text-primary font-bold' : 'border-outline-variant/40 font-semibold' ?> text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-on-surface mb-0.5">Harga / Periode</label>
                    <input type="text" name="pricing_<?= $k ?>_price" value="<?= e($settings['pricing_' . $k . '_price'] ?? $t['def_p']) ?>" class="w-full h-8 px-2.5 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="block text-[11px] font-medium text-on-surface mb-0.5" title="Durasi Hari">Durasi (Hari)</label>
                    <input type="number" name="pricing_<?= $k ?>_duration_days" value="<?= e($settings['pricing_' . $k . '_duration_days'] ?? $t['dur']) ?>" class="w-full h-8 px-2 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-on-surface mb-0.5">Device</label>
                    <input type="number" name="pricing_<?= $k ?>_devices" value="<?= e($settings['pricing_' . $k . '_devices'] ?? $t['def_d']) ?>" class="w-full h-8 px-2 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-on-surface mb-0.5">Kuota</label>
                    <input type="text" name="pricing_<?= $k ?>_quota" value="<?= e($settings['pricing_' . $k . '_quota'] ?? $t['def_q']) ?>" class="w-full h-8 px-2 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs">
                </div>
            </div>
            <?php require __DIR__ . '/tab_pricing_modules.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Free Trial Setting Row -->
    <div class="p-4 rounded-xl bg-surface-container-low/20 border border-surface-container space-y-3">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h4 class="text-xs font-bold text-on-surface">Paket Free Trial (Uji Coba Pendaftaran)</h4>
                <p class="text-[11px] text-secondary">Alokasi kuota & hak fitur otomatis untuk pendaftar baru.</p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <input type="text" name="pricing_trial_name" placeholder="Nama Paket" value="<?= e($settings['pricing_trial_name'] ?? 'Free Trial') ?>" class="w-28 h-8 px-2.5 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs font-semibold">
                <input type="number" name="pricing_trial_duration_days" placeholder="Hari" value="<?= e($settings['pricing_trial_duration_days'] ?? '7') ?>" class="w-16 h-8 px-2 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs" title="Durasi Hari">
                <input type="text" name="pricing_trial_quota" placeholder="Kuota Uji Coba" value="<?= e($settings['pricing_trial_quota'] ?? '200 Pesan / hari') ?>" class="h-8 px-2.5 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs">
                <input type="number" name="pricing_trial_devices" placeholder="Device" value="<?= e($settings['pricing_trial_devices'] ?? '1') ?>" class="w-16 h-8 px-2 rounded bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
        </div>
        <?php 
        $k = 'trial'; 
        $t = ['mods' => ['crm'=>0,'send_message'=>1,'autoreply'=>0,'broadcast'=>0,'api_keys'=>0]];
        require __DIR__ . '/tab_pricing_modules.php'; 
        ?>
    </div>

    <?php require __DIR__ . '/tab_pricing_reminder.php'; ?>
</div>
