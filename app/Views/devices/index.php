<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-2xl font-bold text-on-surface tracking-tight">Koneksi WhatsApp</h1>
                <span class="px-2.5 py-0.5 rounded-full font-mono text-xs font-semibold bg-surface-container-low text-primary">
                    <?= count($devices) ?> Perangkat Terdaftar
                </span>
            </div>
            <p class="text-xs text-secondary">Kelola sesi perangkat WhatsApp multi-device, pantau status socket Baileys, dan hubungkan nomor baru.</p>
        </div>

        <button onclick="openModal('modal-add-device')" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white text-xs font-semibold px-4 py-2.5 rounded-md transition-colors shadow-xs">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            Tambah Koneksi Baru
        </button>
    </div>

    <!-- Cards Grid -->
    <?php require __DIR__ . '/partials/cards.php'; ?>

    <!-- Modal Form -->
    <?php require __DIR__ . '/partials/modal_add.php'; ?>
</div>
