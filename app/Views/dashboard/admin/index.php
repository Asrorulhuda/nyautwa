<div class="flex flex-col w-full space-y-6">
    <!-- Top Command Ribbon & Header -->
    <?php require __DIR__ . '/header.php'; ?>

    <!-- Bento Top Row: 4 SaaS Admin Telemetry Cards -->
    <?php require __DIR__ . '/metrics.php'; ?>

    <!-- Bento Grid Core: Modern 12-Column Responsive Bento Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Bento Block 1: Global Message Throughput Chart (8 Cols) -->
        <div class="lg:col-span-8">
            <?php require __DIR__ . '/chart.php'; ?>
        </div>

        <!-- Bento Block 2: SaaS Plan Distribution & Engine Health (4 Cols) -->
        <div class="lg:col-span-4">
            <?php require __DIR__ . '/engine_widget.php'; ?>
        </div>

        <!-- Bento Block 3: Recent Tenants Table (8 Cols) -->
        <div class="lg:col-span-8">
            <?php require __DIR__ . '/tenants_table.php'; ?>
        </div>

        <!-- Bento Block 4: Platform Quick Actions & Controls (4 Cols) -->
        <div class="lg:col-span-4">
            <?php require __DIR__ . '/quick_actions.php'; ?>
        </div>
    </div>
</div>
