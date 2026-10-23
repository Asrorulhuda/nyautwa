<header class="h-16 bg-[#FFFFFF] border-b border-[#E4EAE6] px-8 flex items-center justify-between sticky top-0 z-20">
    <div class="flex items-center gap-4 flex-1 max-w-md">
        <div class="relative w-full">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#697570] text-sm pointer-events-none">search</span>
            <input 
                id="global-search" 
                type="search" 
                placeholder="Cari ID pesan, nomor tujuan, atau log... (Tekan /)" 
                class="w-full pl-9 pr-10 py-1.5 bg-[#F6F8F7] border border-[#E4EAE6] rounded-md text-xs text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
            >
            <kbd class="absolute right-2.5 top-1/2 -translate-y-1/2 border border-[#E4EAE6] bg-[#FFFFFF] text-[10px] text-[#697570] px-1.5 py-0.5 rounded font-mono shadow-xs">/</kbd>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <!-- Live WhatsApp Device Telemetry -->
        <div class="hidden md:flex items-center gap-3 px-3 py-1.5 bg-[#F6F8F7] border border-[#E4EAE6] rounded-md text-xs">
            <span class="flex items-center gap-1.5 font-mono text-[#16865A] font-medium text-[11px]">
                <span class="w-2 h-2 rounded-full bg-[#16A36A] status-pulse"></span>
                CS Utama (+6281288990011)
            </span>
            <span class="text-[#E4EAE6]">|</span>
            <span class="font-mono text-[11px] text-[#697570] tnum">Latensi: 42ms</span>
        </div>

        <a href="<?= url('/messages/send') ?>" class="inline-flex items-center gap-1.5 bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-3.5 py-2 rounded-md transition-colors shadow-xs">
            <span class="material-symbols-outlined text-sm">send</span>
            Kirim Pesan
        </a>
    </div>
</header>
