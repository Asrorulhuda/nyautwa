<script>
function toggleSelectAll(master) {
    const checkboxes = document.querySelectorAll('.msg-check');
    checkboxes.forEach(cb => { cb.checked = master.checked; });
    updateBulkBar();
}

function updateBulkBar() {
    const checked = document.querySelectorAll('.msg-check:checked');
    const bar = document.getElementById('bulk-action-bar');
    const countEl = document.getElementById('bulk-selected-count');
    const inputsContainer = document.getElementById('bulk-inputs-container');
    const master = document.getElementById('select-all-msg');

    const total = document.querySelectorAll('.msg-check').length;
    if (master) {
        master.checked = total > 0 && checked.length === total;
        master.indeterminate = checked.length > 0 && checked.length < total;
    }

    if (checked.length > 0) {
        bar.classList.remove('hidden');
        countEl.textContent = checked.length + ' pesan dipilih';
        inputsContainer.innerHTML = '';
        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            inputsContainer.appendChild(input);
        });
    } else {
        bar.classList.add('hidden');
        inputsContainer.innerHTML = '';
    }
}

function clearAllSelections() {
    const checkboxes = document.querySelectorAll('.msg-check');
    checkboxes.forEach(cb => { cb.checked = false; });
    const master = document.getElementById('select-all-msg');
    if (master) master.checked = false;
    updateBulkBar();
}
</script>
