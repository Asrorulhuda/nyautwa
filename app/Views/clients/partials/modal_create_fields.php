<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Nama Perusahaan / Bisnis *</label>
        <input type="text" name="name" required placeholder="PT Maju Bersama" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Nama PIC (Username) *</label>
        <input type="text" name="username" required placeholder="Budi Santoso" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Email Klien *</label>
        <input type="email" name="email" required placeholder="budi@bisnis.com" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Nomor WhatsApp * (Untuk Reminder)</label>
        <input type="text" name="phone" required placeholder="081234567890" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] font-mono focus:outline-none focus:border-[#16A36A]">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Kata Sandi Akun</label>
        <input type="password" name="password" value="password123" placeholder="••••••••••••" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Pilih Paket SaaS *</label>
        <select name="plan_id" id="create-plan-id" onchange="applyPlanPreset(this.value)" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
            <?php foreach (($plans ?? []) as $pKey => $p): ?>
            <option value="<?= e($pKey) ?>" <?= $pKey === 'starter' ? 'selected' : '' ?>>
                <?= e($p['name']) ?> (Rp <?= number_format((float)$p['price'], 0, ',', '.') ?>)
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Batas Device</label>
        <input type="number" name="device_limit" id="create-dev-limit" value="2" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Kuota Pesan</label>
        <input type="number" name="message_limit" id="create-msg-limit" value="5000" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Durasi (Hari)</label>
        <input type="number" name="duration_days" id="create-dur-days" value="30" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
</div>

<script>
    const planPresets = <?= json_encode($plans ?? []) ?>;
    function applyPlanPreset(key) {
        if (!planPresets[key]) return;
        const p = planPresets[key];
        document.getElementById('create-dev-limit').value = p.devices || 1;
        document.getElementById('create-msg-limit').value = p.monthly_messages || 1000;
        document.getElementById('create-dur-days').value = p.duration_days || 30;
    }
</script>
