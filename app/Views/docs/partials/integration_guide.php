<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[22px]">integration_instructions</span>
            <h2 class="text-base font-bold text-on-surface">Panduan Integrasi Aplikasi Eksternal & Sipanda</h2>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-1 rounded-full font-mono text-[11px] font-bold bg-emerald-500/15 text-primary border border-emerald-500/20">Drop-in Compatible</span>
            <a href="<?= url('/docs/download-pdf') ?>" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-primary hover:bg-primary-container text-white text-xs font-semibold shadow-xs transition-colors" title="Download Panduan Format PDF">
                <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                <span>Download PDF</span>
            </a>
        </div>
    </div>


    <p class="text-xs text-secondary mb-5 leading-relaxed">
        NyautWa menyediakan kompatibilitas drop-in penuh untuk sistem web, ERP, CRM, kasir, dan aplikasi sekolah seperti <strong class="text-on-surface font-semibold">Sipanda2</strong>. Anda dapat menghubungkan aplikasi langsung tanpa perlu mengubah script kode aplikasi pengirim.
    </p>

    <!-- 1. Drop-In Config Box for Sipanda / Fonnte / MPWA -->
    <div class="p-4 rounded-xl bg-surface-container/60 border border-outline-variant/25 mb-5 space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-on-surface flex items-center gap-1.5">
                <span class="material-symbols-outlined text-primary text-[18px]">settings_suggest</span>
                Konfigurasi Cepat di Menu Pengaturan Aplikasi (Contoh: Sipanda2)
            </span>
            <span class="text-[11px] text-secondary font-sans">Tanpa Ubah Source Code</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 font-mono text-xs">
            <div class="p-3 rounded-lg bg-surface-container-lowest border border-outline-variant/20">
                <div class="text-secondary text-[11px] font-sans font-semibold mb-1">WA Target URL:</div>
                <div class="text-primary font-bold break-all select-all"><?= url('/send-message') ?></div>
            </div>
            <div class="p-3 rounded-lg bg-surface-container-lowest border border-outline-variant/20">
                <div class="text-secondary text-[11px] font-sans font-semibold mb-1">WA Token / API Key:</div>
                <div class="text-emerald-700 font-bold break-all select-all"><?= e($apiKeyPrefix) ?>_live_token</div>
            </div>
            <div class="p-3 rounded-lg bg-surface-container-lowest border border-outline-variant/20">
                <div class="text-secondary text-[11px] font-sans font-semibold mb-1">WA Sender Utama:</div>
                <div class="text-on-surface font-bold select-all"><?= e($samplePhone) ?></div>
            </div>
        </div>
    </div>

    <!-- 2. Code Snippets in Tabs / Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- PHP Native / cURL -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                <span>PHP (cURL)</span><span class="text-[10px] text-outline">Native</span>
            </div>
            <pre class="p-3.5 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20 leading-relaxed"><code>$data = ['to' => '081234567890', 'text' => 'Halo!'];
$ch = curl_init('<?= url('/api/v1/messages') ?>');
curl_setopt_array($ch, [
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => ['Authorization: Bearer YOUR_API_KEY', 'Content-Type: application/json']
]);
$res = curl_exec($ch);
curl_close($ch);</code></pre>
        </div>

        <!-- Laravel -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                <span>Laravel</span><span class="text-[10px] text-outline">Http Client</span>
            </div>
            <pre class="p-3.5 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20 leading-relaxed"><code>use Illuminate\Support\Facades\Http;

$res = Http::withToken('YOUR_API_KEY')
  ->post('<?= url('/api/v1/messages') ?>', [
    'to' => '081234567890',
    'text' => 'Halo dari Laravel!'
  ]);
$data = $res->json();</code></pre>
        </div>

        <!-- Node.js / JavaScript -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between text-xs font-semibold text-secondary">
                <span>Node.js</span><span class="text-[10px] text-outline">Axios</span>
            </div>
            <pre class="p-3.5 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20 leading-relaxed"><code>const axios = require('axios');

await axios.post('<?= url('/api/v1/messages') ?>', {
  to: '081234567890',
  text: 'Halo dari Node.js!'
}, {
  headers: { 'Authorization': 'Bearer YOUR_API_KEY' }
});</code></pre>
        </div>
    </div>
</div>

