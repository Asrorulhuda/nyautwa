<?php
$isMe = ($m['direction'] === 'outbound');
$type = $m['type'] ?? 'text';
$mediaRef = $m['media_ref'] ?? null;
?>
<div class="flex flex-col <?= $isMe ? 'items-end' : 'items-start' ?>" data-msg-id="<?= htmlspecialchars($m['id'] ?? '') ?>">
    <div class="p-3 text-xs rounded-2xl max-w-[80%] md:max-w-[70%] shadow-xs <?= $isMe ? 'bg-[#EAF7F0] border border-[#16A36A]/20 text-[#17211F] rounded-tr-xs' : 'bg-white border border-[#E4EAE6] text-[#17211F] rounded-tl-xs' ?>">
        <?php if ($type === 'image' && !empty($mediaRef)): ?>
            <div class="mb-2 rounded-lg overflow-hidden border border-[#E4EAE6]/50 bg-black/5 max-w-[280px]">
                <a href="<?= htmlspecialchars(url($mediaRef)) ?>" target="_blank" rel="noopener">
                    <img src="<?= htmlspecialchars(url($mediaRef)) ?>" alt="Gambar" class="w-full h-auto max-h-[220px] object-cover hover:opacity-95 transition-opacity" loading="lazy">
                </a>
            </div>
        <?php elseif ($type === 'document' && !empty($mediaRef)): ?>
            <a href="<?= htmlspecialchars(url($mediaRef)) ?>" target="_blank" download class="mb-2 p-2.5 rounded-lg border border-[#E4EAE6] bg-[#F6F8F7] flex items-center gap-2.5 hover:bg-white transition-colors group">
                <span class="material-symbols-outlined text-[24px] text-[#16A36A] group-hover:scale-105 transition-transform">description</span>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-xs text-[#17211F] truncate"><?= htmlspecialchars(basename($mediaRef)) ?></div>
                    <div class="text-[10px] text-[#697570]">Klik untuk mengunduh dokumen</div>
                </div>
                <span class="material-symbols-outlined text-[18px] text-[#697570]">download</span>
            </a>
        <?php endif; ?>
        <?php if (!empty($m['body']) && ($type === 'text' || $m['body'] !== basename($mediaRef ?? ''))): ?>
            <div class="whitespace-pre-wrap leading-relaxed break-words"><?= htmlspecialchars($m['body']) ?></div>
        <?php endif; ?>
        <div class="flex items-center justify-end gap-1 mt-1 text-[10px] text-[#697570] font-mono">
            <span><?= date('H:i', strtotime($m['created_at'])) ?></span>
            <?php if ($isMe): ?>
                <span class="material-symbols-outlined text-[13px] text-[#16A36A]"><?= $m['status'] === 'sent' ? 'done_all' : ($m['status'] === 'failed' ? 'error' : 'schedule') ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>
