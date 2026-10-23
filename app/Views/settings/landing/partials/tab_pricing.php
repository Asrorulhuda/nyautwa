<!-- Pricing / Plans Settings -->
<div class="space-y-6">
    <div class="border-b border-surface-container-high pb-3">
        <h3 class="text-sm font-semibold text-on-surface">Paket Langganan & Harga</h3>
        <p class="text-xs text-secondary">Atur nominal harga dan alokasi kuota pesan bulanan untuk tiap tingkatan paket.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Tier Starter -->
        <div class="p-5 rounded-xl bg-surface-container-low/40 border border-surface-container space-y-3">
            <span class="text-xs font-bold text-on-surface uppercase tracking-wider">Paket Starter</span>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Harga Bulanan</label>
                <input type="text" name="pricing_starter_price" value="<?= e($settings['pricing_starter_price'] ?? 'Rp 149.000') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Alokasi Kuota Pesan</label>
                <input type="text" name="pricing_starter_quota" value="<?= e($settings['pricing_starter_quota'] ?? '10.000 pesan / bulan') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
        </div>
        <!-- Tier Pro -->
        <div class="p-5 rounded-xl bg-surface-container-low/40 border border-primary/30 ring-1 ring-primary/20 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-primary uppercase tracking-wider">Paket Pro</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-primary text-white font-medium">Populer</span>
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Harga Bulanan</label>
                <input type="text" name="pricing_pro_price" value="<?= e($settings['pricing_pro_price'] ?? 'Rp 349.000') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Alokasi Kuota Pesan</label>
                <input type="text" name="pricing_pro_quota" value="<?= e($settings['pricing_pro_quota'] ?? '50.000 pesan / bulan') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
        </div>
        <!-- Tier Business -->
        <div class="p-5 rounded-xl bg-surface-container-low/40 border border-surface-container space-y-3">
            <span class="text-xs font-bold text-on-surface uppercase tracking-wider">Paket Business</span>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Harga Bulanan</label>
                <input type="text" name="pricing_biz_price" value="<?= e($settings['pricing_biz_price'] ?? 'Rp 899.000') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block text-xs font-medium text-on-surface mb-1">Alokasi Kuota Pesan</label>
                <input type="text" name="pricing_biz_quota" value="<?= e($settings['pricing_biz_quota'] ?? 'Kuota Unlimited') ?>" class="w-full h-9 px-3 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs">
            </div>
        </div>
    </div>
</div>
