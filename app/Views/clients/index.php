<div class="flex flex-col w-full space-y-6">
    <!-- Top Action Ribbon -->
    <?php require __DIR__ . '/partials/header.php'; ?>

    <!-- Client / Tenant Data Table Bento Card -->
    <div class="p-6 rounded-2xl bg-white shadow-xs border border-[#E4EAE6]">
        <?php require __DIR__ . '/partials/table.php'; ?>
    </div>

    <!-- Modals -->
    <?php require __DIR__ . '/partials/modal_create.php'; ?>
    <?php require __DIR__ . '/partials/modal_delete.php'; ?>
    <?php require __DIR__ . '/partials/modal_new_feature.php'; ?>
</div>
