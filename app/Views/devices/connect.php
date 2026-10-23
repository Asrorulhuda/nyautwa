<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="/devices" class="text-xs font-semibold text-[#16A36A] hover:underline flex items-center gap-1 mb-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Daftar Perangkat
            </a>
            <h1 class="text-2xl font-bold text-[#17211F] tracking-tight font-['Geist']">Hubungkan WhatsApp (Scan QR)</h1>
            <p class="text-xs text-[#697570] mt-1">Perangkat: <strong><?= e($device['label']) ?></strong> (Sesi: <code class="font-mono"><?= e($device['session_ref']) ?></code>)</p>
        </div>

        <div class="flex items-center gap-2">
            <span id="socket-status" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FEF6E7] text-[#D99124]">
                <span class="w-2 h-2 rounded-full bg-[#D99124] status-pulse"></span>
                Menunggu Pemindaian QR
            </span>
        </div>
    </div>

    <!-- Main QR Card -->
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-8 shadow-xs grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <!-- Step by Step Guide -->
        <div class="lg:col-span-7 space-y-6">
            <div>
                <h2 class="text-base font-bold text-[#17211F] mb-1">Panduan Menautkan Perangkat WhatsApp</h2>
                <p class="text-xs text-[#697570]">Buka WhatsApp pada ponsel yang ingin Anda jadikan gateway pengiriman.</p>
            </div>

            <div class="space-y-4 text-xs">
                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#EAF7F0] text-[#16865A] font-bold font-mono flex items-center justify-center shrink-0 text-xs">1</span>
                    <div>
                        <strong class="text-[#17211F] block text-xs">Buka WhatsApp di Ponsel Anda</strong>
                        <span class="text-[#697570]">Pastikan aplikasi WhatsApp dalam versi terbaru dan memiliki koneksi internet stabil.</span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#EAF7F0] text-[#16865A] font-bold font-mono flex items-center justify-center shrink-0 text-xs">2</span>
                    <div>
                        <strong class="text-[#17211F] block text-xs">Akses Menu "Perangkat Tertaut" (Linked Devices)</strong>
                        <span class="text-[#697570]">Ketuk <strong>Menu (titik tiga)</strong> di pojok kanan atas Android, atau buka menu <strong>Pengaturan</strong> di iPhone.</span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#EAF7F0] text-[#16865A] font-bold font-mono flex items-center justify-center shrink-0 text-xs">3</span>
                    <div>
                        <strong class="text-[#17211F] block text-xs">Ketuk "Tautkan Perangkat"</strong>
                        <span class="text-[#697570]">Buka kunci ponsel dengan sidik jari/PIN jika diminta sistem operasi.</span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#16A36A] text-white font-bold font-mono flex items-center justify-center shrink-0 text-xs">4</span>
                    <div>
                        <strong class="text-[#17211F] block text-xs">Arahkan Kamera ke Kode QR di Samping</strong>
                        <span class="text-[#697570]">Tunggu proses autentikasi socket selesai. Halaman akan otomatis memperbarui status tanpa perlu di-refresh.</span>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-[#F6F8F7] border border-[#E4EAE6] rounded-lg text-xs space-y-1">
                <div class="flex items-center gap-1.5 text-[#16865A] font-semibold">
                    <span class="material-symbols-outlined text-sm">lock</span>
                    Enkripsi End-to-End Dijamin
                </div>
                <p class="text-[#697570] text-[11px]">
                    Sesi terenkripsi secara kriptografis menggunakan library Baileys. Kunci privat sesi tersimpan aman di server lokal.
                </p>
            </div>
        </div>

        <!-- Interactive QR Code Frame -->
        <div class="lg:col-span-5 flex flex-col items-center justify-center p-6 bg-[#F6F8F7] border border-[#E4EAE6] rounded-xl text-center">
            <div class="flex items-center justify-between w-full text-xs text-[#697570] mb-3 px-2">
                <span class="flex items-center gap-1.5 font-medium text-[#16865A]">
                    <span class="w-2 h-2 rounded-full bg-[#16A36A] status-pulse"></span>
                    QR Socket Aktif
                </span>
                <span class="font-mono text-[11px]" id="qr-timer">Refresh: 38s</span>
            </div>

            <!-- QR Box Container -->
            <div class="relative p-6 bg-white rounded-xl border border-[#E4EAE6] shadow-sm flex items-center justify-center">
                <div id="qr-container">
                    <svg class="w-56 h-56 text-[#17211F]" fill="currentColor" viewBox="0 0 240 240" xmlns="http://www.w3.org/2000/svg">
                        <rect fill="#ffffff" height="240" width="240"></rect>
                        <!-- Top-left position marker -->
                        <rect fill="#17211F" height="60" rx="4" width="60" x="20" y="20"></rect>
                        <rect fill="#ffffff" height="44" rx="2" width="44" x="28" y="28"></rect>
                        <rect fill="#16A36A" height="28" rx="2" width="28" x="36" y="36"></rect>
                        <!-- Top-right position marker -->
                        <rect fill="#17211F" height="60" rx="4" width="60" x="160" y="20"></rect>
                        <rect fill="#ffffff" height="44" rx="2" width="44" x="168" y="28"></rect>
                        <rect fill="#16A36A" height="28" rx="2" width="28" x="176" y="36"></rect>
                        <!-- Bottom-left position marker -->
                        <rect fill="#17211F" height="60" rx="4" width="60" x="20" y="160"></rect>
                        <rect fill="#ffffff" height="44" rx="2" width="44" x="28" y="168"></rect>
                        <rect fill="#16A36A" height="28" rx="2" width="28" x="36" y="176"></rect>
                        <!-- Data Modules -->
                        <rect fill="#17211F" height="10" width="10" x="90" y="20"></rect>
                        <rect fill="#17211F" height="20" width="10" x="105" y="20"></rect>
                        <rect fill="#17211F" height="10" width="10" x="120" y="20"></rect>
                        <rect fill="#17211F" height="10" width="15" x="135" y="20"></rect>
                        <rect fill="#17211F" height="10" width="25" x="90" y="35"></rect>
                        <rect fill="#17211F" height="10" width="25" x="125" y="35"></rect>
                        <rect fill="#17211F" height="10" width="15" x="90" y="50"></rect>
                        <rect fill="#17211F" height="15" width="10" x="110" y="50"></rect>
                        <rect fill="#17211F" height="10" width="20" x="130" y="50"></rect>
                        <rect fill="#17211F" height="15" width="10" x="90" y="65"></rect>
                        <rect fill="#17211F" height="10" width="30" x="110" y="70"></rect>
                        <rect fill="#17211F" height="20" width="10" x="20" y="90"></rect>
                        <rect fill="#17211F" height="10" width="20" x="35" y="90"></rect>
                        <rect fill="#17211F" height="10" width="15" x="65" y="90"></rect>
                        <rect fill="#17211F" height="10" width="30" x="20" y="115"></rect>
                        <rect fill="#17211F" height="20" width="20" x="60" y="110"></rect>
                        <rect fill="#17211F" height="15" width="20" x="20" y="135"></rect>
                        <rect fill="#17211F" height="10" width="30" x="50" y="135"></rect>
                        <rect fill="#17211F" height="10" width="20" x="160" y="90"></rect>
                        <rect fill="#17211F" height="10" width="30" x="190" y="90"></rect>
                        <rect fill="#17211F" height="25" width="10" x="160" y="105"></rect>
                        <rect fill="#17211F" height="10" width="20" x="180" y="110"></rect>
                        <rect fill="#17211F" height="20" width="10" x="210" y="110"></rect>
                        <rect fill="#17211F" height="15" width="25" x="160" y="135"></rect>
                        <rect fill="#17211F" height="10" width="25" x="195" y="135"></rect>
                        <rect fill="#17211F" height="10" width="20" x="90" y="160"></rect>
                        <rect fill="#17211F" height="20" width="10" x="120" y="160"></rect>
                        <rect fill="#17211F" height="10" width="15" x="140" y="160"></rect>
                        <rect fill="#17211F" height="10" width="20" x="165" y="160"></rect>
                        <rect fill="#17211F" height="15" width="25" x="195" y="160"></rect>
                        <rect fill="#17211F" height="20" width="15" x="90" y="180"></rect>
                        <rect fill="#17211F" height="10" width="25" x="115" y="185"></rect>
                        <rect fill="#17211F" height="20" width="10" x="150" y="180"></rect>
                        <rect fill="#17211F" height="10" width="20" x="170" y="180"></rect>
                        <rect fill="#17211F" height="10" width="20" x="200" y="185"></rect>
                        <!-- Center WhatsApp Icon Badge -->
                        <rect fill="#ffffff" height="52" rx="8" width="52" x="94" y="94"></rect>
                        <rect fill="#16A36A" height="42" rx="6" width="42" x="99" y="99"></rect>
                        <path d="M120 106C112.8 106 107 111.8 107 119C107 121.6 107.8 124 109.1 126.1L108 131.5L113.6 130.4C115.5 131.4 117.7 132 120 132C127.2 132 133 126.2 133 119C133 111.8 127.2 106 120 106ZM126.2 123.6C125.8 124.6 124.2 125.4 123.3 125.5C122.7 125.6 121.9 125.6 119.5 124.6C116.5 123.3 114.5 120.3 114.3 120.1C114.2 119.9 113.1 118.4 113.1 116.9C113.1 115.4 113.9 114.6 114.2 114.3C114.5 114 114.9 113.9 115.3 113.9C115.4 113.9 115.6 113.9 115.7 113.9C116.1 113.9 116.3 114 116.5 114.4C116.7 115 117.3 116.3 117.3 116.5C117.4 116.7 117.4 116.9 117.3 117.1C117.2 117.3 117.1 117.4 116.9 117.6C116.7 117.8 116.6 117.9 116.4 118.1C116.2 118.3 116 118.5 116.2 118.9C116.4 119.3 117.2 120.5 118.3 121.5C119.7 122.8 120.9 123.2 121.3 123.4C121.6 123.5 121.9 123.5 122.1 123.3C122.4 123 122.7 122.6 123 122.1C123.2 121.8 123.5 121.8 123.8 121.9C124.1 122 125.7 122.8 126 123C126.3 123.1 126.5 123.2 126.5 123.3C126.5 123.4 126.4 124 126.2 123.6Z" fill="#ffffff"></path>
                    </svg>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between w-full px-2">
                <span class="text-[11px] text-[#697570]">Memindai otomatis...</span>
                <button onclick="location.reload()" class="bg-[#FFFFFF] hover:bg-[#F6F8F7] border border-[#E4EAE6] text-xs font-semibold px-3 py-1.5 rounded text-[#17211F] inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                    Muat Ulang
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Auto poll status every 3 seconds
const deviceId = "<?= e($device['id']) ?>";
let countdown = 40;
const timerEl = document.getElementById('qr-timer');

setInterval(() => {
    countdown--;
    if (countdown <= 0) {
        countdown = 40;
    }
    if (timerEl) {
        timerEl.innerText = `Refresh: ${countdown}s`;
    }
}, 1000);

async function checkDeviceStatus() {
    try {
        const res = await fetch(`/devices/${deviceId}/status`);
        if (res.ok) {
            const data = await res.json();
            if (data.status === 'connected') {
                const statusBadge = document.getElementById('socket-status');
                statusBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#EAF7F0] text-[#16865A]';
                statusBadge.innerHTML = '<span class="w-2 h-2 rounded-full bg-[#16A36A] status-pulse"></span>Berhasil Terhubung! Mengalihkan...';
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1200);
            }
        }
    } catch (e) {
        // Silently retry
    }
}

setInterval(checkDeviceStatus, 3000);
</script>
