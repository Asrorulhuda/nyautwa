<div class="mb-6">
    <h1 class="text-xl font-bold text-[#17211F] mb-1 font-['Geist']">Masuk ke Akun Anda</h1>
    <p class="text-xs text-[#697570]">Kelola device WhatsApp, antrean pesan, dan API key bisnis Anda.</p>
</div>

<form action="<?= url('/login') ?>" method="POST" class="space-y-4">
    <?= csrf_field() ?>

    <div>
        <label for="email" class="block text-xs font-semibold text-[#17211F] mb-1.5">Alamat Email Bisnis</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            required 
            maxlength="255"
            autocomplete="email"
            placeholder="nama@perusahaan.com" 
            value="<?= e(old('email')) ?>"
            class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
        >
    </div>

    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-xs font-semibold text-[#17211F]">Kata Sandi</label>
        </div>
        <input 
            type="password" 
            id="password" 
            name="password" 
            required 
            maxlength="128"
            autocomplete="current-password"
            placeholder="••••••••••••" 
            class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all"
        >
    </div>

    <button type="submit" class="w-full bg-[#16A36A] hover:bg-[#128557] text-white text-sm font-semibold py-2.5 rounded-md transition-colors shadow-xs mt-2">
        Masuk ke Dashboard
    </button>
</form>

<div class="mt-6 pt-6 border-t border-[#E4EAE6] text-center text-xs text-[#697570]">
    Belum memiliki akun? 
    <a href="<?= url('/register') ?>" class="text-[#16A36A] hover:underline font-semibold">Daftar akun baru</a>
</div>
