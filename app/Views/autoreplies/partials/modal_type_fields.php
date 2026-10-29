<!-- Dynamic Fields Container based on Selected Type -->
<div id="field-file-upload" class="hidden">
    <label class="block text-xs font-semibold text-[#17211F] mb-1">
        <span id="file-label-text">Pilih File Unggahan</span>
        <span class="text-[#D84B4B]">*</span>
    </label>
    <div class="flex items-center gap-2">
        <input type="file" name="media_file" id="reply_media_file" class="w-full text-xs text-[#17211F] file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#EAF7F0] file:text-[#16865A] hover:file:bg-[#d8f0e3] border border-[#E4EAE6] rounded-md cursor-pointer bg-white">
    </div>
    <span id="file-help-text" class="text-[11px] text-[#697570] mt-1 block">Maksimal 15 MB.</span>
</div>

<div id="field-poll" class="hidden">
    <label class="block text-xs font-semibold text-[#17211F] mb-1">
        Pilihan Polling / Voting (Satu per baris, min. 2 opsi)
        <span class="text-[#D84B4B]">*</span>
    </label>
    <textarea name="poll_options_text" rows="3" placeholder="Pilihan 1&#10;Pilihan 2&#10;Pilihan 3" class="w-full px-3 py-2 text-sm border border-[#E4EAE6] rounded-md focus:border-[#16A36A] focus:outline-none"></textarea>
    <span class="text-[11px] text-[#697570] mt-0.5 block">Tuliskan setiap opsi jawaban pada baris baru.</span>
</div>

<?php require __DIR__ . '/modal_menu_rows.php'; ?>

<script>
function handleReplyTypeChange(select) {
    const val = select.value;
    const fileContainer = document.getElementById('field-file-upload');
    const fileInput = document.getElementById('reply_media_file');
    const fileLabel = document.getElementById('file-label-text');
    const fileHelp = document.getElementById('file-help-text');
    const pollContainer = document.getElementById('field-poll');
    const buttonContainer = document.getElementById('field-button');
    const responseLabel = document.getElementById('response-label-text');

    fileContainer.classList.add('hidden');
    pollContainer.classList.add('hidden');
    buttonContainer.classList.add('hidden');

    if (val === 'image') {
        fileContainer.classList.remove('hidden');
        fileLabel.innerText = 'Pilih File Gambar (Choose File)';
        fileHelp.innerText = 'Format didukung: JPG, PNG, WEBP, GIF (Maks. 10MB).';
        fileInput.setAttribute('accept', 'image/*');
        responseLabel.innerText = 'Teks Keterangan / Caption Gambar (Opsional)';
    } else if (val === 'document') {
        fileContainer.classList.remove('hidden');
        fileLabel.innerText = 'Pilih File Dokumen (Choose File)';
        fileHelp.innerText = 'Format didukung: PDF, DOCX, XLSX, TXT, ZIP (Maks. 25MB).';
        fileInput.setAttribute('accept', '.pdf,.doc,.docx,.xls,.xlsx,.zip,.txt');
        responseLabel.innerText = 'Teks Keterangan / Caption Dokumen (Opsional)';
    } else if (val === 'poll') {
        pollContainer.classList.remove('hidden');
        responseLabel.innerText = 'Pertanyaan Polling / Voting';
    } else if (val === 'button') {
        buttonContainer.classList.remove('hidden');
        responseLabel.innerText = 'Pesan Utama Tombol';
    } else {
        responseLabel.innerText = 'Isi Balasan Otomatis';
    }
}
</script>
