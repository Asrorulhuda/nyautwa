<!-- Floating Bulk Action Bar -->
<div id="bulk-action-bar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-[#17211F] text-white px-5 py-3 rounded-xl shadow-2xl border border-white/10 flex items-center gap-4 transition-all animate-bounce-once">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-primary text-xl">check_box</span>
        <span id="bulk-selected-count" class="text-xs font-semibold font-mono">0 pesan dipilih</span>
    </div>
    <div class="h-4 w-px bg-white/20"></div>
    <form id="bulk-delete-form" action="<?= url('/messages/bulk-delete') ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh pesan yang dipilih secara permanen?')">
        <?= csrf_field() ?>
        <div id="bulk-inputs-container"></div>
        <button type="submit" class="bg-error hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition-colors flex items-center gap-1 cursor-pointer">
            <span class="material-symbols-outlined text-[15px]">delete_sweep</span>
            Hapus Terpilih
        </button>
    </form>
    <button type="button" onclick="clearAllSelections()" class="text-xs text-white/70 hover:text-white underline cursor-pointer">Batal</button>
</div>
