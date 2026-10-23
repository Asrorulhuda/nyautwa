<?php if (!empty($flashSuccess)): ?>
    <div class="flash-alert mb-4 px-4 py-3 bg-[#EAF7F0] border border-[#16A36A]/20 text-[#16865A] rounded-md text-sm flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-base">check_circle</span>
            <span><?= e($flashSuccess) ?></span>
        </div>
        <button type="button" onclick="this.closest('.flash-alert').remove()" class="text-[#16865A] hover:opacity-75">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
<?php endif; ?>

<?php if (!empty($flashError)): ?>
    <div class="flash-alert mb-4 px-4 py-3 bg-[#FDF0F0] border border-[#D84B4B]/20 text-[#D84B4B] rounded-md text-sm flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-base">error</span>
            <span><?= e($flashError) ?></span>
        </div>
        <button type="button" onclick="this.closest('.flash-alert').remove()" class="text-[#D84B4B] hover:opacity-75">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
<?php endif; ?>

<?php if (!empty($flashWarning)): ?>
    <div class="flash-alert mb-4 px-4 py-3 bg-[#FEF6E7] border border-[#D99124]/20 text-[#D99124] rounded-md text-sm flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-base">warning</span>
            <span><?= e($flashWarning) ?></span>
        </div>
        <button type="button" onclick="this.closest('.flash-alert').remove()" class="text-[#D99124] hover:opacity-75">
            <span class="material-symbols-outlined text-sm">close</span>
        </button>
    </div>
<?php endif; ?>
