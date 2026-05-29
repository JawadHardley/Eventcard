import './bootstrap';

import Alpine from 'alpinejs';

import { Html5Qrcode } from "html5-qrcode";

window.Html5Qrcode = Html5Qrcode; // expose it globallyimport './bootstrap';


window.Alpine = Alpine;

Alpine.start();

if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
        '(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}

/* ── Dark Mode Toggle ── */
const themeToggleBtn = document.getElementById('theme-toggle');
const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
        '(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}
themeToggleBtn.addEventListener('click', function() {
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
});

/* ── Scroll-based navbar ── */
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => { navbar.classList.toggle('scrolled', window.scrollY > 20); }, {
    passive: true });

/* ── Hamburger menu ── */
const hamBtn = document.getElementById('ham-btn');
const mobileMenu = document.getElementById('mobile-menu');
hamBtn.addEventListener('click', () => { hamBtn.classList.toggle('open');
    mobileMenu.classList.toggle('open'); });
document.querySelectorAll('.mobile-nav-link').forEach(link => {
    link.addEventListener('click', () => { hamBtn.classList.remove('open');
        mobileMenu.classList.remove('open'); });
});

/* ── Intersection Observer animations ── */
const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -40px 0px' };
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible');
            observer.unobserve(entry.target); } });
}, observerOptions);
document.querySelectorAll('.fade-up, .fade-in, .scale-in').forEach(el => observer.observe(el));

/* ── Button loading state ── */
function triggerLoading(btn) { btn.classList.add('loading');
    btn.disabled = true;
    setTimeout(() => { btn.classList.remove('loading');
        btn.disabled = false; }, 2400); }

/* ── Modal ── */
function openModal(id) {
    const overlay = document.getElementById('modal-overlay');
    document.querySelectorAll('.modal-box').forEach(m => { m.style.display = m.id === id ? 'block' :
    'none'; });
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() { document.getElementById('modal-overlay').classList.remove('open');
    document.body.style.overflow = ''; }

function handleOverlayClick(e) { if (e.target === document.getElementById('modal-overlay')) closeModal(); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

/* ── Alert dismiss ── */
function dismissAlert(btn) { const alert = btn.closest('.alert');
    alert.style.opacity = '0';
    alert.style.transform = 'translateX(10px)';
    setTimeout(() => alert.remove(), 300); }

/* ── Toast notifications ── */
function showToast(message, type = 'info') {
    const icons = {
        success: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#34c759" stroke-width="2" stroke-linecap="round"/></svg>',
        error: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#ff3b30" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke="#ff3b30" stroke-width="2" stroke-linecap="round"/></svg>',
        info: '<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#0e84e8" stroke-width="2" stroke-linecap="round"/></svg>',
    };
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML =
        `${icons[type] || icons.info}<span class="flex-1 font-medium text-gray-800 dark:text-white">${message}</span><button onclick="this.closest('.toast').remove()" style="background:none;border:none;color:#9e9ea7;cursor:pointer;font-size:1rem;padding:0 .2rem;">✕</button>`;
    container.appendChild(toast);
    requestAnimationFrame(() => { requestAnimationFrame(() => toast.classList.add('show')); });
    setTimeout(() => { toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400); }, 3800);
}

/* ── Tabs ── */
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const group = btn.closest('[id^="tabs-"]');
        if (!group) return;
        group.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const tabId = btn.dataset.tab;
        const allPanels = [];
        let cur = group.nextElementSibling;
        while (cur) { cur.querySelectorAll('.tab-panel').forEach(p => allPanels.push(p));
            cur = cur.nextElementSibling; if (allPanels.length > 0) break; }
        if (allPanels.length) { allPanels.forEach(p => p.classList.toggle('active', p.id === tabId)); }
    });
});

/* ── Accordion ── */
document.querySelectorAll('.accordion-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.accordion-item');
        const accordionGroup =
            item.closest('[id$="-demo"]') || item.closest('#accordion');

        const isOpen = item.classList.contains('open');

        // Close ALL items first
        if (accordionGroup) {
            accordionGroup.querySelectorAll('.accordion-item').forEach(i => {
                i.classList.remove('open');
                const b = i.querySelector('.accordion-btn');
                b?.classList.remove('text-brand-500');
            });
        }

        // Then ONLY open if it was closed
        if (!isOpen) {
            item.classList.add('open');
            btn.classList.add('text-brand-500');
        }
    });
});

/* ── Dropdown ── */
function toggleDropdown(id) {
    const wrap = document.getElementById(id);
    if (!wrap) return;
    const menu = wrap.querySelector('.dropdown-menu');
    const isOpen = menu.classList.contains('open');
    document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
    if (!isOpen) menu.classList.add('open');
}
document.addEventListener('click', (e) => {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
    }
});

/* ── Popover ── */
function togglePopover(id) {
    const wrap = document.getElementById(id);
    if (!wrap) return;
    const isActive = wrap.classList.contains('active');
    document.querySelectorAll('.popover-wrap.active').forEach(p => p.classList.remove('active'));
    if (!isActive) wrap.classList.add('active');
}
document.addEventListener('click', (e) => {
    if (!e.target.closest('.popover-wrap')) {
        document.querySelectorAll('.popover-wrap.active').forEach(p => p.classList.remove('active'));
    }
});

