<script>
    const devId = "<?= e($device['id']) ?>";
    const liveQrUrl = "/devices/live-qr/" + devId;
    const pairingUrl = "/devices/pairing-code/" + devId;
    const pollUrl = "/devices/poll/" + devId;

    function switchConnectTab(tab) {
        document.getElementById('tab-btn-qr').classList.toggle('border-primary', tab === 'qr');
        document.getElementById('tab-btn-qr').classList.toggle('text-primary', tab === 'qr');
        document.getElementById('tab-btn-pairing').classList.toggle('border-primary', tab === 'pairing');
        document.getElementById('tab-btn-pairing').classList.toggle('text-primary', tab === 'pairing');
        document.getElementById('tab-content-qr').classList.toggle('hidden', tab !== 'qr');
        document.getElementById('tab-content-pairing').classList.toggle('hidden', tab !== 'pairing');
        if (tab === 'qr') loadLiveQr();
    }

    function loadLiveQr() {
        const loading = document.getElementById('qr-loading');
        const img = document.getElementById('qr-image');
        loading.classList.remove('hidden');
        img.classList.add('hidden');

        fetch(liveQrUrl, { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                loading.classList.add('hidden');
                if (data.qr) {
                    img.src = data.qr;
                    img.classList.remove('hidden');
                }
            })
            .catch(() => {
                loading.textContent = 'Engine Baileys sedang offline. Jalankan node engine/server.js';
            });
    }

    function requestPairingCode() {
        const phone = document.getElementById('pairing-phone').value.trim();
        const btn = document.getElementById('btn-request-pairing');
        if (!phone) {
            alert('Silakan masukkan nomor WhatsApp Anda terlebih dahulu');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Meminta kode...';
        fetch(pairingUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ phone })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = 'Dapatkan Kode Sandi 8 Digit';
            if (data.pairing_code) {
                document.getElementById('pairing-box').classList.remove('hidden');
                document.getElementById('pairing-code-display').textContent = data.pairing_code;
            } else {
                alert(data.error || 'Gagal generate pairing code');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.textContent = 'Dapatkan Kode Sandi 8 Digit';
            alert('Koneksi engine Baileys terputus');
        });
    }

    // Auto-polling connection state
    setInterval(() => {
        fetch(pollUrl)
            .then(res => res.json())
            .then(data => {
                if (data.connected) {
                    const badge = document.getElementById('socket-status');
                    if (badge) {
                        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#EAF7F0] text-[#16865A]';
                        badge.innerHTML = '● Terhubung (' + (data.phone || '') + ')';
                    }
                    setTimeout(() => { window.location.href = '/devices'; }, 1500);
                }
            })
            .catch(() => {});
    }, 2500);

    loadLiveQr();
</script>
