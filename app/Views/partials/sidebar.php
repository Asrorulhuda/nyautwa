<aside class="w-64 bg-[#FFFFFF] border-r border-[#E4EAE6] flex flex-col justify-between shrink-0 min-h-screen sticky top-0 h-screen overflow-y-auto">
    <div>
        <!-- Brand Logo -->
        <div class="h-16 flex items-center px-6 border-b border-[#E4EAE6]">
            <a href="/dashboard" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-md bg-[#16A36A] flex items-center justify-center text-white shadow-sm">
                    <span class="material-symbols-outlined text-lg">chat</span>
                </div>
                <div>
                    <span class="text-base font-bold text-[#17211F] tracking-tight block leading-none">NyautWa</span>
                    <span class="text-[10px] text-[#697570] font-mono tracking-wider uppercase">Gateway v1.0</span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="p-4 space-y-1">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#697570] px-3 py-2">
                Operasional
            </div>

            <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors <?= is_active('/dashboard') ? 'bg-[#EAF7F0] text-[#16865A]' : 'text-[#17211F] hover:bg-[#F6F8F7]' ?>">
                <span class="material-symbols-outlined text-lg <?= is_active('/dashboard') ? 'fill text-[#16865A]' : 'text-[#697570]' ?>">dashboard</span>
                <span>Ringkasan</span>
            </a>

            <a href="/devices" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors <?= is_active('/devices') ? 'bg-[#EAF7F0] text-[#16865A]' : 'text-[#17211F] hover:bg-[#F6F8F7]' ?>">
                <span class="material-symbols-outlined text-lg <?= is_active('/devices') ? 'fill text-[#16865A]' : 'text-[#697570]' ?>">phonelink_ring</span>
                <span>Koneksi WhatsApp</span>
            </a>

            <a href="/messages" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors <?= is_active('/messages') && !is_active('/messages/send') ? 'bg-[#EAF7F0] text-[#16865A]' : 'text-[#17211F] hover:bg-[#F6F8F7]' ?>">
                <span class="material-symbols-outlined text-lg <?= is_active('/messages') && !is_active('/messages/send') ? 'fill text-[#16865A]' : 'text-[#697570]' ?>">history</span>
                <span>Riwayat Pesan</span>
            </a>

            <a href="/messages/send" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors <?= is_active('/messages/send') ? 'bg-[#EAF7F0] text-[#16865A]' : 'text-[#17211F] hover:bg-[#F6F8F7]' ?>">
                <span class="material-symbols-outlined text-lg <?= is_active('/messages/send') ? 'fill text-[#16865A]' : 'text-[#697570]' ?>">send</span>
                <span>Kirim Pesan Uji</span>
            </a>

            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#697570] px-3 pt-5 pb-2">
                Integrasi Pengembang
            </div>

            <a href="/api-keys" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors <?= is_active('/api-keys') ? 'bg-[#EAF7F0] text-[#16865A]' : 'text-[#17211F] hover:bg-[#F6F8F7]' ?>">
                <span class="material-symbols-outlined text-lg <?= is_active('/api-keys') ? 'fill text-[#16865A]' : 'text-[#697570]' ?>">key</span>
                <span>API Keys & Webhook</span>
            </a>

            <a href="/" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-[#17211F] hover:bg-[#F6F8F7] transition-colors">
                <span class="material-symbols-outlined text-lg text-[#697570]">open_in_new</span>
                <span>Landing Publik</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Tenant & User Info -->
    <div class="p-4 border-t border-[#E4EAE6]">
        <div class="bg-[#F6F8F7] border border-[#E4EAE6] rounded-md p-3 mb-3">
            <div class="flex items-center justify-between text-xs mb-1.5">
                <span class="text-[#697570]">Sesi Engine Baileys</span>
                <span class="inline-flex items-center gap-1.5 text-[#16865A] font-medium font-mono text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A36A] status-pulse"></span>
                    Ready
                </span>
            </div>
            <div class="w-full bg-[#E4EAE6] h-1.5 rounded-full overflow-hidden">
                <div class="bg-[#16A36A] h-full rounded-full" style="width: 25%"></div>
            </div>
            <div class="flex justify-between items-center text-[10px] text-[#697570] font-mono mt-1">
                <span>Kuota Harian</span>
                <span class="tnum">1.240 / 5.000</span>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-[#EAF7F0] text-[#16865A] font-semibold text-xs flex items-center justify-center shrink-0">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'FB', 0, 2)) ?>
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-[#17211F] truncate leading-tight"><?= e($_SESSION['user_name'] ?? 'Fikri Baihaqy') ?></p>
                    <p class="text-[11px] text-[#697570] truncate"><?= e($_SESSION['tenant_name'] ?? 'PT Teknologi Berkah') ?></p>
                </div>
            </div>
            <form action="/logout" method="POST" class="inline">
                <?= csrf_field() ?>
                <button type="submit" title="Keluar dari akun" class="text-[#697570] hover:text-[#D84B4B] p-1 rounded hover:bg-[#FDF0F0] transition-colors">
                    <span class="material-symbols-outlined text-base">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
