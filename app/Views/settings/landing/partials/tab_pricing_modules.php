<?php
$moduleList = [
    'crm' => 'Live Chat (CRM)',
    'send_message' => 'Kirim Pesan',
    'autoreply' => 'Auto Reply',
    'broadcast' => 'Broadcast Blast',
    'api_keys' => 'API Key & Webhook',
];
?>
<div class="space-y-1.5 pt-1 border-t border-surface-container">
    <label class="block text-[10.5px] font-bold text-on-surface">Hak Akses Fitur</label>
    <div class="grid grid-cols-2 gap-1.5">
        <?php foreach ($moduleList as $modKey => $modLabel): 
            $fieldKey = "pricing_{$k}_feat_{$modKey}";
            $isChecked = !empty($settings[$fieldKey] ?? ($t['mods'][$modKey] ?? 0));
        ?>
        <label class="flex items-center gap-1.5 text-[11px] text-on-surface cursor-pointer select-none">
            <input type="hidden" name="<?= $fieldKey ?>" value="0">
            <input 
                type="checkbox" 
                name="<?= $fieldKey ?>" 
                value="1" 
                class="rounded border-outline-variant/60 text-primary focus:ring-primary w-3.5 h-3.5"
                <?= $isChecked ? 'checked' : '' ?>
            >
            <span class="truncate"><?= e($modLabel) ?></span>
        </label>
        <?php endforeach; ?>
    </div>
</div>
