<script>
    const devId = <?= json_encode((string)($device['id'] ?? '')) ?>;
    const csrfToken = <?= json_encode(\App\Core\Csrf::token()) ?>;
    const liveQrUrl = "<?= url('/devices/live-qr') ?>/" + devId;
    const pairingUrl = "<?= url('/devices/pairing-code') ?>/" + devId;
    const pollUrl = "<?= url('/devices/poll') ?>/" + devId;

    function switchConnectTab(tab) {
        ['qr', 'pairing'].forEach(t => {
            const isT = t === tab;
            document.getElementById('tab-btn-' + t).classList.toggle('border-primary', isT);
            document.getElementById('tab-btn-' + t).classList.toggle('text-primary', isT);
            document.getElementById('tab-content-' + t).classList.toggle('hidden', !isT);
        });
        if (tab === 'qr') loadLiveQr();
    }

    let qrRetry = 0;
    function loadLiveQr() {
        const loading = document.getElementById('qr-loading');
        const img = document.getElementById('qr-image');
        loading.classList.remove('hidden');
        img.classList.add('hidden');

        fetch(liveQrUrl).then(res => res.json()).then(data => {
            if (data.qr) {
                loading.classList.add('hidden');
                img.src = data.qr;
                img.classList.remove('hidden');
            } else if (data.connected) {
                loading.textContent = 'Perangkat sudah terhubung (' + (data.phone || '') + ')';
                setTimeout(() => { window.location.href = "<?= url('/devices') ?>"; }, 1000);
            } else if (qrRetry < 15) {
                qrRetry++;
                loading.textContent = 'Memuat QR Code WhatsApp... (' + qrRetry + ')';
                setTimeout(loadLiveQr, 1500);
            } else {
                loading.textContent = 'QR Code belum siap. Silakan refresh atau gunakan tab Pairing Code.';
            }
        }).catch(() => {
            if (qrRetry++ < 8) {
                loading.textContent = 'Menghubungkan ke engine Baileys... (' + qrRetry + ')';
                setTimeout(loadLiveQr, 2000);
            } else {
                loading.textContent = 'Engine Baileys sedang offline. Silakan coba kembali.';
            }
        });
    }

    function requestPairingCode() {
        const phone = document.getElementById('pairing-phone').value.trim();
        const btn = document.getElementById('btn-request-pairing');
        if (!phone) return alert('Silakan masukkan nomor WhatsApp Anda');
        btn.disabled = true;
        btn.textContent = 'Meminta kode...';
        fetch(pairingUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ phone, _csrf: csrfToken })
        }).then(res => res.json()).then(data => {
            btn.disabled = false;
            btn.textContent = 'Dapatkan Kode Sandi 8 Digit';
            if (data.pairing_code) {
                document.getElementById('pairing-box').classList.remove('hidden');
                document.getElementById('pairing-code-display').textContent = data.pairing_code;
            } else { alert(data.error || 'Gagal generate pairing code'); }
        }).catch(() => {
            btn.disabled = false;
            btn.textContent = 'Dapatkan Kode Sandi 8 Digit';
            alert('Koneksi engine Baileys terputus');
        });
    }

    const pollTimer = setInterval(() => {
        fetch(pollUrl).then(res => res.json()).then(data => {
            if (data.connected) {
                clearInterval(pollTimer);
                const badge = document.getElementById('socket-status');
                if (badge) {
                    badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#EAF7F0] text-[#16865A]';
                    badge.innerHTML = '? Terhubung (' + (data.phone || '') + ')';
                }
                setTimeout(() => { window.location.href = "<?= url('/devices') ?>"; }, 1500);
            }
        }).catch(() => {});
    }, 2500);

    loadLiveQr();
</script>
