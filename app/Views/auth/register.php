<div class="mb-5">
    <h1 class="text-xl font-bold text-[#17211F] mb-1 font-['Geist']">Daftar Akun Baru</h1>
    <p class="text-xs text-[#697570]">Mulai hubungkan nomor WhatsApp bisnis Anda dalam hitungan menit.</p>
</div>

<form action="<?= url('/register') ?>" method="POST" enctype="multipart/form-data" class="space-y-3.5">
    <?= csrf_field() ?>

    <div>
        <label for="company" class="block text-xs font-semibold text-[#17211F] mb-1">Nama Perusahaan / Bisnis</label>
        <input type="text" id="company" name="company" required maxlength="150" placeholder="PT Maju Bersama Digital" value="<?= e(old('company')) ?>" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label for="industry" class="block text-xs font-semibold text-[#17211F] mb-1">Kategori Industri</label>
            <select id="industry" name="industry" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-xs text-[#17211F] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A]">
                <option value="E-Commerce & Retail">E-Commerce & Retail</option>
                <option value="Teknologi & Digital">Teknologi & Digital</option>
                <option value="Finansial & Fintech">Finansial & Fintech</option>
                <option value="Kuliner & F&B">Kuliner & F&B</option>
                <option value="Jasa & Konsultan">Jasa & Konsultan</option>
                <option value="Kesehatan & Klinik">Kesehatan & Klinik</option>
                <option value="Pendidikan & Kursus">Pendidikan & Kursus</option>
                <option value="Bisnis Lainnya">Bisnis Lainnya</option>
            </select>
        </div>
        <div>
            <label for="logo" class="block text-xs font-semibold text-[#17211F] mb-1">Upload Logo Usaha <span class="text-[10px] text-[#697570] font-normal">(Opsional, Maks 2MB)</span></label>
            <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="w-full px-2 py-1.5 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-xs text-[#697570] file:mr-2 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-[11px] file:font-semibold file:bg-[#EAF7F0] file:text-[#16A36A] hover:file:bg-[#d8f0e4] cursor-pointer">
        </div>
    </div>

    <div>
        <label for="name" class="block text-xs font-semibold text-[#17211F] mb-1">Nama Penanggung Jawab</label>
        <input type="text" id="name" name="name" required maxlength="150" placeholder="Ahmad Fauzi" value="<?= e(old('name')) ?>" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all">
    </div>

    <div>
        <label for="email" class="block text-xs font-semibold text-[#17211F] mb-1">Email Bisnis</label>
        <input type="email" id="email" name="email" required maxlength="255" autocomplete="email" placeholder="ahmad@perusahaan.com" value="<?= e(old('email')) ?>" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label for="password" class="block text-xs font-semibold text-[#17211F] mb-1">Kata Sandi (Min. 12 Karakter)</label>
            <input type="password" id="password" name="password" required minlength="12" maxlength="128" autocomplete="new-password" placeholder="••••••••••••" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all">
        </div>
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-[#17211F] mb-1">Konfirmasi Kata Sandi</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="12" maxlength="128" autocomplete="new-password" placeholder="••••••••••••" class="w-full px-3 py-2 bg-[#FFFFFF] border border-[#E4EAE6] rounded-md text-sm text-[#17211F] placeholder-[#697570] focus:outline-none focus:border-[#16A36A] focus:ring-1 focus:ring-[#16A36A] transition-all">
        </div>
    </div>

    <button type="submit" class="w-full bg-[#16A36A] hover:bg-[#128557] text-white text-sm font-semibold py-2.5 rounded-md transition-colors shadow-xs mt-2">
        Buat Akun Bisnis
    </button>
</form>

<div class="mt-5 pt-5 border-t border-[#E4EAE6] text-center text-xs text-[#697570]">
    Sudah memiliki akun? 
    <a href="<?= url('/login') ?>" class="text-[#16A36A] hover:underline font-semibold">Masuk di sini</a>
</div>
