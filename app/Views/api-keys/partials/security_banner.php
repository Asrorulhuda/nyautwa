<!-- Developer Security Guidance Banner -->
<div class="relative overflow-hidden rounded-xl bg-surface-container-low p-4 mb-6 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border border-surface-container-high/60">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
    <div class="flex items-start gap-3.5 pl-2">
        <div class="p-2 rounded-lg bg-surface-container-lowest text-primary shadow-xs shrink-0">
            <span class="material-symbols-outlined text-[24px]">gshield</span>
        </div>
        <div class="flex flex-col">
            <span class="text-sm text-on-surface font-semibold tracking-tight">
                Praktik Keamanan Kunci Rahasia
            </span>
            <p class="text-xs text-on-surface-variant mt-0.5 leading-relaxed">
                Jaga kerahasiaan API Key Anda. Jangan pernah membagikan atau menyimpan kunci rahasia ini di kode frontend publik (seperti GitHub client-side repository). Gunakan environment variable pada server backend Anda.
            </p>
        </div>
    </div>
    <a class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-surface-container-lowest text-primary text-xs font-semibold hover:bg-surface-container transition-colors shadow-xs shrink-0 whitespace-nowrap self-end sm:self-auto" href="#">
        <span>Security Guide</span>
        <span class="material-symbols-outlined text-[16px]">north_east</span>
    </a>
</div>
