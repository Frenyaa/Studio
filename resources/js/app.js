import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// Plugin x-intersect cho hiệu ứng đếm số khi cuộn tới
Alpine.plugin(intersect);

window.Alpine = Alpine;

Alpine.start();

// ── Scroll Reveal: lộ dần phần tử .reveal khi cuộn tới (phong cách clean editorial) ──
document.addEventListener('DOMContentLoaded', () => {
    const els = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window) || els.length === 0) {
        els.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );

    els.forEach((el) => observer.observe(el));
});
