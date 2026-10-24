<!-- Modal Tarik Kontak & Grup dari WhatsApp -->
<div id="modal-sync-contacts" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center justify-between border-b border-[#E4EAE6] pb-3">
            <div class="flex items-center gap-2 text-[#17211F]">
                <span class="material-symbols-outlined text-[#16A36A]">sync_saved_locally</span>
                <h3 class="text-base font-bold">Tarik Kontak & Grup dari WhatsApp</h3>
            </div>
            <button type="button" onclick="document.getElementById('modal-sync-contacts').classList.add('hidden')" class="text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <p class="text-xs text-[#697570] leading-relaxed">
            Sistem akan membaca daftar kontak pelanggan dan seluruh grup WhatsApp yang terdaftar pada perangkat aktif yang dipilih, lalu menyimpannya ke buku kontak secara otomatis.
        </p>

        <form method="POST" action="/contacts/sync" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <div>
                <label class="block text-xs font-semibold text-[#17211F] mb-1.5">Pilih Perangkat WhatsApp Terhubung</label>
                <select name="device_id" required class="w-full px-3 py-2 bg-white border border-[#E4EAE6] rounded-md text-xs text-[#17211F] focus:border-[#16A36A] outline-hidden">
                    <?php 
                    $hasConnected = false;
                    foreach ($devices as $dev): 
                        if ($dev['status'] === 'connected'):
                            $hasConnected = true;
                    ?>
                        <option value="<?= htmlspecialchars($dev['id']) ?>">
                            <?= htmlspecialchars($dev['label']) ?> (<?= htmlspecialchars($dev['phone'] ?? 'Aktif') ?>)
                        </option>
                    <?php endif; endforeach; ?>
                    <?php if (!$hasConnected): ?>
                        <option value="" disabled selected>Tidak ada perangkat terhubung. Silakan scan QR terlebih dahulu.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="p-3 bg-[#F6F8F7] rounded-lg border border-[#E4EAE6] text-xs space-y-1">
                <span class="font-semibold text-[#17211F] block">Otomatisasi Tag:</span>
                <p class="text-[#697570] text-[11px]">
                    • Grup WA otomatis ditandai dengan tag <strong class="text-[#4F46E5]">Grup WhatsApp</strong>.<br>
                    • Kontak perorangan ditandai dengan tag <strong class="text-[#16A36A]">Kontak WhatsApp</strong>.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-sync-contacts').classList.add('hidden')" class="px-3 py-2 text-xs font-medium text-[#697570] hover:text-[#17211F]">
                    Batal
                </button>
                <button type="submit" <?= !$hasConnected ? 'disabled' : '' ?> class="px-4 py-2 text-xs font-semibold text-white bg-[#16A36A] hover:bg-[#128557] disabled:opacity-50 rounded-md transition-colors shadow-sm flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Mulai Sinkronisasi
                </button>
            </div>
        </form>
    </div>
</div>
