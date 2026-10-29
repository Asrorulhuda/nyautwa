<div id="tab-content-chats" class="flex-1 min-h-0 overflow-y-auto divide-y divide-[#E4EAE6]/60">
    <?php if (empty($conversations)): ?>
        <div class="p-8 text-center text-xs text-[#697570]">
            <span class="material-symbols-outlined text-[32px] text-[#697570]/50 block mb-1">chat_bubble_outline</span>
            Belum ada obrolan aktif.
        </div>
    <?php else: ?>
        <?php foreach ($conversations as $c): ?>
            <?php
                $isAct = ($c['to_from'] === $activeContact);
                $displayName = !empty($c['contact_name']) ? $c['contact_name'] : $c['to_from'];
                $initial = strtoupper(substr($displayName, 0, 1));
                $isToday = date('Y-m-d') === date('Y-m-d', strtotime($c['created_at']));
                $dateStr = $isToday ? date('H:i', strtotime($c['created_at'])) : date('d/m', strtotime($c['created_at']));
            ?>
            <div onclick="selectConversation('<?= htmlspecialchars($c['to_from'], ENT_QUOTES) ?>')"
                 data-search="<?= htmlspecialchars(strtolower($displayName . ' ' . $c['to_from'])) ?>"
                 class="conv-chat-item p-3.5 flex items-start gap-3 cursor-pointer transition-colors <?= $isAct ? 'bg-[#EAF7F0]/80 border-l-4 border-l-[#16A36A]' : 'hover:bg-white bg-transparent' ?>">
                <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-xs <?= $isAct ? 'bg-[#16A36A] text-white' : 'bg-[#E4EAE6] text-[#17211F]' ?>">
                    <?= $initial ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1 mb-1">
                        <div class="flex items-center gap-1.5 truncate">
                            <h4 class="text-xs font-semibold text-[#17211F] truncate"><?= htmlspecialchars($displayName) ?></h4>
                            <?php if (!empty($c['needs_human'])): ?>
                                <span class="px-1.5 py-0.5 text-[9px] font-semibold bg-[#FEF6E7] text-[#D99124] rounded border border-[#D99124]/30 whitespace-nowrap">Butuh CS</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <span class="text-[10px] text-[#697570] font-mono whitespace-nowrap"><?= $dateStr ?></span>
                            <?php if (!empty($c['unread_count']) && (int)$c['unread_count'] > 0): ?>
                                <span class="min-w-[18px] h-[18px] px-1 flex items-center justify-center text-[10px] font-bold bg-[#16A36A] text-white rounded-full font-mono shadow-xs"><?= (int)$c['unread_count'] ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="text-[11px] text-[#697570] truncate flex items-center gap-1">
                        <?php if ($c['direction'] === 'outbound'): ?>
                            <span class="material-symbols-outlined text-[13px] text-[#16A36A]">done_all</span>
                        <?php endif; ?>
                        <span><?= htmlspecialchars($c['body']) ?></span>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
