<!-- Modal Create API Key -->
<div id="modal-create-key" class="fixed inset-0 bg-inverse-surface/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest w-full max-w-lg rounded-2xl p-6 shadow-2xl flex flex-col gap-4 border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-surface-container-low text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">key</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-on-surface">Buat API Key Baru</h3>
                    <span class="text-xs text-secondary">Token unik untuk server backend</span>
                </div>
            </div>
            <button onclick="closeModal('modal-create-key')" class="p-1 rounded-lg text-secondary hover:text-on-surface transition-colors" type="button">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="<?= url('/api-keys') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="name" class="block text-xs font-semibold text-on-surface mb-1.5">Nama Identifier Key</label>
                <input type="text" id="name" name="name" required placeholder="Production Backend Server" class="w-full px-3 py-2 bg-surface-container-low border border-surface-container rounded-lg text-xs text-on-surface outline-hidden focus:border-primary">
            </div>
            <div class="p-3 rounded-xl bg-[#fef6e7] text-[#935b0b] text-xs leading-relaxed font-medium flex items-start gap-2">
                <span class="material-symbols-outlined text-[18px] text-[#d99124] shrink-0">warning</span>
                <span>Kunci rahasia hanya akan ditampilkan satu kali saat selesai dibuat. Pastikan untuk langsung menyimpannya.</span>
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('modal-create-key')" class="px-4 py-2 border border-surface-container text-xs font-semibold rounded-lg text-secondary hover:bg-surface-container">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-container text-white text-xs font-semibold rounded-lg shadow-xs">
                    Generate Key
                </button>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($newRawKey)): ?>
<!-- One-Time Key Disclosure Modal -->
<div id="modal-new-key" class="fixed inset-0 bg-inverse-surface/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-surface-container-lowest w-full max-w-xl rounded-2xl p-6 shadow-2xl flex flex-col gap-4 border border-surface-container-high/60">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-surface-container-low text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">verified</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-on-surface">API Key Berhasil Dibuat!</h3>
                    <span class="text-xs text-secondary">Token unik untuk server backend</span>
                </div>
            </div>
            <button onclick="document.getElementById('modal-new-key').remove()" class="p-1 rounded-lg text-secondary hover:text-on-surface transition-colors" type="button">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="p-3.5 rounded-xl bg-[#fef6e7] text-[#935b0b] text-xs leading-relaxed font-medium flex items-start gap-2">
            <span class="material-symbols-outlined text-[20px] text-[#d99124] shrink-0">warning</span>
            <span>Peringatan: Simpan API Key ini sekarang. Demi alasan keamanan, kami tidak akan pernah menampilkan kunci lengkap ini lagi setelah dialog ditutup.</span>
        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-mono text-secondary font-semibold uppercase">Token Rahasia Baru</label>
            <div class="flex items-center gap-2 p-1.5 bg-surface-container-low rounded-xl border border-surface-container">
                <input class="flex-1 bg-transparent px-3 text-xs font-mono text-on-surface font-semibold select-all outline-hidden" id="rawTokenInput" readonly value="<?= e($newRawKey) ?>">
                <button class="h-8 px-3 rounded-lg bg-primary text-white text-xs font-semibold flex items-center gap-1 hover:bg-primary-container shadow-xs" onclick="copyToClipboard('<?= e($newRawKey) ?>')" type="button">
                    <span class="material-symbols-outlined text-[16px]">content_copy</span>
                    <span>Salin</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
