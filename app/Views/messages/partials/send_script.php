<script>
let currentType = 'text';

function selectMessageType(type) {
    currentType = type;
    document.getElementById('msg_type_input').value = type;
    document.querySelectorAll('.type-btn').forEach(btn => {
        btn.classList.remove('bg-primary', 'text-white');
        btn.classList.add('bg-surface-container-low', 'text-secondary');
    });
    const activeBtn = document.getElementById('btn-type-' + type);
    if (activeBtn) {
        activeBtn.classList.remove('bg-surface-container-low', 'text-secondary');
        activeBtn.classList.add('bg-primary', 'text-white');
    }
    document.querySelectorAll('.type-panel').forEach(p => p.classList.add('hidden'));
    const activePanel = document.getElementById('field-' + type);
    if (activePanel) activePanel.classList.remove('hidden');

    document.getElementById('preview-image-box').classList.toggle('hidden', type !== 'image');
    document.getElementById('preview-doc-box').classList.toggle('hidden', type !== 'document');
    document.getElementById('preview-poll-box').classList.toggle('hidden', type !== 'poll');
    document.getElementById('preview-buttons-box').classList.toggle('hidden', type !== 'button');
    
    const bodyLabel = document.getElementById('body-label');
    if (bodyLabel) {
        if (type === 'image' || type === 'document') bodyLabel.textContent = 'Keterangan / Caption';
        else if (type === 'poll') bodyLabel.textContent = 'Catatan Pengantar Polling (Opsional)';
        else bodyLabel.textContent = 'Isi Pesan WhatsApp';
    }
}

function updatePreviewText(val) {
    const el = document.getElementById('preview-text');
    const counter = document.getElementById('char-count');
    if (counter) counter.textContent = val.length + ' karakter';
    if (el) el.textContent = val.trim() || 'Tulis pesan Anda untuk melihat pratinjau live...';
}

function updatePreviewMedia(url) {
    const img = document.getElementById('preview-img');
    if (!img) return;
    const isSafe = typeof url === 'string' && (url.startsWith('https://') || url.startsWith('http://') || url.startsWith('data:image/'));
    img.src = isSafe ? url : 'https://placehold.co/400x200?text=Gambar+WhatsApp';
}

function updatePreviewDoc(url) {}
function updatePreviewDocName(name) {
    const el = document.getElementById('preview-doc-name');
    if (el) el.textContent = name || 'dokumen.pdf';
}

function updatePreviewPollQ(q) {
    const el = document.getElementById('preview-poll-title');
    if (el) el.textContent = q || 'Pertanyaan Polling?';
}

function updatePreviewPollOpts(text) {
    const container = document.getElementById('preview-poll-items');
    if (!container) return;
    const lines = text.split("\n").filter(l => l.trim() !== '');
    container.innerHTML = '';
    lines.forEach(line => {
        const wrap = document.createElement('div');
        wrap.className = 'flex items-center gap-2 p-1.5 bg-[#F0F2F5] rounded text-xs text-[#111B21]';
        const dot = document.createElement('span');
        dot.className = 'w-3.5 h-3.5 rounded-full border border-[#8696A0] inline-block';
        const label = document.createElement('span');
        label.textContent = line;
        wrap.appendChild(dot); wrap.appendChild(label);
        container.appendChild(wrap);
    });
}

function updatePreviewButtons(text) {
    const container = document.getElementById('preview-btn-items');
    if (!container) return;
    const lines = text.split("\n").filter(l => l.trim() !== '');
    container.innerHTML = '';
    lines.forEach(btn => {
        const el = document.createElement('div');
        el.className = 'text-center py-1.5 px-3 bg-[#F0F2F5] hover:bg-[#E9EDEF] rounded text-xs font-semibold text-[#00A884]';
        el.textContent = btn;
        container.appendChild(el);
    });
}

function updatePreviewFooter(f) {
    const el = document.getElementById('preview-footer');
    if (el) el.textContent = f || 'NyautWa Gateway';
}

document.addEventListener('DOMContentLoaded', () => {
    selectMessageType('text');
    updatePreviewPollOpts("Sangat Puas\nCukup Puas\nPerlu Ditingkatkan");
    updatePreviewButtons("Konfirmasi Pesanan\nHubungi CS");
});
</script>
