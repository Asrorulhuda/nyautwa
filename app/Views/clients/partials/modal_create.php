<!-- Modal Create Client -->
<div id="modal-create-client" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-md rounded-2xl bg-surface-container-lowest p-6 shadow-xl border border-surface-container-high/60 space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-surface-container-high">
            <h3 class="text-base font-bold text-on-surface">Tambah Klien / Tenant Baru</h3>
            <button onclick="closeModal('modal-create-client')" type="button" class="p-1 rounded-lg text-secondary hover:text-on-surface">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form action="<?= url('/clients/create') ?>" method="POST" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <div>
                <label class="block font-medium text-on-surface mb-1">Nama Perusahaan / Bisnis *</label>
                <input type="text" name="name" required placeholder="PT Solusi Digital Nusantara" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block font-medium text-on-surface mb-1">Nama Penanggung Jawab (PIC)</label>
                <input type="text" name="owner_name" placeholder="Rian Hidayat" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block font-medium text-on-surface mb-1">Email Login Admin *</label>
                <input type="email" name="email" required placeholder="admin@solusidigital.id" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block font-medium text-on-surface mb-1">Password Sementara</label>
                <input type="password" name="password" value="password123" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
            </div>
            <div>
                <label class="block font-medium text-on-surface mb-1">Paket Langganan</label>
                <select name="plan_id" class="w-full h-9 px-3 rounded-lg bg-surface-container-low border border-outline-variant/40 text-xs">
                    <option value="starter">Starter (10k pesan / bln)</option>
                    <option value="pro" selected>Pro (50k pesan / bln)</option>
                    <option value="business">Business (Unlimited)</option>
                </select>
            </div>
            <div class="pt-3 border-t border-surface-container-high flex items-center justify-end gap-2">
                <button onclick="closeModal('modal-create-client')" type="button" class="px-4 py-2 rounded-lg bg-surface-container text-secondary font-semibold hover:bg-surface-container-high">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white font-semibold hover:bg-primary-container shadow-xs">Buat Akun Klien</button>
            </div>
        </form>
    </div>
</div>
