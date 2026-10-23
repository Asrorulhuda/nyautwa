<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div>
        <a href="<?= url('/messages') ?>" class="text-xs font-semibold text-[#16A36A] hover:underline flex items-center gap-1 mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Riwayat Pesan
        </a>
        <h1 class="text-2xl font-bold text-[#17211F] tracking-tight font-['Geist']">Kirim Pesan WhatsApp Uji</h1>
        <p class="text-xs text-[#697570] mt-1">Uji coba transmisi pesan langsung ke nomor pelanggan Anda melalui gateway Baileys.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Send Form -->
        <div class="lg:col-span-7 bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-6 shadow-xs">
            <form action="<?= url('/messages/send') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="device_id" class="block text-xs font-semibold text-[#17211F] mb-1.5">Pilih Perangkat Pengirim (Node Sesi)</label>
                    <select 
                        id="device_id" 
                        name="device_id" 
                        required 
                        class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                    >
                        <?php foreach ($devices as $dev): ?>
                            <option value="<?= e($dev['id']) ?>">
                                <?= e($dev['label']) ?> (<?= e($dev['phone'] ?? 'Sesi Standby') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-[#17211F] mb-1.5">Nomor WhatsApp Penerima</label>
                    <div class="flex rounded-md shadow-xs">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[#E4EAE6] bg-[#F6F8F7] text-[#697570] text-xs font-mono font-medium">
                            +62
                        </span>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            required 
                            placeholder="81234567890" 
                            value="<?= e(old('phone')) ?>"
                            oninput="updatePreviewPhone(this.value)"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-[#E4EAE6] text-sm font-mono text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                        >
                    </div>
                    <p class="text-[11px] text-[#697570] mt-1">Dapat ditulis dengan awalan 08 atau 8 (otomatis dinormalisasi ke format internasional).</p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="body" class="block text-xs font-semibold text-[#17211F]">Isi Pesan WhatsApp</label>
                        <span class="text-[11px] text-[#697570] font-mono" id="char-count">0 karakter</span>
                    </div>
                    <textarea 
                        id="body" 
                        name="body" 
                        rows="5" 
                        required 
                        placeholder="Ketik isi pesan WhatsApp di sini... (Mendukung emoji dan format teks)" 
                        oninput="updatePreviewBody(this.value)"
                        class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]"
                    ><?= e(old('body', "Halo Kak, terima kasih telah berbelanja di toko kami! Pesanan Anda telah kami proses dan akan segera dikirimkan.")) ?></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#16A36A] hover:bg-[#128557] text-white text-sm font-semibold py-2.5 rounded-md transition-colors shadow-xs flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">send</span>
                        Kirim Pesan ke Antrean
                    </button>
                </div>
            </form>
        </div>

        <!-- WhatsApp Chat Bubble Preview (Sesuai docs/wa-gateway-prd/docs/04-ui-ux.md) -->
        <div class="lg:col-span-5 bg-[#EAE6DF] border border-[#D1D7DB] rounded-xl p-5 shadow-xs overflow-hidden relative">
            <div class="text-[11px] font-semibold text-[#54656F] uppercase tracking-wider mb-4 flex items-center justify-between">
                <span>Pratinjau Tampilan Pesan</span>
                <span class="font-mono text-[10px] bg-white/70 px-2 py-0.5 rounded text-[#54656F]" id="preview-phone">+62 812-3456-7890</span>
            </div>

            <!-- WhatsApp Chat Background & Bubble -->
            <div class="min-h-[220px] flex flex-col justify-end">
                <div class="bg-[#D9FDD3] text-[#111B21] rounded-lg rounded-tr-none p-3 shadow-xs max-w-[85%] self-end relative text-xs leading-relaxed">
                    <p id="preview-bubble" class="whitespace-pre-wrap break-words font-sans">
                        Halo Kak, terima kasih telah berbelanja di toko kami! Pesanan Anda telah kami proses dan akan segera dikirimkan.
                    </p>
                    <div class="flex items-center justify-end gap-1 mt-1 text-[10px] text-[#667781] font-mono select-none">
                        <span><?= date('H:i') ?></span>
                        <span class="material-symbols-outlined text-xs fill text-[#53BDEB]">done_all</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-[#D1D7DB] text-center text-[10px] text-[#54656F]">
                Tampilan persis seperti yang akan diterima di layar WhatsApp pengguna.
            </div>
        </div>
    </div>
</div>

<script>
function updatePreviewBody(text) {
    const bubble = document.getElementById('preview-bubble');
    const counter = document.getElementById('char-count');
    bubble.innerText = text || 'Ketik isi pesan di formulir...';
    counter.innerText = `${text.length} karakter`;
}

function updatePreviewPhone(num) {
    const el = document.getElementById('preview-phone');
    const clean = num.replace(/[^0-9]/g, '');
    el.innerText = clean ? `+62 ${clean}` : '+62 8...';
}

// Initial trigger
document.addEventListener('DOMContentLoaded', () => {
    const bodyEl = document.getElementById('body');
    if (bodyEl) updatePreviewBody(bodyEl.value);
});
</script>
