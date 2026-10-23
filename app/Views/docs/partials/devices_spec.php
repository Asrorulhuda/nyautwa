<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-primary text-[20px]">phone_android</span>
        <h2 class="text-base font-bold text-on-surface">4. Manajemen Perangkat & Utilitas</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Check Number -->
        <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/20 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-on-surface">Cek Nomor WhatsApp</span>
                    <span class="px-2 py-0.5 rounded font-mono text-[10px] bg-emerald-500/15 text-primary font-bold">POST /numbers/check</span>
                </div>
                <p class="text-[11px] text-secondary mb-3">Memverifikasi apakah nomor telepon calon penerima telah terdaftar aktif di WhatsApp.</p>
                <pre class="p-2.5 rounded-lg bg-surface-container-lowest font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20"><code>// Request Body:
{"number": "081234567890"}

// Response 200:
{
  "number": "6281234567890",
  "exists": true,
  "jid": "6281234567890@s.whatsapp.net"
}</code></pre>
            </div>
        </div>

        <!-- Quota Usage -->
        <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/20 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-on-surface">Pengecekan Kuota Tenant</span>
                    <span class="px-2 py-0.5 rounded font-mono text-[10px] bg-blue-500/15 text-blue-600 font-bold">GET /usage</span>
                </div>
                <p class="text-[11px] text-secondary mb-3">Memeriksa sisa kuota pengiriman pesan harian dan bulanan secara programatik.</p>
                <pre class="p-2.5 rounded-lg bg-surface-container-lowest font-mono text-[11px] text-on-surface overflow-x-auto border border-outline-variant/20"><code>// Response 200:
{
  "plan": "starter",
  "monthly_limit": 5000,
  "sent_month": 420,
  "remaining_month": 4580,
  "daily_limit": 500,
  "remaining_today": 475
}</code></pre>
            </div>
        </div>
    </div>
</div>
