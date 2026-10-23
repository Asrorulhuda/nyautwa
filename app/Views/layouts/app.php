<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Dashboard') ?> — NyautWa Gateway</title>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "background": "#f0fcf6", "surface": "#f0fcf6",
                        "surface-container-lowest": "#ffffff", "surface-container-low": "#eaf7f0",
                        "surface-container": "#e4f1ea", "surface-container-high": "#deebe5",
                        "surface-container-highest": "#d9e5df",
                        "primary": "#006a42", "primary-container": "#008655", "on-primary": "#ffffff",
                        "primary-fixed-dim": "#62dd9e", "primary-fixed": "#80fab9",
                        "on-surface": "#131e1a", "on-surface-variant": "#3d4a41",
                        "outline": "#6d7a70", "outline-variant": "#bccabf",
                        "inverse-surface": "#0c1513", "inverse-on-surface": "#e7f4ed",
                        "secondary": "#56615e", "secondary-container": "#d7e2de", "on-secondary-container": "#5a6562",
                        "error": "#ba1a1a", "error-container": "#ffdad6", "on-error-container": "#93000a",
                        canvas: '#F6F8F7'
                    },
                    fontFamily: {
                        sans: ['Geist', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                        'body-md': ['Geist', 'sans-serif'],
                        'headline-sm': ['Geist', 'sans-serif'],
                        'headline-lg': ['Geist', 'sans-serif'],
                        'label-sm': ['Geist', 'sans-serif'],
                        'label-md': ['Geist', 'sans-serif'],
                        'code-sm': ['JetBrains Mono', 'monospace'],
                        'code-md': ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>">
</head>
<body class="bg-surface font-sans text-on-surface antialiased flex min-h-screen">
    <!-- Main Left Sidebar -->
    <?php \App\Core\View::partial('partials/sidebar'); ?>

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden transition-opacity"></div>

    <!-- Main Content Container -->
    <div class="pl-0 lg:pl-60 flex-1 flex flex-col min-w-0 min-h-screen">
        <!-- Top Sticky Header -->
        <?php \App\Core\View::partial('partials/header'); ?>

        <!-- Page View Body -->
        <main class="w-full flex-1 bg-surface-container-low/40 p-4 sm:p-6 md:p-8">
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
