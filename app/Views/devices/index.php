<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-2xl font-bold text-[#17211F] tracking-tight font-['Geist']">Koneksi WhatsApp</h1>
                <span class="px-2.5 py-0.5 rounded-full font-mono text-xs font-semibold bg-[#EAF7F0] text-[#16865A]">
                    <?= count($devices) ?> Perangkat Terdaftar
                </span>
            </div>
            <p class="text-xs text-[#697570]">Kelola sesi perangkat WhatsApp multi-device, pantau status socket Baileys, dan hubungkan nomor baru.</p>
        </div>

        <button onclick="openModal('modal-add-device')" class="inline-flex items-center gap-2 bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-4 py-2.5 rounded-md transition-colors shadow-xs">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            Tambah Koneksi Baru
        </button>
    </div>

    <!-- Device Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($devices as $dev): ?>
            <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 shadow-xs flex flex-col justify-between hover:border-[#16A36A]/50 transition-all">
                <div>
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-11 h-11 rounded-lg bg-[#EAF7F0] text-[#16865A] flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-2xl">phonelink_ring</span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-[#17211F]"><?= e($dev['label']) ?></h3>
                                <p class="text-xs font-mono font-semibold text-[#17211F] mt-0.5">
                                    <?= e($dev['phone'] ?? 'Belum Terhubung') ?>
                                </p>
                                <span class="text-[11px] font-mono text-[#697570]">Sesi: <?= e($dev['session_ref']) ?></span>
                            </div>
                        </div>

                        <?php if ($dev['status'] === 'connected'): ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#EAF7F0] text-[#16865A]">
                                <span class="w-2 h-2 rounded-full bg-[#16A36A] status-pulse"></span>
                                Terhubung
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#FDF0F0] text-[#D84B4B]">
                                <span class="w-2 h-2 rounded-full bg-[#D84B4B]"></span>
                                Terputus
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Telemetry Indicators -->
                    <div class="grid grid-cols-3 gap-2 p-3 bg-[#F6F8F7] border border-[#E4EAE6] rounded-lg text-xs mb-4">
                        <div>
                            <span class="text-[10px] text-[#697570] block">Baterai Ponsel</span>
                            <span class="font-mono font-semibold text-[#17211F]">88% Normal</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-[#697570] block">Sinyal Jaringan</span>
                            <span class="font-mono font-semibold text-[#16865A]">WiFi 5G</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-[#697570] block">Batas Kuota</span>
                            <span class="font-mono font-semibold text-[#17211F] tnum"><?= number_format($dev['daily_limit'], 0, ',', '.') ?> / hari</span>
                        </div>
                    </div>

                    <?php if (!empty($dev['webhook_url'])): ?>
                        <div class="text-xs mb-4">
                            <span class="text-[#697570] block mb-1 text-[11px]">Webhook Endpoint:</span>
                            <code class="font-mono text-[11px] text-[#17211F] bg-[#F6F8F7] px-2 py-1 rounded border border-[#E4EAE6] block truncate">
                                <?= e($dev['webhook_url']) ?>
                            </code>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="pt-4 border-t border-[#E4EAE6] flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <a href="<?= url('/devices/connect?id=' . e($dev['id'])) ?>" class="bg-[#FFFFFF] hover:bg-[#F6F8F7] border border-[#E4EAE6] text-[#17211F] text-xs font-semibold px-3 py-2 rounded-md transition-colors inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm text-[#16A36A]">qr_code_scanner</span>
                            Scan QR
                        </a>
                        <a href="<?= url('/messages/send') ?>" class="bg-[#FFFFFF] hover:bg-[#F6F8F7] border border-[#E4EAE6] text-[#17211F] text-xs font-semibold px-3 py-2 rounded-md transition-colors inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">send</span>
                            Uji Kirim
                        </a>
                    </div>

                    <?php if ($dev['status'] === 'connected'): ?>
                        <form action="<?= url('/devices/' . e($dev['id']) . '/disconnect') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memutuskan sambungan sesi WhatsApp ini?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-[#D84B4B] hover:bg-[#FDF0F0] border border-transparent hover:border-[#F2D0D0] text-xs font-semibold px-2.5 py-1.5 rounded-md transition-colors inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">power_settings_new</span>
                                Putuskan
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Tambah Koneksi Device Baru -->
<div id="modal-add-device" class="fixed inset-0 bg-[#17211F]/50 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl max-w-md w-full p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-[#17211F]">Tambah Perangkat WhatsApp Baru</h3>
            <button onclick="closeModal('modal-add-device')" class="text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form action="<?= url('/devices/create') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="label" class="block text-xs font-semibold text-[#17211F] mb-1">Nama / Label Perangkat</label>
                <input 
                    type="text" 
                    id="label" 
                    name="label" 
                    required 
                    placeholder="Contoh: CS Billing WhatsApp" 
                    class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                >
            </div>

            <div>
                <label for="webhook_url" class="block text-xs font-semibold text-[#17211F] mb-1">Webhook URL (Opsional)</label>
                <input 
                    type="url" 
                    id="webhook_url" 
                    name="webhook_url" 
                    placeholder="https://api.bisnisanda.com/webhook/whatsapp" 
                    class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                >
                <p class="text-[11px] text-[#697570] mt-1">Sistem akan mem-forward pesan masuk dan status delivery ack ke URL ini.</p>
            </div>

            <div>
                <label for="daily_limit" class="block text-xs font-semibold text-[#17211F] mb-1">Batas Maksimal Pesan Harian</label>
                <input 
                    type="number" 
                    id="daily_limit" 
                    name="daily_limit" 
                    value="1000" 
                    min="100" 
                    max="50000"
                    class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                >
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E4EAE6]">
                <button type="button" onclick="closeModal('modal-add-device')" class="px-4 py-2 text-xs font-medium text-[#697570] hover:text-[#17211F]">
                    Batal
                </button>
                <button type="submit" class="bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-4 py-2 rounded-md transition-colors shadow-xs">
                    Simpan & Ambil QR
                </button>
            </div>
        </form>
    </div>
</div>
