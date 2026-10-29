<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#17211F]">Balas Otomatis (Auto-Reply)</h1>
            <p class="text-sm text-[#697570] mt-1">Konfigurasi pesan balasan instan untuk teks, gambar, dokumen, polling, dan tombol.</p>
        </div>
        <div class="flex items-center gap-2">
            <?php if (!empty($replies)): ?>
                <form method="POST" action="<?= url('/autoreplies/delete-all') ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SELURUH aturan balas otomatis? Tindakan ini tidak dapat dibatalkan.')">
                    <?= csrf_field() ?>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-[#D84B4B] bg-[#FDF0F0] border border-[#D84B4B]/20 hover:bg-[#FBE4E4] rounded-md transition-colors shadow-sm cursor-pointer" title="Hapus seluruh aturan balas otomatis">
                        <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                        <span>Hapus Semua</span>
                    </button>
                </form>
            <?php endif; ?>
            <button type="button" onclick="if(typeof openModal==='function'){openModal('modal-import-reply')}else{const m=document.getElementById('modal-import-reply');m.classList.remove('hidden');m.classList.add('flex');}" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-[#16865A] bg-[#EAF7F0] border border-[#16A36A]/20 hover:bg-[#D4EFE0] rounded-md transition-colors shadow-sm cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">upload_file</span>
                <span>Import Excel</span>
            </button>
            <button type="button" onclick="if(typeof openModal==='function'){openModal('modal-create-reply')}else{const m=document.getElementById('modal-create-reply');m.classList.remove('hidden');m.classList.add('flex');}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors shadow-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Balas Otomatis
            </button>
        </div>
    </div>

    <?php require __DIR__ . '/partials/table.php'; ?>
</div>

<?php require __DIR__ . '/partials/bulk_bar.php'; ?>
<?php require __DIR__ . '/partials/modal_create.php'; ?>
<?php require __DIR__ . '/partials/modal_edit.php'; ?>
<?php require __DIR__ . '/partials/modal_import.php'; ?>
<?php require __DIR__ . '/partials/edit_script.php'; ?>
