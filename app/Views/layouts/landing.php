<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'NyautWa — WhatsApp Gateway SaaS Indonesia') ?></title>
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
                        "inverse-surface": "#28332f", "inverse-on-surface": "#e7f4ed",
                        "secondary": "#56615e", "secondary-fixed": "#dae5e1", "secondary-fixed-dim": "#bec9c5",
                        "tertiary-fixed-dim": "#bdc9c3",
                        "error": "#ba1a1a", "error-container": "#ffdad6", "on-error-container": "#93000a"
                    },
                    fontFamily: {
                        sans: ['Geist', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                        display: ['Geist', 'sans-serif'],
                        'body-md': ['Geist', 'sans-serif'],
                        'headline-sm': ['Geist', 'sans-serif'],
                        'headline-lg': ['Geist', 'sans-serif'],
                        'label-md': ['Geist', 'sans-serif'],
                        'label-sm': ['Geist', 'sans-serif'],
                        'code-sm': ['JetBrains Mono', 'monospace'],
                        'code-md': ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="<?= url('/assets/css/app.css') ?>">
</head>
<body class="bg-surface font-sans text-on-surface antialiased min-h-screen">
    <!-- Sticky Navigation Header -->
    <header class="sticky top-0 z-50 w-full bg-surface-container-lowest/95 backdrop-blur-md border-b border-surface-container-high/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 md:px-12 h-16 flex items-center justify-between">
            <div class="flex items-center gap-10">
                <a class="flex items-center gap-2.5" href="<?= url('/') ?>">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white shadow-sm">
                        <span class="material-symbols-outlined text-lg">chat</span>
                    </div>
                    <span class="text-lg font-bold tracking-tight text-on-surface font-sans">Nyaut<span class="text-primary font-semibold">Wa</span></span>
                </a>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium" href="#fitur">Fitur</a>
                    <a class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium" href="#api">Dokumentasi API</a>
                    <a class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium" href="#harga">Harga</a>
                    <a class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium" href="#faq">FAQ</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <a class="hidden sm:inline-flex px-3.5 py-2 text-sm text-on-surface hover:text-primary transition-colors font-medium" href="<?= url('/login') ?>">Masuk</a>
                <a class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-primary-container transition-all" href="<?= url('/register') ?>">
                    <span>Mulai Gratis</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
                <button id="landing-menu-toggle" class="md:hidden p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container" type="button" aria-label="Menu">
                    <span class="material-symbols-outlined text-[22px]">menu</span>
                </button>
            </div>
        </div>
        <div id="landing-mobile-nav" class="hidden md:hidden border-t border-surface-container-high bg-surface-container-lowest px-6 py-3 space-y-2">
            <a class="block text-xs text-on-surface hover:text-primary font-medium py-1" href="#fitur">Fitur</a>
            <a class="block text-xs text-on-surface hover:text-primary font-medium py-1" href="#api">Dokumentasi API</a>
            <a class="block text-xs text-on-surface hover:text-primary font-medium py-1" href="#harga">Harga</a>
            <a class="block text-xs text-on-surface hover:text-primary font-medium py-1" href="#faq">FAQ</a>
            <div class="pt-2 border-t border-surface-container flex items-center justify-between sm:hidden">
                <a class="text-xs text-on-surface font-medium hover:text-primary" href="<?= url('/login') ?>">Masuk</a>
            </div>
        </div>
    </header>

    <main class="w-full">
        <?= $content ?>
    </main>

    <script src="<?= url('/assets/js/app.js') ?>"></script>
</body>
</html>
