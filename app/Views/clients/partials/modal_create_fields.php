<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Nama pengguna *</label>
        <input type="text" name="username" required placeholder="admin12" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Email *</label>
        <input type="email" name="email" required placeholder="user@bisnis.com" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A]">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Kata sandi *</label>
        <input type="password" name="password" required value="password123" placeholder="••••••••••••" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Batas Pesan</label>
        <input type="number" name="message_limit" value="1000" placeholder="1000" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A]">
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Batasi Perangkat</label>
        <input type="number" name="device_limit" value="1" placeholder="1" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Status Berlangganan</label>
        <select name="status" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
            <option value="active" selected>Aktif</option>
            <option value="inactive">Nonaktif</option>
            <option value="trial">Percobaan</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Langganan Berakhir</label>
        <input type="datetime-local" name="subscription_ends_at" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
    </div>
    <div>
        <label class="block text-xs font-semibold text-[#17211F] mb-1">Tingkat</label>
        <select name="role" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
            <option value="user" selected>Pengguna</option>
            <option value="admin">Admin</option>
            <option value="reseller">Reseller</option>
        </select>
    </div>
</div>

<div>
    <label class="block text-xs font-semibold text-[#17211F] mb-1">Rencana</label>
    <select name="plan_id" class="w-full h-9 px-3 rounded-lg bg-white border border-[#E4EAE6] text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A]">
        <option value="starter">Starter (1 Node — 1.000 pesan/hari)</option>
        <option value="pro" selected>Pro (5 Node — 10.000 pesan/hari)</option>
        <option value="enterprise">Enterprise (20 Node — Unlimited)</option>
        <option value="custom">-- Kustom --</option>
    </select>
</div>
