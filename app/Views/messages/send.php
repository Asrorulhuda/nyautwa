<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <a href="<?= url('/messages') ?>" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1 mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Riwayat Pesan
        </a>
        <h1 class="text-2xl font-bold text-on-surface tracking-tight font-sans">Kirim Pesan WhatsApp Uji</h1>
        <p class="text-xs text-secondary mt-1">Uji coba transmisi pesan interaktif langsung ke nomor WhatsApp melalui gateway Baileys.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-7 bg-surface-container-lowest border border-surface-container-high/60 rounded-xl p-6 shadow-xs">
            <form action="<?= url('/messages/send') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="type" id="msg_type_input" value="text">
                <div>
                    <label for="device_id" class="block text-xs font-semibold text-on-surface mb-1.5">Pilih Perangkat Pengirim</label>
                    <select id="device_id" name="device_id" required class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden">
                        <?php foreach ($devices as $dev): ?>
                            <option value="<?= e($dev['id']) ?>"><?= e($dev['label']) ?> (<?= e($dev['phone'] ?? 'Standby') ?>) - [<?= e($dev['status']) ?>]</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1.5">Pilih Fitur / Format Pesan</label>
                    <div class="grid grid-cols-5 gap-1.5 p-1 bg-surface-container-low rounded-lg text-xs">
                        <button type="button" id="btn-type-text" onclick="selectMessageType('text')" class="type-btn py-1.5 px-2 rounded-md font-semibold transition-all">Teks</button>
                        <button type="button" id="btn-type-image" onclick="selectMessageType('image')" class="type-btn py-1.5 px-2 rounded-md font-semibold transition-all">Gambar</button>
                        <button type="button" id="btn-type-document" onclick="selectMessageType('document')" class="type-btn py-1.5 px-2 rounded-md font-semibold transition-all">Dokumen</button>
                        <button type="button" id="btn-type-poll" onclick="selectMessageType('poll')" class="type-btn py-1.5 px-2 rounded-md font-semibold transition-all">Voting</button>
                        <button type="button" id="btn-type-button" onclick="selectMessageType('button')" class="type-btn py-1.5 px-2 rounded-md font-semibold transition-all">Tombol</button>
                    </div>
                </div>
                <div>
                    <label for="phone" class="block text-xs font-semibold text-on-surface mb-1.5">Nomor WhatsApp Penerima</label>
                    <div class="flex rounded-md shadow-xs">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-surface-container bg-surface-container-low text-secondary text-xs font-mono font-medium">+62</span>
                        <input type="text" id="phone" name="phone" required placeholder="81234567890" value="<?= e(old('phone')) ?>" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-surface-container text-xs font-mono text-on-surface focus:border-primary outline-hidden">
                    </div>
                </div>
                <?php require __DIR__ . '/partials/type_fields.php'; ?>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="body" id="body-label" class="block text-xs font-semibold text-on-surface">Isi Pesan WhatsApp</label>
                        <span class="text-[11px] text-secondary font-mono" id="char-count">0 karakter</span>
                    </div>
                    <textarea id="body" name="body" rows="3" placeholder="Tuliskan pesan..." oninput="updatePreviewText(this.value)" class="w-full px-3 py-2 bg-surface border border-surface-container rounded-md text-xs text-on-surface focus:border-primary outline-hidden"><?= e(old('body')) ?></textarea>
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white text-xs font-semibold py-2.5 rounded-md transition-colors shadow-xs flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span>
                    Kirim Pesan Langsung ke WhatsApp
                </button>
            </form>
        </div>
        <?php require __DIR__ . '/partials/preview_bubble.php'; ?>
    </div>
</div>
<?php require __DIR__ . '/partials/send_script.php'; ?>
