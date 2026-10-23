<div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs mb-6">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-primary text-[20px]">error_outline</span>
        <h2 class="text-base font-bold text-on-surface">6. Format Error & Kode Status HTTP</h2>
    </div>

    <p class="text-xs text-secondary mb-4 leading-relaxed">
        Seluruh kesalahan permintaan mengembalikan format JSON standar dengan objek <code class="font-mono text-primary font-semibold">error</code>:
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- Error Sample Box -->
        <div class="p-4 rounded-xl bg-surface-container font-mono text-[11px] text-on-surface border border-outline-variant/20 md:col-span-1">
            <div class="text-secondary select-none text-[10px] font-sans font-semibold mb-1">Struktur JSON Error:</div>
            <pre class="leading-relaxed"><code>{
  "error": {
    "code": "quota_exceeded",
    "message": "Kuota pesan habis."
  }
}</code></pre>
        </div>

        <!-- HTTP Code Explanations -->
        <div class="overflow-x-auto md:col-span-2">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-outline-variant/30 text-secondary font-medium">
                        <th class="py-1.5 px-2 font-mono">Kode</th>
                        <th class="py-1.5 px-2">Status</th>
                        <th class="py-1.5 px-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 text-[11px]">
                    <tr>
                        <td class="py-1.5 px-2 font-mono text-amber-600 font-bold">400</td>
                        <td class="py-1.5 px-2 font-semibold">Bad Request</td>
                        <td class="py-1.5 px-2 text-secondary">Parameter tidak lengkap atau tenant belum memiliki device aktif.</td>
                    </tr>
                    <tr>
                        <td class="py-1.5 px-2 font-mono text-red-600 font-bold">401</td>
                        <td class="py-1.5 px-2 font-semibold">Unauthorized</td>
                        <td class="py-1.5 px-2 text-secondary">Header Authorization tidak ada atau API key tidak valid / dicabut.</td>
                    </tr>
                    <tr>
                        <td class="py-1.5 px-2 font-mono text-amber-600 font-bold">402</td>
                        <td class="py-1.5 px-2 font-semibold">Payment Required</td>
                        <td class="py-1.5 px-2 text-secondary">Kuota pengiriman bulanan atau harian paket tenant telah habis.</td>
                    </tr>
                    <tr>
                        <td class="py-1.5 px-2 font-mono text-red-600 font-bold">404</td>
                        <td class="py-1.5 px-2 font-semibold">Not Found</td>
                        <td class="py-1.5 px-2 text-secondary">ID pesan atau device tidak ditemukan pada tenant Anda.</td>
                    </tr>
                    <tr>
                        <td class="py-1.5 px-2 font-mono text-purple-600 font-bold">409</td>
                        <td class="py-1.5 px-2 font-semibold">Conflict</td>
                        <td class="py-1.5 px-2 text-secondary">Konflik kunci idempotensi dengan muatan data yang berbeda.</td>
                    </tr>
                    <tr>
                        <td class="py-1.5 px-2 font-mono text-amber-600 font-bold">429</td>
                        <td class="py-1.5 px-2 font-semibold">Rate Limited</td>
                        <td class="py-1.5 px-2 text-secondary">Melebihi batas panggilan request per menit (RPM) paket.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
