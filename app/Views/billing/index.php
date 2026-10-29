<div class="flex flex-col w-full space-y-6">
    <!-- Top Action Ribbon -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-5 rounded-2xl bg-white border border-[#E4EAE6] shadow-xs">
        <div>
            <h1 class="text-lg font-bold text-[#17211F] tracking-tight">Billing & Pembayaran</h1>
            <p class="text-xs text-[#697570] mt-0.5">Kelola riwayat invoice klien, status pembayaran langganan, dan metode transfer bank/e-wallet.</p>
        </div>
        <div class="flex items-center gap-2">
            <?php if ($tab === 'methods'): ?>
            <button onclick="openMethodModal()" type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold shadow-xs transition-colors">
                <span class="material-symbols-outlined text-[17px]">add_circle</span> Tambah Rekening
            </button>
            <?php else: ?>
            <button onclick="openModal('modal-create-invoice')" type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold shadow-xs transition-colors">
                <span class="material-symbols-outlined text-[17px]">post_add</span> Buat Invoice Manual
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-[#E4EAE6] pb-1">
        <a href="<?= url('/billing?tab=invoices') ?>" class="px-4 py-2 rounded-lg text-xs font-semibold transition-colors flex items-center gap-2 <?= $tab !== 'methods' ? 'bg-[#EAF7F0] text-[#16A36A]' : 'text-[#697570] hover:text-[#17211F]' ?>">
            <span class="material-symbols-outlined text-[18px]">receipt_long</span> Tagihan & Invoice Klien
        </a>
        <a href="<?= url('/billing?tab=methods') ?>" class="px-4 py-2 rounded-lg text-xs font-semibold transition-colors flex items-center gap-2 <?= $tab === 'methods' ? 'bg-[#EAF7F0] text-[#16A36A]' : 'text-[#697570] hover:text-[#17211F]' ?>">
            <span class="material-symbols-outlined text-[18px]">account_balance_wallet</span> Pengaturan Metode Pembayaran
        </a>
    </div>

    <!-- Tab Content -->
    <div class="p-6 rounded-2xl bg-white shadow-xs border border-[#E4EAE6]">
        <?php if ($tab === 'methods'): ?>
            <?php require __DIR__ . '/partials/tab_methods.php'; ?>
        <?php else: ?>
            <?php require __DIR__ . '/partials/tab_invoices.php'; ?>
        <?php endif; ?>
    </div>

    <!-- Modals -->
    <?php require __DIR__ . '/partials/modal_create_invoice.php'; ?>
    <?php require __DIR__ . '/partials/modal_method.php'; ?>
    <?php require __DIR__ . '/partials/modal_proof.php'; ?>
</div>
