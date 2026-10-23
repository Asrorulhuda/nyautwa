<div class="flex flex-col w-full">
    <!-- Top Command Ribbon & Header -->
    <?php require __DIR__ . '/partials/header.php'; ?>

    <!-- 4 KPI Telemetry Cards -->
    <?php require __DIR__ . '/partials/metrics.php'; ?>

    <!-- Middle Split: Left (Chart & Activity Log) + Right (Devices & Webhook) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left 8 Columns -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            <?php require __DIR__ . '/partials/chart.php'; ?>
            <?php require __DIR__ . '/partials/recent_table.php'; ?>
        </div>

        <!-- Right 4 Columns -->
        <div class="lg:col-span-4">
            <?php require __DIR__ . '/partials/devices_widget.php'; ?>
        </div>
    </div>
</div>
