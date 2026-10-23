<!-- Top Command Ribbon -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <div class="flex items-center gap-1.5 text-xs text-primary uppercase tracking-wider font-semibold">
            <span class="w-2 h-2 rounded-full bg-primary"></span>
            <span>Credentials & Security</span>
        </div>
        <h1 class="text-2xl font-bold text-on-surface tracking-tight">API Keys</h1>
        <p class="text-xs text-on-surface-variant max-w-2xl">
            Kelola token autentikasi rahasia untuk mengirim pesan dan mengakses REST API NyautWa secara aman.
        </p>
    </div>
    <div class="flex items-center gap-2.5 self-start md:self-center">
        <button onclick="openModal('modal-create-key')" class="h-10 px-4 rounded-lg bg-primary text-white text-xs font-semibold flex items-center gap-2 hover:bg-primary-container shadow-xs active:scale-[0.98] transition-all cursor-pointer" type="button">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>Buat API Key Baru</span>
        </button>
    </div>
</div>
