// Scroll Reveal Observer
document.addEventListener('DOMContentLoaded', () => {
    const reveals = document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right, .zoom-in');

    if (!reveals.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    reveals.forEach(el => observer.observe(el));
});

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('mobile-menu-toggle');
    const drawer = document.getElementById('mobile-drawer');
    const overlay = document.getElementById('mobile-overlay');

    if (!toggle || !drawer) return;

    const openMenu = () => {
        drawer.classList.remove('translate-x-full');
        overlay?.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    const closeMenu = () => {
        drawer.classList.add('translate-x-full');
        overlay?.classList.add('hidden');
        document.body.style.overflow = '';
    };

    toggle.addEventListener('click', openMenu);
    overlay?.addEventListener('click', closeMenu);

    // Close on link click
    drawer.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
});
