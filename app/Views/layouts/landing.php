<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'NyautWa — WhatsApp Gateway SaaS Indonesia') ?></title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2316A36A'><path d='M12 2C6.48 2 2 6.48 2 12c0 1.82.49 3.53 1.34 5L2 22l5.2-1.31A9.95 9.95 0 0 0 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2z'/></svg>">
    
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
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="bg-[#F6F8F7] text-[#17211F] selection:bg-[#16A36A]/20">
    <!-- Navigation Header -->
    <header class="border-b border-[#E4EAE6] bg-[#FFFFFF]/90 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-md bg-[#16A36A] flex items-center justify-center text-white shadow-xs">
                    <span class="material-symbols-outlined text-lg">chat</span>
                </div>
                <span class="text-lg font-bold tracking-tight text-[#17211F]">NyautWa</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-[#697570]">
                <a href="#fitur" class="hover:text-[#17211F] transition-colors">Fitur Utama</a>
                <a href="#api" class="hover:text-[#17211F] transition-colors">REST API</a>
                <a href="#harga" class="hover:text-[#17211F] transition-colors">Harga Paket</a>
                <a href="#risiko" class="hover:text-[#17211F] transition-colors">Transparansi Risiko</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/login" class="text-sm font-medium text-[#17211F] hover:text-[#16A36A] px-3 py-2 transition-colors">
                    Masuk
                </a>
                <a href="/register" class="bg-[#16A36A] hover:bg-[#128557] text-white text-sm font-semibold px-4 py-2 rounded-md transition-colors shadow-xs">
                    Mulai Uji Coba Gratis
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="border-t border-[#E4EAE6] bg-[#FFFFFF] py-12">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded bg-[#16A36A] flex items-center justify-center text-white text-xs">
                    <span class="material-symbols-outlined text-sm">chat</span>
                </div>
                <span class="font-bold text-sm text-[#17211F]">NyautWa Gateway</span>
                <span class="text-xs text-[#697570] ml-2">© <?= date('Y') ?> PT Teknologi Berkah Indonesia.</span>
            </div>
            <div class="flex gap-6 text-xs text-[#697570]">
                <a href="#risiko" class="hover:text-[#17211F]">Pernyataan Risiko Anti-Ban</a>
                <a href="/login" class="hover:text-[#17211F]">Dashboard Konsol</a>
                <a href="/api-keys" class="hover:text-[#17211F]">Spesifikasi API</a>
            </div>
        </div>
    </footer>

    <script src="/assets/js/app.js"></script>
</body>
</html>
