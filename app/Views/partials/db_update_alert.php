<?php
use App\Services\DatabaseUpdateService;
$isAdmin = !empty($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'superadmin'], true);
$result = $_SESSION['db_update_result'] ?? null;
if ($result) unset($_SESSION['db_update_result']);
?>
<?php if ($result && !empty($result['success'])): ?>
    <div id="db-update-success-box" class="mb-6 p-4 rounded-xl bg-[#EAF7F0] border border-[#16A36A]/30 text-[#17211F] shadow-xs">
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#16A36A]/15 text-[#16A36A] flex items-center justify-center shrink-0 mt-0.5"><span class="material-symbols-outlined text-lg">check_circle</span></div>
                <div>
                    <h4 class="text-sm font-bold text-[#128557]"><?= e($result['message']) ?></h4>
                    <p class="text-xs text-[#697570] mt-0.5">Waktu: <?= e($result['updated_at'] ?? date('Y-m-d H:i:s')) ?></p>
                    <?php if (!empty($result['changes'])): ?>
                        <div class="mt-2 space-y-1">
                            <?php foreach ($result['changes'] as $c): ?>
                                <div class="flex items-center gap-1.5 text-xs text-[#17211F]"><span class="material-symbols-outlined text-[14px] text-[#16A36A]">done</span><span><?= e($c) ?></span></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('db-update-success-box').remove()" class="text-[#697570] hover:text-[#17211F]"><span class="material-symbols-outlined text-sm">close</span></button>
        </div>
    </div>
<?php endif; ?>

<?php if (DatabaseUpdateService::isPending()): ?>
    <div id="db-pending-alert" class="mb-6 p-4 rounded-xl bg-[#FEF6E7] border border-[#D99124]/30 text-[#17211F] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-[#D99124]/15 text-[#D99124] flex items-center justify-center shrink-0 mt-0.5"><span class="material-symbols-outlined text-xl">database</span></div>
            <div>
                <h4 class="text-sm font-bold text-[#784405] flex items-center gap-1.5">Pembaruan Skema Database Tersedia <span class="px-2 py-0.5 text-[10px] font-mono bg-[#D99124]/20 text-[#784405] rounded-full font-semibold">PENDING</span></h4>
                <p class="text-xs text-[#8c5208] mt-0.5"><?= $isAdmin ? 'Terdapat pembaruan skema database terbaru dari repositori. Klik tombol untuk mengeksekusi.' : 'Pembaruan skema database sedang dipersiapkan oleh administrator.' ?></p>
            </div>
        </div>
        <?php if ($isAdmin): ?>
            <div class="shrink-0 flex items-center gap-2">
                <input type="hidden" id="db-csrf-token" value="<?= \App\Core\Csrf::token() ?>">
                <button type="button" id="btn-run-db-update" onclick="executeDbUpdateAjax(this)" class="inline-flex items-center gap-2 px-4 py-2 bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold rounded-md shadow-xs transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-sm">sync</span><span id="btn-run-db-text">Perbarui Database Sekarang</span>
                </button>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($isAdmin): ?>
    <script>
    function executeDbUpdateAjax(btn) {
        const token = document.getElementById('db-csrf-token').value;
        const textSpan = document.getElementById('btn-run-db-text');
        btn.disabled = true; textSpan.textContent = 'Memperbarui Database...';
        fetch('/database/update', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'},
            body: new URLSearchParams({'_csrf_token': token})
        }).then(r => r.json()).then(data => {
            if (data.success) {
                const alertBox = document.getElementById('db-pending-alert');
                if (alertBox) alertBox.remove();
                let changesHtml = (data.changes || []).map(c => '<div class="flex items-center gap-1.5 text-xs text-[#17211F]"><span class="material-symbols-outlined text-[14px] text-[#16A36A]">done</span><span>' + c + '</span></div>').join('');
                const res = document.createElement('div');
                res.className = 'mb-6 p-4 rounded-xl bg-[#EAF7F0] border border-[#16A36A]/30 text-[#17211F] shadow-xs';
                res.innerHTML = '<div class="flex items-start gap-3"><div class="w-8 h-8 rounded-lg bg-[#16A36A]/15 text-[#16A36A] flex items-center justify-center shrink-0 mt-0.5"><span class="material-symbols-outlined text-lg">check_circle</span></div><div><h4 class="text-sm font-bold text-[#128557]">' + (data.message || 'Pembaruan Berhasil') + '</h4><div class="mt-2 space-y-1">' + changesHtml + '</div></div></div>';
                document.querySelector('main')?.prepend(res);
            } else {
                alert('Gagal: ' + (data.error || 'Terjadi kesalahan'));
                btn.disabled = false; textSpan.textContent = 'Perbarui Database Sekarang';
            }
        }).catch(err => { console.error(err); window.location.reload(); });
    }
    </script>
    <?php endif; ?>
<?php endif; ?>
