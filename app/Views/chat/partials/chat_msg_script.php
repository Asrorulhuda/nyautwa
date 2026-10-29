<script>
let selectedChatFile = null;

function handleFileSelect(input) {
    if (!input.files || !input.files[0]) return;
    selectedChatFile = input.files[0];
    document.getElementById('chat-file-name').textContent = selectedChatFile.name;
    document.getElementById('chat-file-preview')?.classList.remove('hidden');
    document.getElementById('chat-message-input')?.focus();
}

function clearSelectedFile() {
    selectedChatFile = null;
    const input = document.getElementById('chat-file-input');
    if (input) input.value = '';
    document.getElementById('chat-file-preview')?.classList.add('hidden');
}

document.getElementById('chat-message-input')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('chat-reply-form')?.dispatchEvent(new Event('submit', { cancelable: true }));
    }
});

function buildBubble(m) {
    const isMe = m.direction === 'outbound';
    const type = m.type || 'text', media = m.media_ref || '';
    const time = (m.created_at || '').substring(11, 16) || '--:--';
    const icon = m.status === 'sent' ? 'done_all' : (m.status === 'failed' ? 'error' : 'schedule');
    let mHtml = '';
    if (type === 'image' && media) mHtml = `<div class="mb-2 rounded-lg overflow-hidden border border-[#E4EAE6]/50 bg-black/5 max-w-[280px]"><a href="${media}" target="_blank"><img src="${media}" alt="Gambar" class="w-full h-auto max-h-[220px] object-cover"></a></div>`;
    else if (type === 'document' && media) mHtml = `<a href="${media}" target="_blank" download class="mb-2 p-2.5 rounded-lg border border-[#E4EAE6] bg-[#F6F8F7] flex items-center gap-2.5 hover:bg-white"><span class="material-symbols-outlined text-[24px] text-[#16A36A]">description</span><div class="flex-1 min-w-0"><div class="font-semibold text-xs text-[#17211F] truncate">${media.split('/').pop()}</div></div><span class="material-symbols-outlined text-[18px] text-[#697570]">download</span></a>`;
    const esc = (m.body || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    const bHtml = (esc && (type === 'text' || esc !== media.split('/').pop())) ? `<div class="whitespace-pre-wrap leading-relaxed break-words">${esc}</div>` : '';
    const cStyle = isMe ? 'bg-[#EAF7F0] border border-[#16A36A]/20 text-[#17211F] rounded-tr-xs' : 'bg-white border border-[#E4EAE6] text-[#17211F] rounded-tl-xs';
    return `<div class="flex flex-col ${isMe ? 'items-end' : 'items-start'}" data-msg-id="${m.id}"><div class="p-3 text-xs rounded-2xl max-w-[80%] md:max-w-[70%] shadow-xs ${cStyle}">${mHtml}${bHtml}<div class="flex items-center justify-end gap-1 mt-1 text-[10px] text-[#697570] font-mono"><span>${time}</span>${isMe ? `<span class="material-symbols-outlined text-[13px] text-[#16A36A]">${icon}</span>` : ''}</div></div></div>`;
}

async function refreshMessages(scroll = false) {
    if (!currentContact || !chatContainer) return;
    try {
        const res = await fetch(`<?= url('/chat/api/messages') ?>?contact=${encodeURIComponent(currentContact)}`);
        const data = await res.json();
        if (!data.success || !Array.isArray(data.messages)) return;
        const existing = new Set();
        chatContainer.querySelectorAll('[data-msg-id]').forEach(el => existing.add(el.getAttribute('data-msg-id')));
        let added = false;
        data.messages.forEach(m => {
            if (!existing.has(m.id)) {
                chatContainer.insertAdjacentHTML('beforeend', buildBubble(m));
                existing.add(m.id);
                added = true;
            }
        });
        if (added || scroll) chatContainer.scrollTop = chatContainer.scrollHeight;
    } catch (_) {}
}

async function sendChatMessage(e) {
    e.preventDefault();
    const input = document.getElementById('chat-message-input'), msg = input.value.trim();
    const devId = document.getElementById('chat-sender-device')?.value, btn = document.getElementById('chat-send-btn');
    if ((!msg && !selectedChatFile) || !currentContact || !devId) return;

    btn.disabled = true;
    btn.classList.add('opacity-50');
    try {
        const formData = new FormData();
        formData.append('csrf_token', '<?= csrf_token() ?>');
        formData.append('device_id', devId);
        formData.append('to', currentContact);
        formData.append('message', msg);
        if (selectedChatFile) formData.append('media', selectedChatFile);

        const res = await fetch('<?= url('/chat/api/send') ?>', { method: 'POST', body: formData });
        const data = await res.json();
        if (data.success) {
            input.value = '';
            clearSelectedFile();
            await refreshMessages(true);
        } else {
            alert(data.error || 'Gagal mengirim pesan.');
        }
    } catch (_) { alert('Terjadi kesalahan jaringan.'); }
    finally { btn.disabled = false; btn.classList.remove('opacity-50'); }
}

setInterval(() => refreshMessages(false), 3000);
</script>
