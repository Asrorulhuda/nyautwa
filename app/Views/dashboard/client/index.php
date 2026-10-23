<div class="flex flex-col w-full space-y-6">
    <!-- Top Command Ribbon & Header -->
    <?php require __DIR__ . '/header.php'; ?>

    <!-- Bento Top Row: 4 Client Workspace KPI Cards -->
    <?php require __DIR__ . '/metrics.php'; ?>

    <!-- Bento Grid Core: Modern 12-Column Responsive Bento Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Bento Block 1: Client Message Volume Chart (8 Cols) -->
        <div class="lg:col-span-8">
            <?php require __DIR__ . '/chart.php'; ?>
        </div>

        <!-- Bento Block 2: WhatsApp Device Session Card (4 Cols) -->
        <div class="lg:col-span-4">
            <?php require __DIR__ . '/device_card.php'; ?>
        </div>

        <!-- Bento Block 3: Recent Messages Outbox Table (8 Cols) -->
        <div class="lg:col-span-8">
            <?php require __DIR__ . '/recent_messages.php'; ?>
        </div>

        <!-- Bento Block 4: Fast REST API Integration Quickstart (4 Cols) -->
        <div class="lg:col-span-4">
            <?php require __DIR__ . '/api_quickstart.php'; ?>
        </div>
    </div>
</div>
