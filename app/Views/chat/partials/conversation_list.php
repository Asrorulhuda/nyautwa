<div class="w-full md:w-80 lg:w-96 border-r border-[#E4EAE6] flex flex-col bg-[#F6F8F7]/40 h-full min-h-0 flex-shrink-0">
    <!-- Top Filter & Search -->
    <div class="p-3 border-b border-[#E4EAE6] bg-white space-y-2.5">
        <!-- Device Filter Selector -->
        <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[17px] text-[#16A36A]">smartphone</span>
            <select id="device-filter" onchange="onDeviceFilterChange(this.value)" class="flex-1 text-xs bg-[#F6F8F7] border border-[#E4EAE6] rounded-md px-2 py-1.5 font-medium outline-none focus:border-[#16A36A]">
                <option value="">Semua Perangkat (<?= count($devices) ?>)</option>
                <?php foreach ($devices as $d): ?>
                    <option value="<?= htmlspecialchars($d['id']) ?>" <?= ($selectedDevice === $d['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($d['label'] ?? $d['id']) ?> <?= ($d['status'] === 'connected' ? '● Online' : '○ Offline') ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button onclick="promptNewChat()" title="Mulai Chat Baru" class="p-1.5 bg-[#EAF7F0] hover:bg-[#16A36A] hover:text-white text-[#16A36A] rounded-md transition-colors flex items-center justify-center cursor-pointer">
                <span class="material-symbols-outlined text-[17px]">add_comment</span>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="relative">
            <span class="material-symbols-outlined absolute left-2.5 top-2 text-[17px] text-[#697570]">search</span>
            <input type="text" id="chat-search" oninput="filterChatItems(this.value)" placeholder="Cari obrolan, kontak, nomor..." class="w-full pl-8 pr-3 py-1.5 text-xs bg-[#F6F8F7] border border-[#E4EAE6] rounded-md outline-none focus:border-[#16A36A] focus:bg-white transition-colors">
        </div>

        <!-- Tab Switcher: Chat Aktif vs Buku Kontak -->
        <div class="flex rounded-lg bg-[#F6F8F7] p-0.5 border border-[#E4EAE6]">
            <button id="tab-btn-chats" onclick="switchChatTab('chats')" class="flex-1 py-1 text-xs font-semibold rounded-md transition-all shadow-xs bg-white text-[#17211F]">
                Obrolan (<?= count($conversations) ?>)
            </button>
            <button id="tab-btn-contacts" onclick="switchChatTab('contacts')" class="flex-1 py-1 text-xs font-medium rounded-md transition-all text-[#697570] hover:text-[#17211F]">
                Kontak (<?= count($contacts) ?>)
            </button>
        </div>
    </div>

    <!-- Tab Contents -->
    <?php require __DIR__ . '/tab_conversations.php'; ?>
    <?php require __DIR__ . '/tab_contacts.php'; ?>
</div>
