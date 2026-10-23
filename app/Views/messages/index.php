<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-2xl font-bold text-on-surface tracking-tight font-sans">Riwayat Pesan (Outbox)</h1>
                <span class="px-2.5 py-0.5 rounded-full font-mono text-xs font-semibold bg-surface-container-low text-primary">
                    <?= count($messages) ?> Pesan Ditampilkan
                </span>
            </div>
            <p class="text-xs text-secondary">Log transmisi pesan keluar real-time dengan status verifikasi ACK dari server WhatsApp.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= url('/messages/send') ?>" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white text-xs font-semibold px-4 py-2.5 rounded-md transition-colors shadow-xs">
                <span class="material-symbols-outlined text-sm">send</span>
                Kirim Pesan Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-container-lowest border border-surface-container-high/60 rounded-xl p-4 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="<?= url('/messages?status=all' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? 'all') === 'all' ? 'bg-primary text-white font-semibold' : 'bg-surface-container text-secondary hover:text-on-surface' ?>">
                Semua Status
            </a>
            <a href="<?= url('/messages?status=delivered' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? '') === 'delivered' ? 'bg-primary text-white font-semibold' : 'bg-surface-container text-secondary hover:text-on-surface' ?>">
                Terkirim / Terbaca
            </a>
            <a href="<?= url('/messages?status=queued' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? '') === 'queued' ? 'bg-[#D99124] text-white font-semibold' : 'bg-surface-container text-secondary hover:text-on-surface' ?>">
                Antrean Jitter
            </a>
            <a href="<?= url('/messages?status=failed' . ($searchQuery ? '&q=' . urlencode($searchQuery) : '')) ?>" class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors <?= ($currentStatus ?? '') === 'failed' ? 'bg-error text-white font-semibold' : 'bg-surface-container text-secondary hover:text-on-surface' ?>">
                Gagal Kirim
            </a>
        </div>

        <form action="<?= url('/messages') ?>" method="GET" class="relative w-full md:w-72">
            <?php if (!empty($currentStatus) && $currentStatus !== 'all'): ?>
                <input type="hidden" name="status" value="<?= e($currentStatus) ?>">
            <?php endif; ?>
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-secondary text-sm pointer-events-none">search</span>
            <input type="text" name="q" value="<?= e($searchQuery ?? '') ?>" placeholder="Cari nomor atau ID pesan..." class="w-full pl-9 pr-3 py-1.5 bg-surface-container-low border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden">
        </form>
    </div>

    <!-- Messages Table Partial -->
    <?php require __DIR__ . '/partials/table.php'; ?>
</div>
