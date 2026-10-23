<!-- Quick Documentation Reference Card -->
<div class="bg-inverse-surface rounded-2xl p-6 text-inverse-on-surface shadow-xl relative overflow-hidden mb-6">
    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="flex flex-col gap-2 max-w-xl">
            <div class="flex items-center gap-2 text-primary-fixed">
                <span class="material-symbols-outlined text-[20px]">terminal</span>
                <span class="font-mono text-xs font-semibold uppercase tracking-wider">Quick Integration</span>
            </div>
            <h2 class="text-xl text-white font-bold">
                Cara Menggunakan API Key di Header Request
            </h2>
            <p class="text-xs text-inverse-on-surface/80">
                Sertakan kunci rahasia Anda pada header Authorization sebagai Bearer token di setiap permintaan HTTP ke endpoint resmi NyautWa.
            </p>
        </div>
        <!-- Code Snippet Box -->
        <div class="w-full lg:max-w-lg bg-[#080f0d] rounded-xl p-4 shadow-inner flex flex-col gap-2 border border-white/5">
            <div class="flex items-center justify-between pb-2 border-b border-white/10 text-xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-error"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#fbbc04]"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    <span class="font-mono text-outline-variant ml-2 text-[11px]">cURL Request</span>
                </div>
                <button class="font-mono text-emerald-300 hover:text-white transition-colors flex items-center gap-1 cursor-pointer text-[11px]" onclick="copyToClipboard('curl -X POST <?= url('/api/v1/messages') ?> \\\n  -H &quot;Authorization: Bearer YOUR_API_KEY&quot; \\\n  -H &quot;Content-Type: application/json&quot;')" type="button">
                    <span class="material-symbols-outlined text-[13px]">content_copy</span>
                    <span>Salin</span>
                </button>
            </div>
            <pre class="font-mono text-xs text-inverse-on-surface overflow-x-auto py-1 leading-relaxed"><code><span class="text-emerald-400">curl</span> -X POST <?= url('/api/v1/messages') ?> \
  -H <span class="text-emerald-300">"Authorization: Bearer YOUR_API_KEY"</span> \
  -H <span class="text-emerald-300">"Content-Type: application/json"</span> \
  -d '{<span class="text-emerald-300">"phone"</span>: <span class="text-white">"08123456789"</span>, <span class="text-emerald-300">"message"</span>: <span class="text-white">"Halo!"</span>}'</code></pre>
        </div>
    </div>
</div>
