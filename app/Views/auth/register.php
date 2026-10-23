<div class="mb-6">
    <h1 class="text-xl font-bold text-[#17211F] mb-1 font-['Geist']">Daftar Akun Baru</h1>
    <p class="text-xs text-[#697570]">Mulai hubungkan nomor WhatsApp bisnis Anda dalam hitungan menit.</p>
</div>

<form action="<?= url('/register') ?>" method="POST" class="space-y-4">
    <?= csrf_field() ?>

    <div>
        <label for="company" class="block text-xs font-semibold text-[#17211F] mb-1.5">Nama Perusahaan / Bisnis</label>
        <input 
            type="text" 
            id="company" 
            name="company" 
            required 
            placeholder="PT Maju Bersama Digital" 
            value="<?= e(old('company')) ?>"
            class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
        >
    </div>

    <div>
        <label for="name" class="block text-xs font-semibold text-[#17211F] mb-1.5">Nama Lengkap Penanggung Jawab</label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            required 
            placeholder="Ahmad Fauzi" 
            value="<?= e(old('name')) ?>"
            class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
        >
    </div>

    <div>
        <label for="email" class="block text-xs font-semibold text-[#17211F] mb-1.5">Email Bisnis</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            required 
            placeholder="ahmad@perusahaan.com" 
            value="<?= e(old('email')) ?>"
            class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
        >
    </div>

    <div>
        <label for="password" class="block text-xs font-semibold text-[#17211F] mb-1.5">Kata Sandi (Min. 6 Karakter)</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required 
            placeholder="••••••••" 
            class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
        >
    </div>

    <div>
        <label for="plan" class="block text-xs font-semibold text-[#17211F] mb-1.5">Pilihan Paket Uji Coba</label>
        <select 
            id="plan" 
            name="plan" 
            class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
        >
            <option value="starter" <?= ($selectedPlan ?? 'starter') === 'starter' ? 'selected' : '' ?>>Starter (1 Device — Kuota 1.000 pesan/hari)</option>
            <option value="pro" <?= ($selectedPlan ?? '') === 'pro' ? 'selected' : '' ?>>Professional (5 Device — Kuota 10.000 pesan/hari)</option>
            <option value="enterprise" <?= ($selectedPlan ?? '') === 'enterprise' ? 'selected' : '' ?>>Enterprise (20 Device — Kuota 50.000 pesan/hari)</option>
        </select>
    </div>

    <button type="submit" class="w-full bg-[#16A36A] hover:bg-[#128557] text-white text-sm font-semibold py-2.5 rounded-md transition-colors shadow-xs mt-2">
        Buat Akun & Mulai Scan QR
    </button>
</form>

<div class="mt-6 pt-6 border-t border-[#E4EAE6] text-center text-xs text-[#697570]">
    Sudah memiliki akun? 
    <a href="<?= url('/login') ?>" class="text-[#16A36A] hover:underline font-semibold">Masuk di sini</a>
</div>
