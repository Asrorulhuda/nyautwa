<script>
function closeEditModal() {
    const m = document.getElementById('modal-edit-reply');
    if (m) { m.classList.add('hidden'); m.classList.remove('flex'); }
}

function handleEditTypeChange(type) {
    const fileBox = document.getElementById('edit-field-file');
    const pollBox = document.getElementById('edit-field-poll');
    const btnBox = document.getElementById('edit-field-button');
    const respLbl = document.getElementById('edit-response-label');

    fileBox.classList.add('hidden');
    pollBox.classList.add('hidden');
    btnBox.classList.add('hidden');

    if (type === 'image' || type === 'document') {
        fileBox.classList.remove('hidden');
        respLbl.innerText = type === 'image' ? 'Caption Gambar (Opsional)' : 'Caption Dokumen (Opsional)';
    } else if (type === 'poll') {
        pollBox.classList.remove('hidden');
        respLbl.innerText = 'Pertanyaan Polling';
    } else if (type === 'button') {
        btnBox.classList.remove('hidden');
        respLbl.innerText = 'Pesan Utama Menu';
    } else {
        respLbl.innerText = 'Isi Pesan Balasan';
    }
}

function editAutoReply(data) {
    const form = document.getElementById('form-edit-reply');
    form.action = '<?= url('/autoreplies/update/') ?>' + data.id;

    document.getElementById('edit_device_id').value = data.device_id || '';
    document.getElementById('edit_keyword').value = data.keyword || '';
    document.getElementById('edit_match_type').value = data.match_type || 'contain';
    document.getElementById('edit_type').value = data.type || 'text';
    document.getElementById('edit_response').value = data.response || '';

    handleEditTypeChange(data.type || 'text');

    const curFile = document.getElementById('edit-current-file');
    if (data.media_url) {
        curFile.innerHTML = `Berkas saat ini: <a href="${data.media_url}" target="_blank" class="underline font-semibold">${data.media_url.split('/').pop()}</a>`;
        curFile.classList.remove('hidden');
    } else {
        curFile.classList.add('hidden');
    }

    if (data.type === 'poll' && data.options) {
        try {
            const opts = typeof data.options === 'string' ? JSON.parse(data.options) : data.options;
            document.getElementById('edit_poll_text').value = Array.isArray(opts) ? opts.join("\n") : '';
        } catch {}
    }

    const editContainer = document.getElementById('edit-menu-options-container');
    if (editContainer) {
        editContainer.innerHTML = '';
        if (data.type === 'button' && data.options) {
            try {
                const opts = typeof data.options === 'string' ? JSON.parse(data.options) : data.options;
                if (Array.isArray(opts) && opts.length > 0) {
                    opts.forEach((o, idx) => {
                        if (typeof o === 'object' && o !== null) {
                            addMenuOptionRow('edit', o.key || String(idx + 1), o.label || '', o.keyword || '');
                        } else {
                            addMenuOptionRow('edit', String(idx + 1), String(o), String(o));
                        }
                    });
                }
            } catch {}
        }
        if (editContainer.querySelectorAll('.menu-row').length === 0) {
            addMenuOptionRow('edit', '1', '', '');
        }
    }

    const modal = document.getElementById('modal-edit-reply');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
</script>
