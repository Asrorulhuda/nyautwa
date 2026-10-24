<?php
use App\Services\DatabaseUpdateService;
$isAdmin = !empty($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'superadmin'], true);
?>
<?php if (DatabaseUpdateService::isPending()): ?>
    <div class="mb-6 p-4 rounded-xl bg-[#FEF6E7] border border-[#D99124]/30 text-[#17211F] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4 transition-all animate-pulse">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-[#D99124]/15 text-[#D99124] flex items-center justify-center shrink-0 mt-0.5">
                <span class="material-symbols-outlined text-xl">database</span>
            </div>
            <div>
                <h4 class="text-sm font-bold text-[#784405] flex items-center gap-1.5">
                    Pembaruan Skema Database Tersedia
                    <span class="inline-flex px-2 py-0.5 text-[10px] font-mono bg-[#D99124]/20 text-[#784405] rounded-full font-semibold uppercase">Pending</span>
                </h4>
                <p class="text-xs text-[#8c5208] mt-0.5">
                    <?= $isAdmin ? 'Webhook auto-deploy mendeteksi perubahan skema database. Klik tombol untuk mengeksekusi update skema.' : 'Pembaruan skema database sedang disinkronkan oleh tim teknis kami.' ?>
                </p>
            </div>
        </div>

        <?php if ($isAdmin): ?>
            <form action="/database/update" method="POST" class="shrink-0">
                <input type="hidden" name="_csrf_token" value="<?= csrf_field() ?>">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold rounded-md shadow-xs transition-colors">
                    <span class="material-symbols-outlined text-sm">sync</span>
                    <span>Perbarui Database Sekarang</span>
                </button>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>
