<div id="tab-content-pairing" class="hidden p-6 bg-surface-container-low border border-surface-container rounded-xl text-center space-y-4">
    <div class="text-left">
        <h4 class="text-sm font-semibold text-on-surface">Tautkan dengan Nomor Telepon</h4>
        <p class="text-xs text-secondary mt-0.5">Dapatkan 8-digit kode sandi tanpa perlu mengarahkan kamera ke layar monitor.</p>
    </div>

    <div class="space-y-3 text-left">
        <div>
            <label class="block text-xs font-semibold text-on-surface mb-1">Nomor WhatsApp Anda (Contoh: 6281234567890)</label>
            <input type="text" id="pairing-phone" value="<?= e($device['phone'] ?? '') ?>" placeholder="6281234567890" class="w-full px-3 py-2 text-sm font-mono border border-surface-container rounded-md focus:border-primary focus:outline-none bg-white">
        </div>
        <button type="button" onclick="requestPairingCode()" id="btn-request-pairing" class="w-full py-2.5 px-4 text-xs font-semibold text-white bg-primary hover:bg-primary/90 rounded-md transition-colors shadow-sm">
            Dapatkan Kode Sandi 8 Digit
        </button>
    </div>

    <!-- Display Pairing Code Box -->
    <div id="pairing-box" class="hidden p-4 bg-white rounded-xl border border-primary/40 shadow-sm space-y-2">
        <span class="text-xs text-secondary font-medium">Masukkan kode ini pada WhatsApp di HP Anda:</span>
        <div id="pairing-code-display" class="font-mono text-2xl font-bold tracking-widest text-primary py-2 bg-surface-container-low rounded-lg border border-surface-container">
            ---- ----
        </div>
        <p class="text-[11px] text-secondary">
            Buka WhatsApp di HP > Perangkat Tertaut > Tautkan Perangkat > Tautkan dengan nomor telepon saja.
        </p>
    </div>
</div>
