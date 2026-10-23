/**
 * NyautWa Client Application JS
 * Lightweight, vanilla JavaScript adhering to Senior Code Craft
 */
document.addEventListener('DOMContentLoaded', () => {
    // 1. Copy to Clipboard Utility via data-copy attribute
    document.querySelectorAll('[data-copy]').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const textToCopy = button.getAttribute('data-copy');
            if (!textToCopy) return;
            try {
                await navigator.clipboard.writeText(textToCopy);
                const originalHtml = button.innerHTML;
                button.innerHTML = '<span class="material-symbols-outlined text-xs text-[#16A36A]">check</span><span class="text-xs text-[#16A36A] font-medium ml-1">Tersalin!</span>';
                setTimeout(() => { button.innerHTML = originalHtml; }, 2000);
            } catch (err) {
                console.error('Gagal menyalin:', err);
            }
        });
    });

    // 2. Keyboard shortcut for global search
    const searchInput = document.querySelector('input[type="search"], input[name="q"], #global-search');
    if (searchInput) {
        window.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement !== searchInput && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }

    // 3. Auto dismiss flash alerts
    document.querySelectorAll('.flash-alert').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // 4. Mobile Sidebar Drawer Toggle
    const sidebar = document.getElementById('app-sidebar');
    const toggleBtn = document.getElementById('mobile-sidebar-toggle');
    const closeBtn = document.getElementById('mobile-sidebar-close');
    const backdrop = document.getElementById('sidebar-backdrop');
    if (toggleBtn) toggleBtn.addEventListener('click', () => {
        sidebar?.classList.remove('-translate-x-full');
        backdrop?.classList.remove('hidden');
    });
    const hideDrawer = () => {
        sidebar?.classList.add('-translate-x-full');
        backdrop?.classList.add('hidden');
    };
    if (closeBtn) closeBtn.addEventListener('click', hideDrawer);
    if (backdrop) backdrop.addEventListener('click', hideDrawer);

    // 5. Landing Mobile Navigation Toggle
    const landingToggle = document.getElementById('landing-menu-toggle');
    const landingNav = document.getElementById('landing-mobile-nav');
    if (landingToggle && landingNav) {
        landingToggle.addEventListener('click', () => landingNav.classList.toggle('hidden'));
    }
});

// Global Modal & Clipboard Helpers
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

function copyToClipboard(text) {
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        alert('Kunci API berhasil disalin ke clipboard!');
    }).catch(err => console.error('Gagal menyalin:', err));
}
