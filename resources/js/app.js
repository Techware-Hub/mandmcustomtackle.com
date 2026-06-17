import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-in-out',
    });

    const menuButton = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('#mobile-menu');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            menuButton.setAttribute('aria-expanded', String(!isOpen));
        });
    }

    const revealItems = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealItems.forEach((item) => observer.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    }

    const filterButtons = document.querySelectorAll('[data-filter]');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.getAttribute('data-filter');
            galleryItems.forEach((item) => {
                const matches = filter === 'All' || item.getAttribute('data-category') === filter;
                item.closest('.break-inside-avoid')?.classList.toggle('hidden', !matches);
            });
        });
    });

    document.querySelectorAll('[data-slider]').forEach((slider) => {
        const viewport = slider.querySelector('[data-slider-viewport]');
        const previous = slider.querySelector('[data-slider-prev]');
        const next = slider.querySelector('[data-slider-next]');
        const dots = Array.from(slider.querySelectorAll('[data-slider-dot]'));

        if (!viewport) {
            return;
        }

        const scrollByCard = (direction) => {
            const card = viewport.querySelector('[data-slider-card]');
            const distance = card ? card.getBoundingClientRect().width + 24 : viewport.clientWidth;
            viewport.scrollBy({ left: distance * direction, behavior: 'smooth' });
        };

        previous?.addEventListener('click', () => scrollByCard(-1));
        next?.addEventListener('click', () => scrollByCard(1));

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                viewport.scrollTo({ left: viewport.clientWidth * index, behavior: 'smooth' });
            });
        });

        const updateDots = () => {
            if (!dots.length) {
                return;
            }

            const index = Math.round(viewport.scrollLeft / Math.max(viewport.clientWidth, 1));
            dots.forEach((dot, dotIndex) => {
                dot.classList.toggle('bg-sky-500', dotIndex === index);
                dot.classList.toggle('bg-sky-200', dotIndex !== index);
            });
        };

        viewport.addEventListener('scroll', updateDots, { passive: true });
        updateDots();
    });
});
