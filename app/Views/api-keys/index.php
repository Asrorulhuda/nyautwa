<div class="flex flex-col w-full">
    <!-- Top Command Ribbon -->
    <?php require __DIR__ . '/partials/header.php'; ?>

    <!-- Developer Security Guidance Banner -->
    <?php require __DIR__ . '/partials/security_banner.php'; ?>

    <!-- Main Split Architecture: Keys Table & Analytics Sidebar -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 mb-8">
        <!-- Keys Management View (8 cols on XL) -->
        <div class="xl:col-span-8">
            <?php require __DIR__ . '/partials/keys_list.php'; ?>
        </div>

        <!-- Security Insights & Webhook Configuration (4 cols on XL) -->
        <div class="xl:col-span-4">
            <?php require __DIR__ . '/partials/right_sidebar.php'; ?>
        </div>
    </div>

    <!-- Quick Documentation Reference Card -->
    <?php require __DIR__ . '/partials/curl_guide.php'; ?>

    <!-- Modals -->
    <?php require __DIR__ . '/partials/modal_create.php'; ?>
</div>
