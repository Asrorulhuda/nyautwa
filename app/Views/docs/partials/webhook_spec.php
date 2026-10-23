<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-primary text-[20px]">webhook</span>
        <h2 class="text-base font-bold text-on-surface">5. Spesifikasi Webhook Masuk & Tanda Terima</h2>
    </div>
    
    <p class="text-xs text-secondary mb-4 leading-relaxed">
        Setiap aktivitas pesan masuk atau perubahan status akan dikirimkan lewat metode <code class="font-mono text-primary font-semibold">POST</code> ke Webhook URL yang Anda konfigurasi pada perangkat.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Webhook Headers & Payload -->
        <div class="space-y-2">
            <span class="text-xs font-semibold text-secondary">Contoh Payload (message.received):</span>
            <pre class="p-4 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20 leading-relaxed"><code>// Header HTTP Masuk:
X-Signature: sha256=9b71d224...
X-Event: message.received
X-Delivery-Id: del_01H9A7K8...

// Request Body JSON:
{
  "event": "message.received",
  "device_id": "<?= e($sampleDeviceId) ?>",
  "message": {
    "id": "msg_01H...",
    "from": "6281234567890",
    "type": "text",
    "text": "Halo admin, mau tanya stok",
    "timestamp": "<?= gmdate('Y-m-d\TH:i:s\Z') ?>"
  }
}</code></pre>
        </div>

        <!-- Signature Verification Code Snippet -->
        <div class="space-y-2">
            <span class="text-xs font-semibold text-secondary">Verifikasi Tanda Tangan (PHP):</span>
            <pre class="p-4 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20 leading-relaxed"><code>$rawBody = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_SIGNATURE'] ?? '';
$secret = 'whsec_kunci_rahasia_device_anda';

$expected = 'sha256=' . hash_hmac('sha256', $rawBody, $secret);

if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    exit('Invalid signature');
}

// Kembalikan 200 OK dalam 10 detik
http_response_code(200);
echo json_encode(['received' => true]);</code></pre>
        </div>
    </div>
</div>
