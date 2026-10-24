<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-primary text-[20px]">list_alt</span>
        <h2 class="text-base font-bold text-on-surface">2. Ringkasan Endpoint REST API (v1)</h2>
    </div>
    <p class="text-xs text-secondary mb-4">
        Daftar lengkap endpoint publik yang tersedia untuk otomatisasi pengiriman pesan dan manajemen perangkat.
    </p>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-outline-variant/30 text-secondary font-medium">
                    <th class="py-2.5 px-3 w-20">Method</th>
                    <th class="py-2.5 px-3">Endpoint Path</th>
                    <th class="py-2.5 px-3">Fungsi & Kegunaan</th>
                    <th class="py-2.5 px-3 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20 font-mono">
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-blue-500/15 text-blue-600 font-bold">GET</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/devices</td>
                    <td class="py-2 px-3 font-sans text-secondary">Daftar seluruh device dan status koneksi WhatsApp</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">200 OK</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-emerald-500/15 text-primary font-bold">POST</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/devices</td>
                    <td class="py-2 px-3 font-sans text-secondary">Daftarkan device baru (label & webhook URL)</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">201 Created</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-blue-500/15 text-blue-600 font-bold">GET</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/devices/{id}/qr</td>
                    <td class="py-2 px-3 font-sans text-secondary">Ambil QR Code jika device sedang menunggu scan</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">200 OK</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-emerald-500/15 text-primary font-bold">POST</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/devices/{id}/logout</td>
                    <td class="py-2 px-3 font-sans text-secondary">Putuskan sesi koneksi Baileys perangkat</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">200 OK</span></td>
                </tr>
                <tr class="bg-primary/5">
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-emerald-500/15 text-primary font-bold">POST</span></td>
                    <td class="py-2 px-3 text-primary font-bold">/api/v1/messages</td>
                    <td class="py-2 px-3 font-sans text-on-surface font-medium">Kirim pesan WhatsApp (teks, media, spintax)</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-semibold">202 Accepted</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-emerald-500/15 text-primary font-bold">POST</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/messages/bulk</td>
                    <td class="py-2 px-3 font-sans text-secondary">Kirim pesan massal ke banyak nomor sekaligus</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">202 Accepted</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-blue-500/15 text-blue-600 font-bold">GET</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/messages/{id}</td>
                    <td class="py-2 px-3 font-sans text-secondary">Detail status pengiriman & timeline events</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">200 OK</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-blue-500/15 text-blue-600 font-bold">GET</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/messages</td>
                    <td class="py-2 px-3 font-sans text-secondary">Daftar riwayat pesan dengan filter status</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">200 OK</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-emerald-500/15 text-primary font-bold">POST</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/numbers/check</td>
                    <td class="py-2 px-3 font-sans text-secondary">Cek apakah nomor terdaftar di WhatsApp</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">200 OK</span></td>
                </tr>
                <tr>
                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-blue-500/15 text-blue-600 font-bold">GET</span></td>
                    <td class="py-2 px-3 text-on-surface font-semibold">/api/v1/usage</td>
                    <td class="py-2 px-3 font-sans text-secondary">Periksa pemakaian & sisa kuota harian/bulanan</td>
                    <td class="py-2 px-3 text-right"><span class="text-primary font-sans font-medium">200 OK</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-3 p-3 rounded-lg bg-surface-container/60 border border-outline-variant/15 text-[11px] text-secondary flex items-center justify-between">
        <span><strong class="text-on-surface">Alias Kompatibilitas Sistem:</strong> Endpoint <code class="text-primary font-mono font-semibold">POST /send-message</code> dan <code class="text-primary font-mono font-semibold">POST /send-media</code> didukung penuh sebagai drop-in pengganti gateway lain (Sipanda/Fonnte/MPWA).</span>
    </div>
</div>

