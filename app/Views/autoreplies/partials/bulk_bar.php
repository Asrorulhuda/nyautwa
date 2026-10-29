<!-- Floating Bulk Action Bar for AutoReplies -->
<div id="reply-bulk-bar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-[#17211F] text-white px-5 py-3 rounded-xl shadow-2xl border border-white/10 flex items-center gap-4 transition-all animate-bounce-once">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-[#16A36A] text-xl">check_box</span>
        <span id="bulk-selected-count" class="text-xs font-semibold font-mono">0 aturan dipilih</span>
    </div>
    <div class="h-4 w-px bg-white/20"></div>
    <form id="bulk-delete-form" action="<?= url('/autoreplies/bulk-delete') ?>" method="POST" onsubmit="return confirm('Hapus seluruh aturan balas otomatis yang dipilih secara permanen?')">
        <?= csrf_field() ?>
        <div id="bulk-inputs-container"></div>
        <button type="submit" class="bg-[#D84B4B] hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition-colors flex items-center gap-1 cursor-pointer">
            <span class="material-symbols-outlined text-[15px]">delete_sweep</span>
            <span>Hapus Terpilih</span>
        </button>
    </form>
    <button type="button" onclick="clearAllSelections()" class="text-xs text-white/70 hover:text-white underline cursor-pointer">Batal</button>
</div>

<script>
function toggleSelectAll(master) {
    const checkboxes = document.querySelectorAll('.reply-checkbox');
    checkboxes.forEach(cb => { cb.checked = master.checked; });
    updateSelectionBar();
}

function updateSelectionBar() {
    const checkboxes = document.querySelectorAll('.reply-checkbox:checked');
    const bar = document.getElementById('reply-bulk-bar');
    const countEl = document.getElementById('bulk-selected-count');
    const container = document.getElementById('bulk-inputs-container');
    const master = document.getElementById('check-all');

    if (!bar || !countEl || !container) return;

    container.innerHTML = '';
    const total = document.querySelectorAll('.reply-checkbox').length;
    if (master) {
        master.checked = (checkboxes.length > 0 && checkboxes.length === total);
    }

    if (checkboxes.length > 0) {
        countEl.textContent = `${checkboxes.length} aturan dipilih`;
        checkboxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            container.appendChild(input);
        });
        bar.classList.remove('hidden');
        bar.classList.add('flex');
    } else {
        bar.classList.add('hidden');
        bar.classList.remove('flex');
    }
}

function clearAllSelections() {
    const master = document.getElementById('check-all');
    if (master) master.checked = false;
    document.querySelectorAll('.reply-checkbox').forEach(cb => { cb.checked = false; });
    updateSelectionBar();
}
</script>
