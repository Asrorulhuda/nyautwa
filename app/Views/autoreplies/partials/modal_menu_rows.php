<div id="field-button" class="hidden space-y-2">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-semibold text-[#17211F]">
            Pilihan Menu & Sub-Menu (Kolom Terpisah)
            <span class="text-[#D84B4B]">*</span>
        </label>
        <button type="button" onclick="addMenuOptionRow('create')" class="inline-flex items-center gap-1 text-xs text-[#16A36A] hover:text-[#128557] font-semibold cursor-pointer">
            <span class="text-sm font-bold">+</span> Tambah Pilihan
        </button>
    </div>

    <div class="bg-[#F6F8F7] p-2.5 rounded-lg border border-[#E4EAE6]">
        <div class="grid grid-cols-12 gap-2 text-[11px] font-semibold text-[#697570] mb-1.5 px-1">
            <div class="col-span-3">Angka / Kode</div>
            <div class="col-span-5">Label Tampilan</div>
            <div class="col-span-3">Keyword Tujuan</div>
            <div class="col-span-1 text-center">✕</div>
        </div>
        <div id="create-menu-options-container" class="space-y-1.5"></div>
    </div>
    <span class="text-[11px] text-[#697570] block">Contoh: Angka <code>1</code>, Label <code>Informasi</code>, Keyword <code>info</code> | Angka <code>0</code>, Label <code>Kembali</code>, Keyword <code>menu</code>.</span>
</div>

<script>
function createMenuRowHtml(k = '', lbl = '', kw = '') {
    return `<div class="grid grid-cols-12 gap-2 items-center menu-row bg-white p-1.5 rounded-md border border-[#E4EAE6]">
        <div class="col-span-3">
            <input type="text" name="menu_keys[]" value="${k}" placeholder="1" class="w-full px-2 py-1 text-xs border border-[#E4EAE6] rounded focus:border-[#16A36A] focus:outline-none font-mono">
        </div>
        <div class="col-span-5">
            <input type="text" name="menu_labels[]" value="${lbl}" placeholder="Informasi Lengkap" class="w-full px-2 py-1 text-xs border border-[#E4EAE6] rounded focus:border-[#16A36A] focus:outline-none">
        </div>
        <div class="col-span-3">
            <input type="text" name="menu_keywords[]" value="${kw}" placeholder="info" class="w-full px-2 py-1 text-xs border border-[#E4EAE6] rounded focus:border-[#16A36A] focus:outline-none font-mono">
        </div>
        <div class="col-span-1 text-center">
            <button type="button" onclick="this.closest('.menu-row').remove()" class="text-[#D84B4B] hover:text-red-700 text-xs font-bold p-1 cursor-pointer" title="Hapus Baris">✕</button>
        </div>
    </div>`;
}

function addMenuOptionRow(prefix = 'create', k = '', lbl = '', kw = '') {
    const c = document.getElementById(`${prefix}-menu-options-container`);
    if (!c) return;
    if (!k && !lbl && !kw) {
        const count = c.querySelectorAll('.menu-row').length + 1;
        k = String(count);
    }
    c.insertAdjacentHTML('beforeend', createMenuRowHtml(k, lbl, kw));
}

document.addEventListener('DOMContentLoaded', function() {
    const c = document.getElementById('create-menu-options-container');
    if (c && c.querySelectorAll('.menu-row').length === 0) {
        addMenuOptionRow('create', '1', 'Informasi', 'info');
        addMenuOptionRow('create', '2', 'Dokumen Panduan', 'dok');
    }
});
</script>
