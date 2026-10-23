<!-- WhatsApp Interactive Bubble Preview -->
<div class="lg:col-span-5 bg-surface-container-low border border-surface-container rounded-xl p-5 shadow-xs">
    <div class="text-xs font-semibold text-secondary uppercase tracking-wider mb-3 flex items-center justify-between">
        <span>Pratinjau Pesan Pelanggan</span>
        <span class="inline-flex items-center gap-1 font-mono text-[10px] text-primary">
            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span> Live
        </span>
    </div>

    <!-- Phone Screen Simulation -->
    <div class="bg-[#EFEAE2] rounded-xl p-4 border border-[#D1D7DB] shadow-inner min-h-[220px] flex flex-col justify-end">
        <div class="bg-white rounded-lg p-3 shadow-xs max-w-[90%] self-end relative rounded-tr-none border border-black/5">
            <p id="preview-text" class="text-xs text-[#111B21] leading-relaxed break-words">
                Halo! Ini adalah contoh pesan WhatsApp yang dikirim melalui NyautWa Gateway.
            </p>
            <div class="flex items-center justify-end gap-1 mt-1 text-[10px] text-[#667781] font-mono">
                <span id="preview-time"><?= date('H:i') ?></span>
                <span class="material-symbols-outlined text-xs text-[#53BDEB]">done_all</span>
            </div>
        </div>
    </div>

    <div class="mt-4 p-3 bg-surface-container-lowest border border-surface-container rounded-lg text-xs space-y-1">
        <span class="font-semibold text-on-surface block">Jitter Anti-Ban Aktif</span>
        <p class="text-secondary text-[11px] leading-relaxed">
            Pesan keluar akan diberi jeda acak 2-5 detik untuk menghindari deteksi spam WhatsApp.
        </p>
    </div>
</div>
