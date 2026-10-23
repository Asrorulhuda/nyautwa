<div class="flex flex-col w-full space-y-6">
    <!-- Top Command Ribbon & Header -->
    <?php require __DIR__ . '/partials/header.php'; ?>

    <!-- Bento Top Row: 4 KPI Telemetry Cards -->
    <?php require __DIR__ . '/partials/metrics.php'; ?>

    <!-- Bento Grid Core: Modern 12-Column Responsive Bento Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Bento Block 1: Chart Tren Pesan (8 Cols) -->
        <div class="lg:col-span-8">
            <?php require __DIR__ . '/partials/chart.php'; ?>
        </div>

        <!-- Bento Block 2: WhatsApp Session Monitor (4 Cols) -->
        <div class="lg:col-span-4">
            <?php require __DIR__ . '/partials/devices_widget.php'; ?>
        </div>

        <!-- Bento Block 3: Log Aktivitas Pesan Terbaru (8 Cols) -->
        <div class="lg:col-span-8">
            <?php require __DIR__ . '/partials/recent_table.php'; ?>
        </div>

        <!-- Bento Block 4: Webhook & SLA Telemetry (4 Cols) -->
        <div class="lg:col-span-4">
            <?php require __DIR__ . '/partials/webhook_widget.php'; ?>
        </div>
    </div>
</div>
