<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <h1 class="text-xl font-bold text-[#17211F] tracking-tight font-['Geist']">Kelola Klien & Tenant</h1>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#EAF7F0] text-[#16A36A] font-mono text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-[#16A36A] animate-pulse"></span>
                <?= count($clients) ?> Pengguna Aktif
            </span>
        </div>
        <p class="text-xs text-[#697570]">Manajemen akun pengguna multi-tenant, kuota pesan, hak akses fitur, dan nota penagihan.</p>
    </div>
    <div class="flex items-center gap-2.5">
        <button onclick="openModal('modal-add-feature')" type="button" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-lg bg-white border border-[#E4EAE6] text-[#17211F] text-xs font-semibold hover:bg-[#F6F8F7] shadow-xs transition-all">
            <span class="material-symbols-outlined text-[16px] text-[#16A36A]">extension</span>
            <span>Tambah Fitur Baru</span>
        </button>
        <button onclick="openModal('modal-create-client')" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold shadow-xs transition-all active:scale-95">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            <span>Tambahkan Pengguna</span>
        </button>
    </div>
</div>
