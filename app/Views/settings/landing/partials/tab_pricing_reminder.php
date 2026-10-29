<!-- WhatsApp Expiry Reminder Configuration -->
<div class="p-4 rounded-xl bg-surface-container-low/30 border border-surface-container space-y-3">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500 text-[18px]">notifications_active</span>
            <h4 class="text-xs font-bold text-on-surface">Pengingat Masa Aktif WhatsApp (Reminder H-3)</h4>
        </div>
        <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-500 font-semibold">Otomatis & Manual</span>
    </div>
    <p class="text-[11px] text-secondary">Pesan pengingat dikirim ke nomor WhatsApp pemilik akun ketika masa aktif tersisa 3 hari atau telah kedaluwarsa.</p>
    <div>
        <label class="block text-[11px] font-medium text-on-surface mb-1">Template Pesan WhatsApp</label>
        <textarea 
            name="reminder_wa_template" 
            rows="3" 
            class="w-full p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/40 text-xs font-mono leading-relaxed"
            placeholder="Template reminder..."
        ><?= e($settings['reminder_wa_template'] ?? '') ?></textarea>
        <span class="text-[10px] text-secondary mt-1 block">Variabel tersedia: <code class="text-primary">{name}</code>, <code class="text-primary">{plan}</code>, <code class="text-primary">{business}</code>, <code class="text-primary">{days_left}</code>, <code class="text-primary">{expiry_date}</code>, <code class="text-primary">{invoice_url}</code></span>
    </div>
</div>
