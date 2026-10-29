<!-- Upsell Locked Feature Modal -->
<div id="modal-upsell" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-4 transition-all">
    <div class="relative w-full max-w-sm rounded-2xl bg-[#0c1513] text-white p-6 shadow-2xl border border-emerald-500/30 space-y-4 text-center animate-in fade-in zoom-in-95 duration-200">
        <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center">
            <span class="material-symbols-outlined text-[26px]">lock</span>
        </div>
        <div>
            <span class="text-[10px] font-mono uppercase tracking-wider text-amber-400 font-semibold px-2 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/20">Fitur Eksklusif</span>
            <h3 id="upsell-title" class="text-base font-bold text-white mt-2">Fitur Terkunci</h3>
            <p id="upsell-desc" class="text-xs text-outline-variant mt-1.5 leading-relaxed">
                Fitur ini tidak aktif pada paket langganan Anda saat ini. Tingkatkan paket untuk membuka akses penuh ke fitur ini.
            </p>
        </div>
        <div class="pt-2 flex flex-col gap-2">
            <a href="<?= url('/onboarding/plan') ?>" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold text-xs shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">rocket_launch</span>
                <span>Upgrade Paket Sekarang</span>
            </a>
            <button onclick="closeUpsellModal()" type="button" class="w-full py-2 px-4 rounded-xl bg-white/5 hover:bg-white/10 text-outline-variant text-xs font-medium transition-colors">
                Nanti Saja
            </button>
        </div>
    </div>
</div>

<script>
    function openUpsellModal(featureName, featureDesc) {
        document.getElementById('upsell-title').innerText = 'Fitur ' + (featureName || '') + ' Terkunci';
        if (featureDesc) document.getElementById('upsell-desc').innerText = featureDesc;
        const modal = document.getElementById('modal-upsell');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeUpsellModal() {
        const modal = document.getElementById('modal-upsell');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
