<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="<?= url('/devices') ?>" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1 mb-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Daftar Perangkat
            </a>
            <h1 class="text-2xl font-bold text-on-surface tracking-tight font-sans">Hubungkan WhatsApp (Scan QR)</h1>
            <p class="text-xs text-secondary mt-1">Perangkat: <strong><?= e($device['label']) ?></strong> (Sesi: <code class="font-mono"><?= e($device['session_ref']) ?></code>)</p>
        </div>
        <div class="flex items-center gap-2">
            <span id="socket-status" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FEF6E7] text-[#D99124]">
                <span class="w-2 h-2 rounded-full bg-[#D99124] animate-pulse"></span>
                Menunggu Pemindaian QR
            </span>
        </div>
    </div>

    <!-- Main QR Card -->
    <div class="bg-surface-container-lowest border border-surface-container-high/60 rounded-xl p-8 shadow-xs grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <!-- Step by Step Guide -->
        <?php require __DIR__ . '/partials/guide_steps.php'; ?>

        <!-- Interactive QR Code Frame -->
        <div class="lg:col-span-5 flex flex-col items-center justify-center p-6 bg-surface-container-low border border-surface-container rounded-xl text-center">
            <div class="flex items-center justify-between w-full text-xs text-secondary mb-3 px-2">
                <span class="flex items-center gap-1.5 font-medium text-primary">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    QR Socket Aktif
                </span>
                <span class="font-mono text-[11px]" id="qr-timer">Refresh: 38s</span>
            </div>

            <!-- QR Box Container -->
            <div class="relative p-6 bg-white rounded-xl border border-surface-container shadow-sm flex items-center justify-center">
                <div id="qr-container">
                    <?php require __DIR__ . '/partials/qr_svg.php'; ?>
                </div>
            </div>

            <p class="text-[11px] text-secondary mt-4">
                Kode QR diperbarui otomatis oleh Baileys socket engine.
            </p>
        </div>
    </div>
</div>

<script>
    // QR Polling Script
    const deviceId = "<?= e($device['id']) ?>";
    const statusUrl = "<?= url('/devices/status/') ?>" + deviceId;
    let timerSec = 40;

    setInterval(() => {
        timerSec--;
        if (timerSec <= 0) timerSec = 40;
        const el = document.getElementById('qr-timer');
        if (el) el.textContent = 'Refresh: ' + timerSec + 's';
    }, 1000);

    const checkStatus = () => {
        fetch(statusUrl)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'connected') {
                    const badge = document.getElementById('socket-status');
                    if (badge) {
                        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-surface-container-low text-primary';
                        badge.innerHTML = '<span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Terhubung (' + (data.phone || '') + ')';
                    }
                    setTimeout(() => { window.location.href = "<?= url('/devices') ?>"; }, 2000);
                }
            }).catch(() => {});
    };
    setInterval(checkStatus, 3000);
</script>
