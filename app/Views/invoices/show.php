<div class="flex flex-col w-full space-y-6">
    <div class="flex items-center justify-between pb-4 border-b border-[#E4EAE6] print:hidden">
        <div class="flex items-center gap-3">
            <a href="<?= url('/clients') ?>" class="p-2 rounded-lg bg-white border border-[#E4EAE6] text-[#697570] hover:text-[#17211F] transition-colors" title="Kembali ke Daftar Klien">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </a>
            <div>
                <h1 class="text-lg font-bold text-[#17211F] font-['Geist']">Nota Pembayaran Resmi</h1>
                <p class="text-xs text-[#697570]">Bukti transaksi penagihan dan langganan klien.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold shadow-xs transition-colors">
                <span class="material-symbols-outlined text-[16px]">print</span> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Printable Receipt Card -->
    <?php require __DIR__ . '/partials/receipt_card.php'; ?>
</div>