/* ── Carousel ── */
let carouselIndex = 0;
const carouselTrack = document.getElementById('carousel-track');
const carouselDots = document.querySelectorAll('#carousel-dots .carousel-dot');
const totalSlides = carouselDots.length;
let carouselAutoplay;

function updateCarousel() {
    carouselTrack.style.transform = `translateX(-${carouselIndex * 100}%)`;
    carouselDots.forEach((d, i) => d.classList.toggle('active', i === carouselIndex));
}

function carouselNext() { carouselIndex = (carouselIndex + 1) % totalSlides;
    updateCarousel();
    resetAutoplay(); }

function carouselPrev() { carouselIndex = (carouselIndex - 1 + totalSlides) % totalSlides;
    updateCarousel();
    resetAutoplay(); }
carouselDots.forEach(dot => {
    dot.addEventListener('click', () => { carouselIndex = parseInt(dot.dataset.index);
        updateCarousel();
        resetAutoplay(); });
});

function resetAutoplay() { clearInterval(carouselAutoplay);
    carouselAutoplay = setInterval(carouselNext, 4500); }
carouselAutoplay = setInterval(carouselNext, 4500);

/* ── Pagination ── */
document.querySelectorAll('#pagination-demo .page-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (this.disabled) return;
        document.querySelectorAll('#pagination-demo .page-btn.active').forEach(b => b
            .classList.remove('active'));
        this.classList.add('active');
    });
});

/* ── Offcanvas ── */
function openOffcanvas() {
    document.getElementById('offcanvas-overlay').classList.add('open');
    document.getElementById('offcanvas-panel').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeOffcanvas() {
    document.getElementById('offcanvas-overlay').classList.remove('open');
    document.getElementById('offcanvas-panel').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeOffcanvas(); });

/* ── Sidebar ── */
function toggleSidebar() {
    const panel = document.getElementById('sidebar-panel');
    const icon = document.getElementById('sidebar-icon');
    panel.classList.toggle('collapsed');
    const isCollapsed = panel.classList.contains('collapsed');
    icon.innerHTML = isCollapsed ?
        '<path d="M13 5l7 7-7 7M5 5l7 7-7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>' :
        '<path d="M11 19l-7-7 7-7m8 14l-7-7 7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>';
}

/* ── Copy Code ── */
function copyCode(codeId) {
    const wrap = document.querySelector(`.code-wrap[data-code-id="${codeId}"]`);
    if (!wrap) return;
    const pre = wrap.querySelector('pre');
    const codeText = pre ? pre.textContent.trim() : '';
    const btn = wrap.querySelector('.copy-btn');
    navigator.clipboard.writeText(codeText).then(() => {
        const originalHTML = btn.innerHTML;
        btn.innerHTML =
            '<svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="#34c759" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Copied!';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('copied');
        }, 1800);
    }).catch(() => {
        btn.textContent = 'Failed';
        setTimeout(() => { btn.innerHTML = originalHTML; }, 1500);
    });
}

/* ── Scrollspy ── */
const scrollspyLinks = document.querySelectorAll('.scrollspy-link');
const tocDots = document.querySelectorAll('.toc-dot');
const allSections = [];
scrollspyLinks.forEach(link => {
    const sectionId = link.dataset.section;
    const section = document.getElementById(sectionId);
    if (section) allSections.push({ id: sectionId, el: section });
});
const scrollspyObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const activeId = entry.target.id;
            scrollspyLinks.forEach(l => l.classList.toggle('active', l.dataset.section ===
                activeId));
            tocDots.forEach(d => d.classList.toggle('active', d.dataset.section === activeId));
        }
    });
}, { threshold: 0.3, rootMargin: '-80px 0px -40% 0px' });
allSections.forEach(s => scrollspyObserver.observe(s.el));

/* ── Smooth scroll for anchor links ── */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href === '#') return;
        const target = document.querySelector(href);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

/* ── Trigger initial hero animations ── */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#hero .fade-up, #hero .scale-in').forEach(el => {
        setTimeout(() => el.classList.add('visible'), 100);
    });
});

/* ── [1] Scroll Reveal for .sr-up elements ────────────────────────────────── */
(function tapScrollReveal() {
    const srEls = document.querySelectorAll('.sr-up');
    if (!srEls.length) return;
    const srObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('sr-visible');
                srObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    srEls.forEach(el => srObserver.observe(el));
})();

