<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="/devices" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1 mb-2">
                ← Kembali ke Daftar Perangkat
            </a>
            <h1 class="text-2xl font-bold text-on-surface tracking-tight font-sans">Hubungkan WhatsApp</h1>
            <p class="text-xs text-secondary mt-1">Perangkat: <strong><?= e($device['label']) ?></strong> (Sesi: <code class="font-mono"><?= e($device['session_ref']) ?></code>)</p>
        </div>
        <div class="flex items-center gap-2">
            <span id="socket-status" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FEF6E7] text-[#D99124]">
                <span class="w-2 h-2 rounded-full bg-[#D99124] animate-pulse"></span>
                Menunggu Pemindaian QR / Kode
            </span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-surface-container-lowest border border-surface-container-high/60 rounded-xl p-6 shadow-xs grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Steps Guide -->
        <div class="lg:col-span-6 space-y-4">
            <h3 class="text-sm font-semibold text-on-surface">Pilih Metode Penghubung:</h3>
            <div class="flex border-b border-surface-container">
                <button type="button" id="tab-btn-qr" onclick="switchConnectTab('qr')" class="py-2 px-4 text-xs font-semibold border-b-2 border-primary text-primary transition-colors">
                    1. Pindai Kode QR (Scan)
                </button>
                <button type="button" id="tab-btn-pairing" onclick="switchConnectTab('pairing')" class="py-2 px-4 text-xs font-semibold border-b-2 border-transparent text-secondary hover:text-on-surface transition-colors">
                    2. Kode Sandi 8-Digit (Tanpa Scan)
                </button>
            </div>

            <div class="p-4 bg-surface-container-low rounded-xl border border-surface-container space-y-2 text-xs text-secondary">
                <p class="font-medium text-on-surface">Panduan Langkah di WhatsApp Ponsel:</p>
                <ol class="list-decimal list-inside space-y-1">
                    <li>Buka aplikasi WhatsApp di HP Anda.</li>
                    <li>Ketuk ikon titik tiga (Android) atau Menu Pengaturan (iPhone).</li>
                    <li>Pilih menu <strong>Perangkat Tertaut</strong>.</li>
                    <li>Ketuk tombol <strong>Tautkan Perangkat</strong>.</li>
                    <li>Arahkan kamera ke QR di samping, atau pilih tautkan dengan nomor telepon.</li>
                </ol>
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="lg:col-span-6">
            <?php require __DIR__ . '/partials/tab_qr.php'; ?>
            <?php require __DIR__ . '/partials/tab_pairing.php'; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/partials/connect_script.php'; ?>
