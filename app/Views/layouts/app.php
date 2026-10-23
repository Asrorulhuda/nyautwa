<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Dashboard') ?> — NyautWa Gateway</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2316A36A'><path d='M12 2C6.48 2 2 6.48 2 12c0 1.82.49 3.53 1.34 5L2 22l5.2-1.31A9.95 9.95 0 0 0 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2z'/></svg>">
    
    <!-- Design System Typography & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Utility Framework) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#16A36A',
                        'primary-hover': '#128557',
                        'primary-tint': '#EAF7F0',
                        canvas: '#F6F8F7',
                        surface: '#FFFFFF',
                        'surface-dark': '#17211F',
                        border: '#E4EAE6',
                        'text-primary': '#17211F',
                        'text-secondary': '#697570',
                    },
                    fontFamily: {
                        sans: ['Geist', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>">
</head>
<body class="bg-[#F6F8F7] text-[#17211F] flex min-h-screen">
    <!-- Main Left Sidebar -->
    <?php \App\Core\View::partial('partials/sidebar'); ?>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Sticky Header -->
        <?php \App\Core\View::partial('partials/header'); ?>

        <!-- Page View Body -->
        <main class="flex-1 p-8 overflow-y-auto">
            <!-- Flash Message Alerts -->
            <?php \App\Core\View::partial('partials/flash'); ?>

            <!-- Rendered Dynamic Content -->
            <?= $content ?>
        </main>
    </div>

    <!-- Application Vanilla JS -->
    <script src="<?= url('/assets/js/app.js') ?>"></script>
</body>
</html>
