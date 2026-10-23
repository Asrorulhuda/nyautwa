<!-- Hero Section Container -->
<section class="relative pt-16 pb-20 lg:pt-24 lg:pb-32 overflow-hidden bg-surface">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
            <?php require __DIR__ . '/partials/hero.php'; ?>
            <?php require __DIR__ . '/partials/hero_terminal.php'; ?>
        </div>
    </div>
</section>

<!-- Product Benefits (4 Grid Cards) -->
<?php require __DIR__ . '/partials/features.php'; ?>

<!-- Authentic Dashboard Demonstration -->
<?php require __DIR__ . '/partials/dashboard_preview.php'; ?>

<!-- Developer Experience (cURL & Specs) -->
<?php require __DIR__ . '/partials/developer_code.php'; ?>

<!-- Transparent Pricing (Starter, Pro, Business) -->
<?php require __DIR__ . '/partials/pricing.php'; ?>

<!-- Interactive FAQ Accordion -->
<?php require __DIR__ . '/partials/faq.php'; ?>

<!-- Comprehensive Footer -->
<?php require __DIR__ . '/partials/footer.php'; ?>

<script>
    // FAQ Accordion Interaction
    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('.material-symbols-outlined');
            const isHidden = content.classList.contains('hidden');

            document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.faq-toggle .material-symbols-outlined').forEach(i => i.style.transform = 'rotate(0deg)');

            if (isHidden) {
                content.classList.remove('hidden');
                if (icon) icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Copy Code Snippet Interaction
    const copyBtn = document.getElementById('copy-btn');
    if (copyBtn) {
        copyBtn.addEventListener('click', () => {
            const orig = copyBtn.innerHTML;
            copyBtn.innerHTML = '<span class="material-symbols-outlined text-[16px] text-primary">check</span><span class="text-primary font-semibold">Tersalin!</span>';
            setTimeout(() => { copyBtn.innerHTML = orig; }, 2000);
        });
    }
</script>
