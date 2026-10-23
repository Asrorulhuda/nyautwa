<!-- Developer Experience Section -->
<section class="py-20 lg:py-24 bg-surface-container-lowest scroll-mt-20" id="api">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
            <!-- Text details -->
            <div class="lg:col-span-5">
                <span class="text-xs uppercase tracking-wider text-primary font-semibold mb-2 block">Dokumentasi Developer</span>
                <h2 class="text-3xl font-bold text-on-surface mb-4">Didesain oleh developer, untuk developer.</h2>
                <p class="text-base text-on-surface-variant mb-6 leading-relaxed">
                    NyautWa menghilangkan kompleksitas manajemen protokol internal WhatsApp. Cukup kirim payload JSON terstruktur, dan gateway kami menangani antrean transmisi, retries otomatis, dan webhook notifications.
                </p>
                <ul class="space-y-3.5 mb-8">
                    <li class="flex items-center gap-3 text-on-surface text-sm">
                        <span class="material-symbols-outlined text-primary text-[20px]">check</span>
                        <span>Respon standar RFC 7807 problem details</span>
                    </li>
                    <li class="flex items-center gap-3 text-on-surface text-sm">
                        <span class="material-symbols-outlined text-primary text-[20px]">check</span>
                        <span>Verifikasi signature HMAC SHA-256 pada tiap webhook</span>
                    </li>
                    <li class="flex items-center gap-3 text-on-surface text-sm">
                        <span class="material-symbols-outlined text-primary text-[20px]">check</span>
                        <span>Rate limiter terisolasi per token API</span>
                    </li>
                </ul>
                <div class="flex items-center gap-4">
                    <a class="inline-flex items-center gap-2 px-5 py-3 bg-primary text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-primary-container transition-colors" href="<?= url('/api-keys') ?>">
                        <span class="material-symbols-outlined text-[18px]">menu_book</span>
                        <span>Baca Dokumentasi API</span>
                    </a>
                </div>
            </div>
            <!-- Interactive API Snippet -->
            <div class="lg:col-span-7">
                <div class="bg-inverse-surface rounded-xl shadow-xl overflow-hidden border border-surface-container-highest/20">
                    <div class="flex items-center justify-between px-5 pt-3.5 bg-inverse-surface border-b border-surface-container-highest/15">
                        <div class="flex items-center gap-1.5">
                            <span class="px-3.5 py-2 text-xs font-mono rounded-t font-semibold bg-surface-container-highest/20 text-inverse-on-surface">cURL</span>
                            <span class="px-3.5 py-2 text-xs font-mono rounded-t font-medium text-tertiary-fixed-dim">Node.js</span>
                            <span class="px-3.5 py-2 text-xs font-mono rounded-t font-medium text-tertiary-fixed-dim">Python</span>
                            <span class="px-3.5 py-2 text-xs font-mono rounded-t font-medium text-tertiary-fixed-dim">PHP</span>
                            <span class="px-3.5 py-2 text-xs font-mono rounded-t font-medium text-tertiary-fixed-dim">Go</span>
                        </div>
                        <button class="flex items-center gap-1.5 px-3 py-1.5 rounded text-tertiary-fixed-dim hover:text-inverse-on-surface text-xs font-mono transition-colors" id="copy-btn">
                            <span class="material-symbols-outlined text-[16px]">content_copy</span>
                            <span>Salin</span>
                        </button>
                    </div>
                    <div class="p-6 text-xs font-mono overflow-x-auto text-surface-container-lowest leading-relaxed">
<pre><code><span class="text-tertiary-fixed-dim"># Kirim pesan teks tunggal via NyautWa API</span>
curl -X POST <?= url('/api/v1/messages') ?> \
  -H <span class="text-secondary-fixed">"Authorization: Bearer nyaut_live_948f2178ad99e120"</span> \
  -H <span class="text-secondary-fixed">"Content-Type: application/json"</span> \
  -d <span class="text-primary-fixed-dim">'{
    "phone": "081234567890",
    "message": "Pesanan Anda sedang diproses."
  }'</span></code></pre>
                    </div>
                    <div class="px-6 py-3.5 bg-surface-container-highest/10 border-t border-surface-container-highest/15 flex items-center justify-between text-tertiary-fixed-dim text-xs font-mono">
                        <span>Status: <strong class="text-primary-fixed font-semibold">202 Accepted</strong></span>
                        <span class="font-mono text-[11px]">Respon: RFC 7807 JSON</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
