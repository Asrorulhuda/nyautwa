<!-- WhatsApp Interactive Bubble Preview -->
<div class="lg:col-span-5 bg-surface-container-low border border-surface-container rounded-xl p-5 shadow-xs">
    <div class="text-xs font-semibold text-secondary uppercase tracking-wider mb-3 flex items-center justify-between">
        <span>Pratinjau Pesan Pelanggan</span>
        <span class="inline-flex items-center gap-1 font-mono text-[10px] text-primary">
            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span> Live
        </span>
    </div>

    <!-- Phone Screen Simulation -->
    <div class="bg-[#EFEAE2] rounded-xl p-4 border border-[#D1D7DB] shadow-inner min-h-[260px] flex flex-col justify-end">
        <div class="bg-white rounded-lg p-2.5 shadow-xs max-w-[95%] self-end relative rounded-tr-none border border-black/5 space-y-2">
            <!-- Media Image Preview -->
            <div id="preview-image-box" class="hidden rounded-md overflow-hidden bg-gray-100 max-h-48 border border-black/5">
                <img id="preview-img" src="" alt="Media" class="w-full object-cover">
            </div>

            <!-- Document Preview Card -->
            <div id="preview-doc-box" class="hidden flex items-center gap-2.5 p-2 bg-[#F0F2F5] rounded-md border border-[#D1D7DB]">
                <span class="material-symbols-outlined text-red-600 text-2xl shrink-0">picture_as_pdf</span>
                <div class="min-w-0 flex-1">
                    <span id="preview-doc-name" class="text-xs font-semibold text-[#111B21] block truncate">dokumen.pdf</span>
                    <span class="text-[10px] text-[#667781] font-mono">1.2 MB • Dokumen</span>
                </div>
            </div>

            <!-- Poll Preview Card -->
            <div id="preview-poll-box" class="hidden space-y-2 pt-1">
                <p id="preview-poll-title" class="text-xs font-bold text-[#111B21]">Pertanyaan Polling?</p>
                <div id="preview-poll-items" class="space-y-1.5"></div>
            </div>

            <!-- Main Text & Caption -->
            <p id="preview-text" class="text-xs text-[#111B21] leading-relaxed break-words">
                Halo! Ini adalah contoh pesan WhatsApp yang dikirim melalui NyautWa Gateway.
            </p>

            <!-- Buttons Preview -->
            <div id="preview-buttons-box" class="hidden space-y-1.5 pt-1.5 border-t border-[#E9EDEF]">
                <p id="preview-footer" class="text-[10px] text-[#667781] mb-1">NyautWa Gateway</p>
                <div id="preview-btn-items" class="space-y-1"></div>
            </div>

            <!-- Timestamp & Blue Ticks -->
            <div class="flex items-center justify-end gap-1 text-[10px] text-[#667781] font-mono pt-0.5">
                <span id="preview-time"><?= date('H:i') ?></span>
                <span class="material-symbols-outlined text-xs text-[#53BDEB]">done_all</span>
            </div>
        </div>
    </div>

    <div class="mt-4 p-3 bg-surface-container-lowest border border-surface-container rounded-lg text-xs space-y-1">
        <span class="font-semibold text-on-surface block">Jitter Anti-Ban Aktif</span>
        <p class="text-secondary text-[11px] leading-relaxed">
            Transmisi ke nomor WhatsApp dilakukan via engine Baileys live dengan delay acak aman.
        </p>
    </div>
</div>
