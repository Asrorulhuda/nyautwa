<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <div class="w-16 h-16 rounded-full bg-[#FDF0F0] text-[#D84B4B] flex items-center justify-center mb-4">
        <span class="material-symbols-outlined text-3xl">error</span>
    </div>
    <h1 class="text-2xl font-semibold text-[#17211F] mb-2 font-['Geist']">404 — Halaman Tidak Ditemukan</h1>
    <p class="text-[#697570] max-w-md text-sm mb-6">
        Halaman <code class="font-mono text-xs bg-[#E4EAE6] px-2 py-1 rounded"><?= \App\Core\View::e($path ?? '') ?></code> tidak tersedia atau telah dipindahkan.
    </p>
    <a href="/" class="inline-flex items-center gap-2 bg-[#16A36A] hover:bg-[#128557] text-white text-sm font-medium px-4 py-2.5 rounded-md transition-colors">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Kembali ke Beranda
    </a>
</div>
