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
        <div class="text-center mb-6">
            <a href="<?= url('/') ?>" class="inline-flex flex-col items-center">
                <img src="<?= url('/assets/images/logo.png') ?>" alt="NyautWa Logo" class="h-16 w-auto object-contain mb-2 drop-shadow-sm">
                <div class="flex items-center gap-1.5">
                    <span class="text-2xl font-black tracking-tight text-[#17211F]">Nyaut<span class="text-[#16A36A]">Wa</span></span>
                    <span class="text-[9.5px] bg-amber-500/10 text-amber-700 border border-amber-500/30 px-2 py-0.5 rounded-full font-mono font-bold tracking-wide">GATEWAY + CRM</span>
                </div>
            </a>
            <p class="text-xs text-[#697570] mt-1 font-medium">WhatsApp Gateway & Live CRM Pelanggan Terpadu</p>
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
