<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-[#16A36A]"></span>
                <span class="text-xs font-semibold text-[#16865A] uppercase tracking-wider">Credentials & Security</span>
            </div>
            <h1 class="text-2xl font-bold text-[#17211F] tracking-tight font-['Geist']">API Keys & Webhooks</h1>
            <p class="text-xs text-[#697570] mt-1">Kelola token rahasia untuk integrasi REST API dan endpoint webhook notifikasi masuk.</p>
        </div>

        <button onclick="openModal('modal-create-key')" class="inline-flex items-center gap-2 bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-4 py-2.5 rounded-md transition-colors shadow-xs">
            <span class="material-symbols-outlined text-sm">add</span>
            Buat API Key Baru
        </button>
    </div>

    <!-- Just Created API Key Alert (One-time Display) -->
    <?php if (!empty($newKey)): ?>
        <div class="bg-[#EAF7F0] border-2 border-[#16A36A] rounded-xl p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-[#16865A] flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">vpn_key</span>
                        Kunci Rahasia Baru: <?= e($newKey['name']) ?>
                    </h3>
                    <p class="text-xs text-[#17211F] mt-1">
                        Salin API Key sekarang. Demi alasan keamanan, token rahasia lengkap <strong>tidak akan pernah ditampilkan lagi</strong> setelah Anda meninggalkan halaman ini.
                    </p>
                    <div class="mt-3 flex items-center gap-2">
                        <code class="px-3 py-2 bg-white border border-[#16A36A]/30 rounded-md font-mono text-xs text-[#17211F] select-all">
                            <?= e($newKey['raw_key']) ?>
                        </code>
                        <button data-copy="<?= e($newKey['raw_key']) ?>" class="bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-3 py-2 rounded-md transition-colors inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">content_copy</span>
                            Salin Token
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Developer Security Guidance Banner -->
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-5 shadow-xs flex items-start gap-4">
        <div class="w-10 h-10 rounded-lg bg-[#EAF7F0] text-[#16865A] flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-xl">shield</span>
        </div>
        <div>
            <h3 class="text-sm font-bold text-[#17211F]">Praktik Keamanan Kunci Rahasia</h3>
            <p class="text-xs text-[#697570] mt-1 leading-relaxed">
                Jaga kerahasiaan API Key Anda. Jangan pernah menyimpan kunci ini di kode frontend publik (seperti single page application atau repositori GitHub publik). Selalu gunakan environment variable (<code class="font-mono text-[11px] bg-[#F6F8F7] px-1.5 py-0.5 rounded">.env</code>) pada backend server Anda.
            </p>
        </div>
    </div>

    <!-- API Keys List Table -->
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-[#E4EAE6] flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-[#17211F]">Daftar API Key Aktif</h3>
                <p class="text-xs text-[#697570]">Token yang memiliki hak akses untuk mengirimkan pesan atas nama tenant Anda.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F6F8F7] text-[#697570] uppercase font-mono text-[10px] tracking-wider border-b border-[#E4EAE6]">
                    <tr>
                        <th class="py-3 px-5">Nama Token</th>
                        <th class="py-3 px-5">Prefix Kunci</th>
                        <th class="py-3 px-5">Dibuat Pada</th>
                        <th class="py-3 px-5">Terakhir Digunakan</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4EAE6]">
                    <?php foreach ($keys as $k): ?>
                        <tr class="hover:bg-[#FAFCFB] transition-colors h-12">
                            <td class="py-3 px-5 font-semibold text-[#17211F]">
                                <?= e($k['name']) ?>
                            </td>
                            <td class="py-3 px-5 font-mono text-[#17211F]">
                                <code class="bg-[#F6F8F7] px-2 py-0.5 rounded border border-[#E4EAE6]">
                                    <?= e($k['prefix']) ?>
                                </code>
                            </td>
                            <td class="py-3 px-5 font-mono text-[#697570] text-[11px]">
                                <?= date('d M Y, H:i', strtotime($k['created_at'])) ?>
                            </td>
                            <td class="py-3 px-5 font-mono text-[#697570] text-[11px]">
                                <?= $k['last_used_at'] ? date('d M Y, H:i', strtotime($k['last_used_at'])) : 'Belum pernah' ?>
                            </td>
                            <td class="py-3 px-5">
                                <?php if ($k['revoked_at']): ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#F0F4F2] text-[#697570]">
                                        Dicabut
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#EAF7F0] text-[#16865A]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#16A36A]"></span>
                                        Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-5 text-right">
                                <?php if (!$k['revoked_at']): ?>
                                    <form action="/api-keys/<?= e($k['id']) ?>/revoke" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mencabut (revoke) API Key ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="text-[#D84B4B] hover:bg-[#FDF0F0] px-2 py-1 rounded text-xs font-semibold transition-colors">
                                            Cabut Kunci
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-[#697570] text-xs">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Webhook Integration Card -->
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4 pb-4 border-b border-[#E4EAE6]">
            <div>
                <h3 class="text-sm font-bold text-[#17211F]">Konfigurasi Webhook Masuk (Inbound & ACK)</h3>
                <p class="text-xs text-[#697570] mt-0.5">Sistem akan mengirimkan HTTP POST event setiap kali ada pesan masuk atau status centang berubah.</p>
            </div>
            <span class="px-2.5 py-1 rounded-full font-mono text-[11px] font-semibold bg-[#EAF7F0] text-[#16865A]">
                HTTP POST • JSON
            </span>
        </div>

        <form action="/webhook/update" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="webhook_url" class="block text-xs font-semibold text-[#17211F] mb-1.5">Target Webhook Endpoint URL</label>
                <div class="flex rounded-md shadow-xs">
                    <input 
                        type="url" 
                        id="webhook_url" 
                        name="webhook_url" 
                        required 
                        value="<?= e($primaryWebhook) ?>"
                        placeholder="https://api.bisnisanda.com/webhook/whatsapp" 
                        class="flex-1 min-w-0 block w-full px-3 py-2 rounded-l-md border border-[#E4EAE6] text-xs font-mono text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                    >
                    <button type="submit" class="bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-4 py-2 rounded-r-md transition-colors shrink-0">
                        Simpan Webhook
                    </button>
                </div>
            </div>
        </form>

        <!-- Webhook Payload Preview (JetBrains Mono dark panel sesuai DESIGN.md) -->
        <div class="mt-6">
            <span class="text-xs font-semibold text-[#697570] block mb-2">Contoh Payload Webhook JSON yang Dikirimkan ke Server Anda:</span>
            <div class="bg-[#17211F] border border-[#28332F] rounded-lg p-4 font-mono text-xs text-[#E7F4ED] overflow-x-auto leading-relaxed">
<pre>{
  <span class="text-[#80FAB9]">"event"</span>: <span class="text-white">"message.received"</span>,
  <span class="text-[#80FAB9]">"timestamp"</span>: <span class="text-white">1729739400</span>,
  <span class="text-[#80FAB9]">"data"</span>: {
    <span class="text-[#80FAB9]">"id"</span>: <span class="text-white">"wamid_BAE58921A"</span>,
    <span class="text-[#80FAB9]">"sender"</span>: <span class="text-white">"+6281234567890"</span>,
    <span class="text-[#80FAB9]">"recipient"</span>: <span class="text-white">"+6281288990011"</span>,
    <span class="text-[#80FAB9]">"type"</span>: <span class="text-white">"text"</span>,
    <span class="text-[#80FAB9]">"body"</span>: <span class="text-white">"Halo, apa paket internet saya masih aktif?"</span>
  }
}</pre>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat API Key Baru -->
<div id="modal-create-key" class="fixed inset-0 bg-[#17211F]/50 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl max-w-md w-full p-6 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-[#17211F]">Buat Kunci API Baru</h3>
            <button onclick="closeModal('modal-create-key')" class="text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <form action="/api-keys/create" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="name" class="block text-xs font-semibold text-[#17211F] mb-1">Nama / Identifikasi Token</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    required 
                    placeholder="Contoh: Backend ERP Server" 
                    class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                >
                <p class="text-[11px] text-[#697570] mt-1">Beri nama deskriptif agar Anda mudah melacak penggunaannya.</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E4EAE6]">
                <button type="button" onclick="closeModal('modal-create-key')" class="px-4 py-2 text-xs font-medium text-[#697570] hover:text-[#17211F]">
                    Batal
                </button>
                <button type="submit" class="bg-[#16A36A] hover:bg-[#128557] text-white text-xs font-semibold px-4 py-2 rounded-md transition-colors shadow-xs">
                    Buat Kunci Rahasia
                </button>
            </div>
        </form>
    </div>
</div>
