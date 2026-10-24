<div id="tab-content-qr" class="p-6 bg-surface-container-low border border-surface-container rounded-xl text-center">
    <div class="flex items-center justify-between w-full text-xs text-secondary mb-3 px-2">
        <span class="flex items-center gap-1.5 font-medium text-primary">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            Baileys QR Engine Live
        </span>
        <button type="button" onclick="loadLiveQr()" class="text-xs text-primary hover:underline font-medium">Muat Ulang QR</button>
    </div>

    <!-- QR Image Container -->
    <div class="relative p-4 bg-white rounded-xl border border-surface-container shadow-sm flex items-center justify-center min-h-[280px]">
        <div id="qr-loading" class="text-xs text-secondary flex flex-col items-center gap-2">
            <div class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
            <span>Menghubungkan ke Baileys Engine...</span>
        </div>
        <img id="qr-image" src="" alt="WhatsApp QR Code" class="hidden max-w-[260px] h-auto rounded-lg">
    </div>

    <p class="text-[11px] text-secondary mt-4">
        Arahkan kamera WhatsApp ponsel Anda ke kode QR di atas untuk menghubungkan sesi secara instan.
    </p>
</div>
