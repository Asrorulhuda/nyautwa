<div id="tab-content-contacts" class="hidden flex-1 min-h-0 overflow-y-auto divide-y divide-[#E4EAE6]/60">
    <?php if (empty($contacts)): ?>
        <div class="p-8 text-center text-xs text-[#697570]">
            <span class="material-symbols-outlined text-[32px] text-[#697570]/50 block mb-1">contacts</span>
            Belum ada kontak tersimpan.<br>
            <a href="<?= url('/contacts') ?>" class="text-[#16A36A] underline mt-1 inline-block">Kelola Kontak & Sync</a>
        </div>
    <?php else: ?>
        <?php foreach ($contacts as $cnt): ?>
            <?php
                $isAct = ($cnt['phone'] === $activeContact);
                $initial = strtoupper(substr($cnt['name'], 0, 1));
            ?>
            <div onclick="selectConversation('<?= htmlspecialchars($cnt['phone'], ENT_QUOTES) ?>')"
                 data-search="<?= htmlspecialchars(strtolower($cnt['name'] . ' ' . $cnt['phone'] . ' ' . ($cnt['tag_name'] ?? ''))) ?>"
                 class="conv-contact-item p-3.5 flex items-center gap-3 cursor-pointer transition-colors <?= $isAct ? 'bg-[#EAF7F0]/80 border-l-4 border-l-[#16A36A]' : 'hover:bg-white bg-transparent' ?>">
                <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-xs bg-[#EAF7F0] text-[#16A36A]">
                    <?= $initial ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1 mb-0.5">
                        <h4 class="text-xs font-semibold text-[#17211F] truncate"><?= htmlspecialchars($cnt['name']) ?></h4>
                        <?php if (!empty($cnt['tag_name'])): ?>
                            <span class="text-[9.5px] px-1.5 py-0.5 rounded-full font-medium" style="background-color: <?= htmlspecialchars($cnt['tag_color'] ?? '#E4EAE6') ?>20; color: <?= htmlspecialchars($cnt['tag_color'] ?? '#16A36A') ?>;">
                                <?= htmlspecialchars($cnt['tag_name']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-[11px] text-[#697570] font-mono truncate"><?= htmlspecialchars($cnt['phone']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
