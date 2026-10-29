<!-- Keys Management View (Cards & Empty State) -->
<div class="flex flex-col gap-4">
    <!-- Header Summary Bar -->
    <div class="flex items-center justify-between bg-surface-container-lowest px-4 py-3 rounded-xl shadow-xs border border-surface-container-high/60">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[20px]">vpn_key</span>
            <span class="text-xs font-semibold text-on-surface">Daftar API Key Aktif</span>
            <span class="px-2 py-0.5 rounded-full font-mono text-[11px] font-semibold bg-surface-container-low text-primary">
                <?= count($keys) ?> Kunci
            </span>
        </div>
        <button onclick="openModal('modal-create-key')" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:underline" type="button">
            <span class="material-symbols-outlined text-[16px]">add</span> Tambah Kunci
        </button>
    </div>

    <?php if (empty($keys)): ?>
    <!-- Empty State -->
    <div class="bg-surface-container-lowest border border-dashed border-surface-container-high rounded-2xl p-10 text-center">
        <div class="w-14 h-14 rounded-full bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center mx-auto mb-3">
            <span class="material-symbols-outlined text-2xl">key_off</span>
        </div>
        <h3 class="text-sm font-bold text-on-surface">Belum Ada API Key Dibuat</h3>
        <p class="text-xs text-secondary mt-1 mb-5 max-w-sm mx-auto leading-relaxed">
            Buat API Key pertama Anda untuk menghubungkan sistem aplikasi, CRM, website, atau notifikasi otomatis ke gateway WhatsApp.
        </p>
        <button onclick="openModal('modal-create-key')" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white text-xs font-semibold px-4 py-2 rounded-lg shadow-xs transition-colors" type="button">
            <span class="material-symbols-outlined text-[16px]">add</span>
            Buat API Key Pertama
        </button>
    </div>
    <?php else: ?>
    <!-- Keys Cards Stack -->
    <div class="space-y-4">
        <?php foreach ($keys as $k): ?>
        <?php
            $lastUsed = !empty($k['last_used_at']) ? date('d M Y H:i', strtotime($k['last_used_at'])) : 'Belum pernah digunakan';
        ?>
        <div class="bg-surface-container-lowest rounded-xl p-5 shadow-xs hover:border-primary/50 transition-all flex flex-col gap-4 border border-surface-container-high/60">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[22px]">dns</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-sm text-on-surface font-bold"><?= e($k['name']) ?></h3>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full font-mono text-[10px] bg-[#EAF7F0] text-[#16865A] font-semibold border border-[#16A36A]/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16865A] animate-pulse"></span> Aktif
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-1 flex-wrap text-xs text-secondary">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[13px]">lock</span> Akses Penuh</span>
                            <span>•</span>
                            <span class="font-mono text-[11px]">Dibuat <?= date('d M Y', strtotime($k['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-surface-container-low self-start text-xs border border-surface-container">
                    <span class="material-symbols-outlined text-primary text-[14px]">schedule</span>
                    <span class="font-mono text-[11px] text-secondary">Terakhir: <strong class="text-on-surface font-medium"><?= e($lastUsed) ?></strong></span>
                </div>
            </div>
            <!-- Token String Panel -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-surface-container-low/60 p-3 rounded-lg border border-surface-container">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="text-xs font-mono text-secondary select-none font-semibold">TOKEN:</span>
                    <code class="text-xs font-mono text-on-surface font-semibold tracking-wider truncate">
                        <?= e($k['prefix']) ?>••••••••••••••••••••••••
                    </code>
                </div>
                <div class="flex items-center gap-2 self-end sm:self-auto shrink-0">
                    <button type="button" data-copy="<?= e($k['prefix']) ?>" title="Salin Identifier Kunci" class="px-3 py-1.5 rounded-md bg-white hover:bg-surface-container-lowest text-on-surface hover:text-primary text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors cursor-pointer border border-surface-container hover:border-primary/40">
                        <span class="material-symbols-outlined text-[15px]">content_copy</span>
                        <span>Salin Key</span>
                    </button>
                    <form action="<?= url('/api-keys/delete') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut API Key ini? Integrasi yang menggunakan kunci ini akan langsung terputus.')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e($k['id']) ?>">
                        <button type="submit" class="px-3 py-1.5 rounded-md bg-[#FDF0F0] text-[#D84B4B] hover:bg-[#D84B4B] hover:text-white text-xs font-semibold transition-colors cursor-pointer flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">delete</span>
                            <span>Cabut</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>