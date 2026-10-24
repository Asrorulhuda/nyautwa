<div class="flex flex-col w-full max-w-7xl mx-auto space-y-2 pb-12">
    <!-- Top Header Ribbon -->
    <?php require __DIR__ . '/partials/header.php'; ?>

    <!-- Panduan Integrasi Cepat (Sipanda, Drop-In, PHP, Laravel, Node.js) -->
    <?php require __DIR__ . '/partials/integration_guide.php'; ?>

    <!-- 1. Authentication & Headers -->
    <?php require __DIR__ . '/partials/auth_spec.php'; ?>


    <!-- 2. Endpoints Summary Table -->
    <?php require __DIR__ . '/partials/endpoints_table.php'; ?>

    <!-- 3. Messages API Specification -->
    <?php require __DIR__ . '/partials/messages_spec.php'; ?>

    <!-- 4. Devices & Utility Specification -->
    <?php require __DIR__ . '/partials/devices_spec.php'; ?>

    <!-- 5. Webhook Specification -->
    <?php require __DIR__ . '/partials/webhook_spec.php'; ?>

    <!-- 6. Errors & Status Codes -->
    <?php require __DIR__ . '/partials/errors_spec.php'; ?>
</div>
