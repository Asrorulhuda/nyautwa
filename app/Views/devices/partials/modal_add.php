<!-- Modal Add Device -->
<div id="modal-add-device" class="fixed inset-0 bg-inverse-surface/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest w-full max-w-md rounded-xl p-6 shadow-xl border border-surface-container-high">
        <div class="flex items-center justify-between pb-3 border-b border-surface-container mb-4">
            <h3 class="text-base font-bold text-on-surface">Tambah Koneksi WhatsApp</h3>
            <button onclick="closeModal('modal-add-device')" class="text-secondary hover:text-on-surface">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        <form action="<?= url('/devices') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="label" class="block text-xs font-semibold text-on-surface mb-1">Label / Nama Perangkat</label>
                <input type="text" id="label" name="label" required placeholder="CS WhatsApp Cabang Surabaya" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface outline-hidden focus:border-primary">
            </div>
            <div>
                <label for="phone" class="block text-xs font-semibold text-on-surface mb-1">Nomor WhatsApp (Format: 08xx / 628xx)</label>
                <input type="text" id="phone" name="phone" required placeholder="contoh: 081234567890" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface font-mono outline-hidden focus:border-primary">
            </div>
            <div>
                <label for="daily_limit" class="block text-xs font-semibold text-on-surface mb-1">Batas Kuota Harian (Proteksi Anti-Ban)</label>
                <input type="number" id="daily_limit" name="daily_limit" value="1000" min="100" max="10000" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface font-mono outline-hidden focus:border-primary">
            </div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('modal-add-device')" class="px-4 py-2 border border-surface-container text-xs font-semibold rounded-md text-secondary hover:bg-surface-container">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-container text-white text-xs font-semibold rounded-md shadow-xs">
                    Buat Sesi & Ambil QR
                </button>
            </div>
        </form>
    </div>
</div>
