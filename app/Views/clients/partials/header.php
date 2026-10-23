<!-- Client Management Header & Quick Stats Ribbon -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <h1 class="text-2xl font-bold text-on-surface tracking-tight">Kelola Klien & Tenant</h1>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-surface-container-high text-primary font-mono text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                <?= count($clients) ?> Klien Terdaftar
            </span>
        </div>
        <p class="text-xs text-secondary">Manajemen akun tenant multi-perusahaan, alokasi paket langganan, dan status aktif.</p>
    </div>
    <div class="flex items-center gap-2.5">
        <button onclick="openModal('modal-create-client')" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-primary-container shadow-xs transition-all active:scale-95">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            <span>Tambah Klien Baru</span>
        </button>
    </div>
</div>