/* ── [2] Drag-to-Scroll Horizontal ──────────────────────────────────────── */
(function tapDragScroll() {
    const wrap = document.getElementById('tap-hscroll');
    if (!wrap) return;
    let isDown = false, startX, scrollLeft;
    wrap.addEventListener('mousedown', e => {
        isDown = true;
        wrap.classList.add('is-grabbing');
        startX    = e.pageX - wrap.offsetLeft;
        scrollLeft = wrap.scrollLeft;
    });
    wrap.addEventListener('mouseleave', () => { isDown = false; wrap.classList.remove('is-grabbing'); });
    wrap.addEventListener('mouseup',    () => { isDown = false; wrap.classList.remove('is-grabbing'); });
    wrap.addEventListener('mousemove',  e => {
        if (!isDown) return;
        e.preventDefault();
        const x  = e.pageX - wrap.offsetLeft;
        const dx = (x - startX) * 1.4;
        wrap.scrollLeft = scrollLeft - dx;
    });
    /* Prevent card link clicks firing after a drag */
    wrap.addEventListener('click', e => {
        if (Math.abs(wrap.scrollLeft - scrollLeft) > 5) e.preventDefault();
    }, true);
})();

/* ── [3] 3D Tilt effect on [data-tilt] elements ─────────────────────────── */
(function tapTilt() {
    /* Skip on touch/mobile — no hover there anyway */
    if (window.matchMedia('(hover:none)').matches) return;
    const STRENGTH = 6; /* degrees — keep it subtle */
    document.querySelectorAll('[data-tilt]').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const cx = rect.left + rect.width  / 2;
            const cy = rect.top  + rect.height / 2;
            const rx = ((e.clientY - cy) / (rect.height / 2)) * -STRENGTH;
            const ry = ((e.clientX - cx) / (rect.width  / 2)) *  STRENGTH;
            card.style.transform =
                `perspective(900px) rotateX(${rx}deg) rotateY(${ry}deg) translateZ(0)`;
            card.style.boxShadow =
                `${-ry * 1.5}px ${rx * 1.5}px 40px rgba(0,0,0,.14)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform  = '';
            card.style.boxShadow  = '';
            card.style.transition = 'transform .4s cubic-bezier(.34,1.56,.64,1), box-shadow .4s ease';
            /* reset transition after spring */
            setTimeout(() => { card.style.transition = ''; }, 400);
        });
    });
})();

/* ── [4] Live counter tick for [data-live-count] ─────────────────────────── */
(function tapLiveCount() {
    const counters = document.querySelectorAll('[data-live-count]');
    if (!counters.length) return;
    const io = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el  = entry.target;
            const from = parseInt(el.dataset.from || '0');
            const to   = parseInt(el.dataset.to   || '0');
            const dur  = parseInt(el.dataset.duration || '1800');
            const start = Date.now();
            (function tick() {
                const pct  = Math.min(1, (Date.now() - start) / dur);
                const ease = 1 - Math.pow(1 - pct, 3);
                el.textContent = Math.round(from + (to - from) * ease);
                if (pct < 1) requestAnimationFrame(tick);
            })();
            io.unobserve(el);
        });
    }, { threshold: 0.5 });
    counters.forEach(el => io.observe(el));
})();

/* ── [5] Live bar animate on scroll into view ────────────────────────────── */
(function tapLiveBars() {
    const bars = document.querySelectorAll('[data-live-bar]');
    if (!bars.length) return;
    const io = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            /* bars already have their target width set inline; just trigger reflow */
            const el = entry.target;
            const targetW = el.style.width;
            el.style.width = '0%';
            requestAnimationFrame(() => {
                requestAnimationFrame(() => { el.style.width = targetW; });
            });
            io.unobserve(el);
        });
    }, { threshold: 0.4 });
    bars.forEach(el => io.observe(el));
})();

/* ── [6] Auto-refresh live feed (visual simulation — swap for real API later) */
(function tapLiveFeedSim() {
    const feed = document.getElementById('tap-live-feed');
    if (!feed) return;
    const names = [
        ['N','#e8120a','Nadia Ahmed','Seat 5-A — Main Hall'],
        ['S','#c41009','Salim Bakari','VIP Table — West Wing'],
        ['J','#a30d08','Jamila Omar','Family Section — Row 1'],
        ['M','#861208','Mohamed Lali','Seat 31-D — Main Hall'],
    ];
    let idx = 0;
    function addEntry() {
        const g = names[idx % names.length]; idx++;
        const item = document.createElement('div');
        item.className = 'tap-live-feed-item';
        item.innerHTML = `
            <div class="tap-live-avatar" style="background:${g[1]}">${g[0]}</div>
            <div class="flex-1 min-w-0">
                <div class="text-white text-xs font-semibold truncate">${g[2]}</div>
                <div class="text-white/35 text-xs truncate">${g[3]}</div>
            </div>
            <div class="tap-live-time">just now</div>
            <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0" style="background:rgba(52,199,89,.15)">
                <svg width="10" height="10" fill="none" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="#34c759" stroke-width="2.5" stroke-linecap="round"/></svg>
            </div>`;
        feed.insertBefore(item, feed.firstChild);
        /* Remove oldest if more than 5 */
        while (feed.children.length > 5) feed.removeChild(feed.lastChild);
    }
    /* Only simulate when section is visible */
    const section = document.getElementById('live-preview');
    if (!section) return;
    const sio = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            setTimeout(() => addEntry(), 4000);
            setTimeout(() => addEntry(), 9500);
            setTimeout(() => addEntry(), 15000);
        }
    }, { threshold: 0.3 });
    sio.observe(section);
})();

/* END TapEventCard enhancement JS */