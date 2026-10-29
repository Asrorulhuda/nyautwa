<div class="flex-1 min-w-0 min-h-0 flex flex-col h-full bg-white relative">
    <?php if (empty($activeContact)): ?>
        <div class="flex-1 flex flex-col items-center justify-center p-8 text-center text-[#697570] bg-[#F6F8F7]/30">
            <div class="w-16 h-16 rounded-full bg-[#EAF7F0] text-[#16A36A] flex items-center justify-center mb-3">
                <span class="material-symbols-outlined text-[32px]">forum</span>
            </div>
            <h3 class="text-sm font-semibold text-[#17211F]">Live Chat & CRM WhatsApp</h3>
            <p class="text-xs text-[#697570] max-w-xs mt-1">Pilih salah satu obrolan atau kontak di sebelah kiri untuk membaca dan membalas pesan.</p>
        </div>
    <?php else: ?>
        <?php
            $headerName = !empty($activeContactData['name']) ? $activeContactData['name'] : $activeContact;
            $hasTag = !empty($activeContactData['tag_name']);
        ?>
        <!-- Active Chat Header -->
        <div class="px-5 py-3 border-b border-[#E4EAE6] bg-white flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-[#16A36A] text-white flex-shrink-0 flex items-center justify-center font-bold text-xs">
                    <?= htmlspecialchars(strtoupper(substr((string)$headerName, 0, 1)), ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xs font-bold text-[#17211F] truncate"><?= htmlspecialchars($headerName) ?></h3>
                        <?php if ($hasTag): ?>
                            <span class="text-[9.5px] px-1.5 py-0.5 rounded-full font-medium" style="background-color: <?= htmlspecialchars($activeContactData['tag_color'] ?? '#16A36A') ?>20; color: <?= htmlspecialchars($activeContactData['tag_color'] ?? '#16A36A') ?>;">
                                <?= htmlspecialchars($activeContactData['tag_name']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-[10.5px] text-[#697570] font-mono truncate"><?= htmlspecialchars($activeContact) ?></p>
                </div>
            </div>
            <!-- Autoreply Status Pill & Sender Device Selector -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <?php $isPaused = !empty($activeContactData['autoreply_paused']); ?>
                <button type="button" id="btn-toggle-autoreply" onclick="toggleBotAutoreply(<?= $isPaused ? 'true' : 'false' ?>)"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-semibold rounded-md border transition-colors <?= $isPaused ? 'bg-[#FEF6E7] hover:bg-[#FEF0D5] text-[#D99124] border-[#D99124]/30' : 'bg-[#EAF7F0] hover:bg-[#FDF0F0] text-[#16A36A] hover:text-[#D84B4B] border-[#16A36A]/20' ?>"
                        title="<?= $isPaused ? 'Bot nonaktif. Klik untuk mengaktifkan kembali bot.' : 'Bot aktif. Klik untuk mematikan bot dan CS ambil alih.' ?>">
                    <span class="material-symbols-outlined text-[15px]">smart_toy</span>
                    <span><?= $isPaused ? 'Bot Nonaktif' : 'Bot Aktif' ?></span>
                    <span class="text-[10px] underline ml-0.5"><?= $isPaused ? '(Aktifkan)' : '(Ambil Alih)' ?></span>
                </button>
                <select id="chat-sender-device" class="text-xs bg-[#F6F8F7] border border-[#E4EAE6] rounded-md px-2 py-1 outline-none font-semibold text-[#17211F] focus:border-[#16A36A]">
                    <?php 
                    $hasSel = false;
                    foreach ($devices as $d): 
                        $sel = !$hasSel && (($d['status'] ?? '') === 'connected');
                        if ($sel) $hasSel = true;
                    ?>
                        <option value="<?= htmlspecialchars($d['id']) ?>" <?= $sel ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['label'] ?? $d['id']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Chat Timeline Container -->
        <div id="chat-messages-container" class="flex-1 min-h-0 p-4 md:p-5 overflow-y-auto space-y-3 bg-[#F6F8F7]/50">
            <?php if (empty($activeMessages)): ?>
                <div class="p-8 text-center text-xs text-[#697570] bg-white border border-dashed border-[#E4EAE6] rounded-xl max-w-sm mx-auto my-auto">
                    <span class="material-symbols-outlined text-[28px] text-[#16A36A] block mb-1">chat</span>
                    Mulai percakapan baru dengan <strong class="text-[#17211F]"><?= htmlspecialchars($headerName) ?></strong>.<br>
                    Tulis pesan Anda di bawah untuk mengirim pesan pertama via WhatsApp.
                </div>
            <?php else: ?>
                <?php foreach ($activeMessages as $m): ?>
                    <?php require __DIR__ . '/chat_bubble.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Chat Input Bar -->
        <form id="chat-reply-form" onsubmit="sendChatMessage(event)" class="p-3 bg-white border-t border-[#E4EAE6] flex flex-col gap-2">
            <?= csrf_field() ?>
            <input type="hidden" id="active-contact-input" value="<?= htmlspecialchars($activeContact) ?>">
            <div id="chat-file-preview" class="hidden px-3 py-1.5 bg-[#F6F8F7] border border-[#E4EAE6] rounded-lg text-xs flex items-center justify-between text-[#17211F]">
                <div class="flex items-center gap-2 truncate">
                    <span class="material-symbols-outlined text-[18px] text-[#16A36A]">attach_file</span>
                    <span id="chat-file-name" class="font-medium truncate"></span>
                </div>
                <button type="button" onclick="clearSelectedFile()" class="text-[#D84B4B] hover:opacity-80 p-0.5">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                </button>
            </div>
            <div class="flex items-center gap-2">
                <input type="file" id="chat-file-input" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.txt" onchange="handleFileSelect(this)">
                <button type="button" onclick="document.getElementById('chat-file-input').click()" class="h-9 w-9 text-[#697570] hover:text-[#16A36A] hover:bg-[#F6F8F7] border border-[#E4EAE6] rounded-lg flex items-center justify-center flex-shrink-0 transition-colors" title="Kirim Foto / Dokumen">
                    <span class="material-symbols-outlined text-[18px]">attach_file</span>
                </button>
                <textarea id="chat-message-input" rows="1" placeholder="Tulis balasan pesan WhatsApp... (Tekan Enter untuk kirim)" class="flex-1 text-xs px-3 py-2 bg-[#F6F8F7] border border-[#E4EAE6] rounded-lg outline-none focus:border-[#16A36A] focus:bg-white resize-none"></textarea>
                <button type="submit" id="chat-send-btn" class="h-9 px-4 bg-[#16A36A] hover:bg-[#128557] text-white rounded-lg flex items-center gap-1.5 text-xs font-semibold shadow-sm transition-colors cursor-pointer flex-shrink-0">
                    <span class="material-symbols-outlined text-[16px]">send</span>
                    <span>Kirim</span>
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>
