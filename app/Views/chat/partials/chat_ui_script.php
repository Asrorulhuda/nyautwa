<script>
let currentContact = document.getElementById('active-contact-input')?.value || '';
const chatContainer = document.getElementById('chat-messages-container');
if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;

function switchChatTab(tab) {
    const isChats = tab === 'chats';
    document.getElementById('tab-content-chats')?.classList.toggle('hidden', !isChats);
    document.getElementById('tab-content-contacts')?.classList.toggle('hidden', isChats);
    const act = 'flex-1 py-1 text-xs font-semibold rounded-md transition-all shadow-xs bg-white text-[#17211F]';
    const inact = 'flex-1 py-1 text-xs font-medium rounded-md transition-all text-[#697570] hover:text-[#17211F]';
    document.getElementById('tab-btn-chats').className = isChats ? act : inact;
    document.getElementById('tab-btn-contacts').className = !isChats ? act : inact;
}

function filterChatItems(q) {
    const val = q.toLowerCase().trim();
    document.querySelectorAll('.conv-chat-item, .conv-contact-item').forEach(el => {
        el.style.display = (el.getAttribute('data-search') || '').includes(val) ? 'flex' : 'none';
    });
}

function onDeviceFilterChange(devId) {
    const url = new URL(window.location.href);
    if (devId) url.searchParams.set('device', devId); else url.searchParams.delete('device');
    window.location.href = url.toString();
}

function promptNewChat() {
    const p = prompt('Masukkan nomor WhatsApp tujuan (contoh: 08123456789 atau 628123456789):');
    if (!p) return;
    let clean = p.replace(/[^0-9]/g, '');
    if (clean.startsWith('08')) clean = '628' + clean.slice(2);
    else if (clean.startsWith('8')) clean = '628' + clean.slice(1);
    if (clean.length < 8) return alert('Nomor telepon tidak valid.');
    selectConversation(clean);
}

function selectConversation(contact) {
    if (!contact) return;
    let clean = contact.trim();
    if (!clean.endsWith('@g.us') && !clean.endsWith('@lid')) {
        let num = clean.replace(/[^0-9]/g, '');
        if (num.startsWith('08')) clean = '628' + num.slice(2);
        else if (num.startsWith('8')) clean = '628' + num.slice(1);
        else if (num.length >= 8) clean = num;
    }
    const url = new URL(window.location.href);
    url.searchParams.set('contact', clean);
    window.location.href = url.toString();
}

async function toggleBotAutoreply(active) {
    if (!currentContact) return;
    try {
        const formData = new FormData();
        formData.append('csrf_token', '<?= csrf_token() ?>');
        formData.append('phone', currentContact);
        formData.append('active', active ? '1' : '0');
        const res = await fetch('<?= url('/chat/api/toggle-autoreply') ?>', { method: 'POST', body: formData });
        const d = await res.json();
        if (d.success) window.location.reload();
        else alert(d.error || 'Gagal mengubah status autoreply.');
    } catch (_) { alert('Terjadi kesalahan jaringan.'); }
}
</script>
