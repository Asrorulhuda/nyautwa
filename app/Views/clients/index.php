<div class="flex flex-col w-full space-y-6">
    <!-- Top Action Ribbon -->
    <?php require __DIR__ . '/partials/header.php'; ?>

    <!-- Client / Tenant Data Table Bento Card -->
    <div class="p-6 rounded-xl bg-surface-container-lowest shadow-xs border border-surface-container-high/60">
        <?php require __DIR__ . '/partials/table.php'; ?>
    </div>

    <!-- Modals -->
    <?php require __DIR__ . '/partials/modal_create.php'; ?>
    <?php require __DIR__ . '/partials/modal_edit.php'; ?>
</div>
