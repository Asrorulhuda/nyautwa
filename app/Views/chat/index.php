<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#17211F]">Live Chat & CRM Pelanggan</h1>
            <p class="text-sm text-[#697570] mt-1">Interaksi langsung dua arah dengan pelanggan WhatsApp secara terpusat dan realtime.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= url('/messages') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-[#17211F] bg-white border border-[#E4EAE6] hover:bg-[#F6F8F7] rounded-md transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px] text-[#16A36A]">history_edu</span>
                <span>Log Pesan</span>
            </a>
            <a href="<?= url('/messages/send') ?>" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-semibold text-white bg-[#16A36A] hover:bg-[#128557] rounded-md transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px]">send</span>
                <span>Kirim Pesan Baru</span>
            </a>
        </div>
    </div>

    <!-- 2-Column Live Chat Interface -->
    <div class="bg-white border border-[#E4EAE6] rounded-xl overflow-hidden shadow-sm flex flex-col md:flex-row h-[calc(100vh-13rem)] min-h-[520px]">
        <?php require __DIR__ . '/partials/conversation_list.php'; ?>
        <?php require __DIR__ . '/partials/chat_box.php'; ?>
    </div>
</div>

<?php require __DIR__ . '/partials/chat_script.php'; ?>
