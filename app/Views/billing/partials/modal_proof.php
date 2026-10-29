<!-- Modal Lihat Bukti Pembayaran -->
<div id="modal-view-proof" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-lg rounded-2xl bg-white p-5 shadow-2xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <div>
                <h3 class="text-sm font-bold text-[#17211F]">Bukti Pembayaran / Transfer</h3>
                <p id="proof-invoice-label" class="text-xs text-[#697570] font-mono mt-0.5"></p>
            </div>
            <button onclick="closeModal('modal-view-proof')" type="button" class="p-1 rounded-lg text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="flex items-center justify-center p-2 rounded-xl bg-[#F6F8F7] border border-[#E4EAE6] min-h-[240px] max-h-[70vh] overflow-hidden">
            <img id="proof-img" src="" alt="Bukti Transfer" class="max-h-[65vh] w-auto object-contain rounded-lg shadow-xs">
            <iframe id="proof-pdf" src="" class="w-full h-[65vh] hidden rounded-lg border-0"></iframe>
        </div>
        <div class="flex items-center justify-between pt-2">
            <a id="proof-download-link" href="#" target="_blank" class="text-xs font-semibold text-[#16A36A] hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">open_in_new</span> Buka Ukuran Penuh
            </a>
            <button onclick="closeModal('modal-view-proof')" type="button" class="px-4 py-1.5 rounded-lg bg-[#F6F8F7] text-[#17211F] text-xs font-semibold hover:bg-[#E4EAE6]">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Unggah Bukti Pembayaran -->
<div id="modal-upload-proof" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-4">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-[#E4EAE6] space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-[#E4EAE6]">
            <h3 class="text-sm font-bold text-[#17211F]">Unggah Bukti Pembayaran</h3>
            <button onclick="closeModal('modal-upload-proof')" type="button" class="p-1 rounded-lg text-[#697570] hover:text-[#17211F]">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form id="form-upload-proof" action="" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            <?= csrf_field() ?>
            <input type="hidden" name="redirect_to" value="<?= url('/billing') ?>">
            <div>
                <label class="block font-medium text-[#17211F] mb-1">Invoice:</label>
                <div id="upload-invoice-label" class="font-mono text-xs font-bold text-[#16A36A] bg-[#EAF7F0] px-3 py-2 rounded-lg"></div>
            </div>
            <div>
                <label class="block font-medium text-[#17211F] mb-1">File Foto / Struk / Screenshot Transfer *</label>
                <input type="file" name="proof" required accept="image/*,application/pdf" class="w-full text-xs text-[#697570] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#EAF7F0] file:text-[#16A36A] hover:file:bg-[#16A36A]/20 cursor-pointer">
                <span class="text-[10.5px] text-[#697570] block mt-1">Mendukung format JPG, PNG, WEBP, atau PDF (maks. 5MB)</span>
            </div>
            <div class="pt-3 border-t border-[#E4EAE6] flex items-center justify-end gap-2">
                <button onclick="closeModal('modal-upload-proof')" type="button" class="px-3.5 py-1.5 rounded-lg bg-[#F6F8F7] text-[#697570] font-semibold hover:bg-[#E4EAE6]">Batal</button>
                <button type="submit" class="px-4 py-1.5 rounded-lg bg-[#16A36A] text-white font-semibold hover:bg-[#128557] shadow-xs">Unggah Bukti</button>
            </div>
        </form>
    </div>
</div>

<script>
function viewPaymentProof(url, invNo) {
    document.getElementById('proof-invoice-label').innerText = 'Invoice: ' + invNo;
    document.getElementById('proof-download-link').href = url;
    const isPdf = url.toLowerCase().endsWith('.pdf');
    const imgEl = document.getElementById('proof-img');
    const pdfEl = document.getElementById('proof-pdf');
    if (isPdf) {
        imgEl.classList.add('hidden');
        pdfEl.classList.remove('hidden');
        pdfEl.src = url;
    } else {
        pdfEl.classList.add('hidden');
        imgEl.classList.remove('hidden');
        imgEl.src = url;
    }
    openModal('modal-view-proof');
}
function uploadPaymentProof(invId, invNo) {
    document.getElementById('upload-invoice-label').innerText = invNo;
    document.getElementById('form-upload-proof').action = '<?= url('/invoices') ?>/' + encodeURIComponent(invId) + '/proof';
    openModal('modal-upload-proof');
}
</script>
