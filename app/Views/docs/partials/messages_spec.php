<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[20px]">send</span>
            <h2 class="text-base font-bold text-on-surface">3. Mengirim Pesan WhatsApp</h2>
        </div>
        <span class="px-2 py-0.5 rounded font-mono text-[11px] font-bold bg-emerald-500/15 text-primary">POST /api/v1/messages</span>
    </div>
    
    <p class="text-xs text-secondary mb-4 leading-relaxed">
        API segera membalas <code class="font-mono text-primary font-semibold">202 Accepted</code> setelah pesan divalidasi dan dijadwalkan ke antrean gateway. Pengiriman aktual dan tanda terima (delivered/read) dilaporkan via webhook.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Request Example (cURL) -->
        <div class="space-y-2">
            <span class="text-xs font-semibold text-secondary">Contoh Request (cURL):</span>
            <pre class="p-4 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20 leading-relaxed"><code>curl -X POST <?= url('/api/v1/messages') ?> \
  -H "Authorization: Bearer <?= e($apiKeyPrefix) ?>_sample_key" \
  -H "Content-Type: application/json" \
  -d '{
    "device_id": "<?= e($sampleDeviceId) ?>",
    "to": "6281234567890",
    "type": "text",
    "text": "{Halo|Hai} Pesanan #1042 sudah dikirim.",
    "idempotency_key": "order-1042-shipped"
  }'</code></pre>
        </div>

        <!-- Response Example -->
        <div class="space-y-2">
            <span class="text-xs font-semibold text-secondary">Respons 202 Accepted:</span>
            <pre class="p-4 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20 leading-relaxed"><code>{
  "id": "msg_01H9A7K8...",
  "status": "queued"
}</code></pre>
            <div class="p-3 rounded-lg bg-surface-container/60 border border-outline-variant/15 text-[11px] text-secondary">
                <strong class="text-on-surface">Catatan Spintax:</strong> Gunakan sintaks <code class="text-primary font-mono">{Halo|Hai|Pagi}</code> untuk merotasi pembuka pesan secara dinamis guna menurunkan risiko banned.
            </div>
        </div>
    </div>
</div>
