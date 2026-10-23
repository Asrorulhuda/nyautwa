<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs flex flex-col justify-between h-full">
    <div>
        <h3 class="text-sm font-bold text-on-surface mb-1">Aksi & Kontrol Platform</h3>
        <p class="text-xs text-secondary mb-4">Pintasan administrasi untuk manajemen tenant dan landing page.</p>

        <div class="space-y-2">
            <a href="<?= url('/clients') ?>" class="flex items-center justify-between p-3 rounded-xl bg-surface-container/60 hover:bg-surface-container text-on-surface transition-colors border border-outline-variant/20">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">person_add</span>
                    </div>
                    <div>
                        <div class="text-xs font-semibold">Pendaftaran Tenant Baru</div>
                        <div class="text-[11px] text-secondary">Buat akun klien & atur paket</div>
                    </div>
                </div>
                <span class="material-symbols-outlined text-secondary text-[16px]">chevron_right</span>
            </a>

            <a href="<?= url('/settings/landing') ?>" class="flex items-center justify-between p-3 rounded-xl bg-surface-container/60 hover:bg-surface-container text-on-surface transition-colors border border-outline-variant/20">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">edit_document</span>
                    </div>
                    <div>
                        <div class="text-xs font-semibold">CMS Landing Page</div>
                        <div class="text-[11px] text-secondary">Ubah copy hero, harga, & FAQ</div>
                    </div>
                </div>
                <span class="material-symbols-outlined text-secondary text-[16px]">chevron_right</span>
            </a>

            <a href="<?= url('/devices') ?>" class="flex items-center justify-between p-3 rounded-xl bg-surface-container/60 hover:bg-surface-container text-on-surface transition-colors border border-outline-variant/20">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-[18px]">qr_code_scanner</span>
                    </div>
                    <div>
                        <div class="text-xs font-semibold">Sesi WhatsApp Global</div>
                        <div class="text-[11px] text-secondary">Pantau device terhubung</div>
                    </div>
                </div>
                <span class="material-symbols-outlined text-secondary text-[16px]">chevron_right</span>
            </a>
        </div>
    </div>

    <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-[11px] text-secondary font-mono">
        <span>NyautWa SaaS v1.0.0</span>
        <span class="text-primary font-semibold">Node 20 + Baileys</span>
    </div>
</div>
