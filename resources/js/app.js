import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

document.addEventListener('DOMContentLoaded', () => {
    const applyTheme = (scope, theme) => {
        document.documentElement.dataset.theme = theme;
        document.documentElement.classList.toggle('site-dark', theme === 'dark' && scope === 'public');
        document.documentElement.classList.toggle('admin-light', theme === 'light' && scope === 'admin');
        document.querySelectorAll(`[data-theme-label="${scope}"]`).forEach((label) => {
            label.textContent = theme === 'dark' ? 'Dark' : 'Light';
        });
    };

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const scope = button.getAttribute('data-theme-scope') || 'public';
        const defaultTheme = scope === 'admin' ? 'dark' : 'light';
        const key = `${scope}-theme`;
        applyTheme(scope, localStorage.getItem(key) || defaultTheme);

        button.addEventListener('click', () => {
            const nextTheme = (localStorage.getItem(key) || defaultTheme) === 'dark' ? 'light' : 'dark';
            localStorage.setItem(key, nextTheme);
            applyTheme(scope, nextTheme);
        });
    });

    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-in-out',
    });

    const menuButton = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('#mobile-menu');
    const adminSidebar = document.querySelector('#admin-sidebar');
    const adminSidebarToggle = document.querySelector('.admin-sidebar-toggle');
    const adminSidebarClose = document.querySelector('.admin-sidebar-close');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            menuButton.setAttribute('aria-expanded', String(!isOpen));
        });
    }

    adminSidebarToggle?.addEventListener('click', () => {
        adminSidebar?.classList.toggle('hidden');
    });

    adminSidebarClose?.addEventListener('click', () => {
        adminSidebar?.classList.add('hidden');
    });

    document.querySelectorAll('[data-admin-sidebar]').forEach((sidebar) => {
        const activeDropdown = sidebar.getAttribute('data-active-dropdown') || '';
        const storageKey = 'admin-sidebar-open-dropdown';
        const storedDropdown = localStorage.getItem(storageKey);
        const initialDropdown = activeDropdown || storedDropdown || '';
        const groups = Array.from(sidebar.querySelectorAll('[data-dropdown-group]'));

        const setOpenDropdown = (key, persist = true) => {
            groups.forEach((group) => {
                const groupKey = group.getAttribute('data-dropdown-group');
                const isOpen = groupKey === key;
                const toggle = group.querySelector('[data-dropdown-toggle]');
                const panel = group.querySelector('[data-dropdown-panel]');
                const chevron = group.querySelector('.admin-nav-chevron');

                toggle?.setAttribute('aria-expanded', String(isOpen));
                toggle?.classList.toggle('border-sky-500/40', isOpen);
                toggle?.classList.toggle('bg-sky-500/15', isOpen);
                toggle?.classList.toggle('text-sky-100', isOpen);
                panel?.classList.toggle('grid-rows-[1fr]', isOpen);
                panel?.classList.toggle('grid-rows-[0fr]', !isOpen);
                chevron?.classList.toggle('rotate-180', isOpen);
            });

            if (persist) {
                if (key) {
                    localStorage.setItem(storageKey, key);
                } else {
                    localStorage.removeItem(storageKey);
                }
            }
        };

        setOpenDropdown(initialDropdown, false);

        groups.forEach((group) => {
            const key = group.getAttribute('data-dropdown-group');
            const toggle = group.querySelector('[data-dropdown-toggle]');

            toggle?.addEventListener('click', () => {
                const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                setOpenDropdown(isOpen ? '' : key);
            });
        });
    });

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
