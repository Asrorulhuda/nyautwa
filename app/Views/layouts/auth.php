<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Autentikasi') ?> — NyautWa</title>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#16A36A',
                        'primary-hover': '#128557',
                        'primary-tint': '#EAF7F0',
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
<body class="bg-[#F6F8F7] text-[#17211F] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo Header -->
        <div class="text-center mb-8">
            <a href="<?= url('/') ?>" class="inline-flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-lg bg-[#16A36A] flex items-center justify-center text-white shadow-sm">
                    <span class="material-symbols-outlined text-2xl">chat</span>
                </div>
                <span class="text-2xl font-bold tracking-tight text-[#17211F]">NyautWa</span>
            </a>
            <p class="text-xs text-[#697570] mt-1.5 font-medium">WhatsApp Gateway SaaS untuk Developer & Bisnis</p>
        </div>

        <!-- Flash messages -->
        <?php \App\Core\View::partial('partials/flash'); ?>

        <!-- Form Card Container -->
        <div class="bg-[#FFFFFF] border border-[#E4EAE6] rounded-xl p-8 shadow-xs">
            <?= $content ?>
        </div>
    </div>
</body>
</html>
