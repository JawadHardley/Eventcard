import './bootstrap';
import Chart from 'chart.js/auto';

// ─── Dark mode (keep your existing logic or use AuraUI's) ───
(function() {
    let theme = localStorage.getItem('aura-theme');
    if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();

window.toggleTheme = function() {
    const html = document.documentElement;
    html.classList.toggle('dark');
    localStorage.setItem('aura-theme', html.classList.contains('dark') ? 'dark' : 'light');
    // Re-init charts if they exist on the page
    if (window.initDashboardCharts) window.initDashboardCharts();
};

// ─── Sidebar collapse ───
window.toggleSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main-content');
    const footer = document.getElementById('admin-footer');
    const icon = document.getElementById('collapse-icon');
    if (!sidebar) return;
    const isCollapsed = sidebar.classList.toggle('collapsed');
    if (main) main.style.marginLeft = isCollapsed ? '64px' : '248px';
    if (footer) footer.style.marginLeft = isCollapsed ? '64px' : '248px';
    if (icon) {
        icon.innerHTML = isCollapsed
            ? '<path d="M13 5l7 7-7 7M5 5l7 7-7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>'
            : '<path d="M11 19l-7-7 7-7m8 14l-7-7 7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>';
    }
};

// ─── Mobile sidebar ───
window.toggleMobileSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (!sidebar) return;
    sidebar.classList.toggle('mobile-open');
    if (overlay) overlay.classList.toggle('show');
    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
};
window.closeMobileSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (sidebar) sidebar.classList.remove('mobile-open');
    if (overlay) overlay.classList.remove('show');
    document.body.style.overflow = '';
};

// ─── Dropdowns ───
window.toggleDropdown = function(wrapperId) {
    const wrap = document.getElementById(wrapperId);
    if (!wrap) return;
    const menu = wrap.querySelector('.dropdown-menu');
    const isOpen = menu.classList.contains('open');
    document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
    if (!isOpen) menu.classList.add('open');
};
document.addEventListener('click', (e) => {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
    }
});

// ─── Modals ───
window.openModal = function(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.add('open');
    document.body.style.overflow = 'hidden';
};
window.closeModal = function(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.remove('open');
    document.body.style.overflow = '';
};
window.handleModalClick = function(e, id) {
    if (e.target === document.getElementById(id)) closeModal(id);
};
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.open').forEach(m => closeModal(m.id));
    }
});

// ─── Toast notifications ───
window.showToast = function(message, type = 'info') {
    const icons = {
        success: '<svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#34c759" stroke-width="2" stroke-linecap="round"/></svg>',
        error: '<svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#ff3b30" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke="#ff3b30" stroke-width="2" stroke-linecap="round"/></svg>',
        info: '<svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#0e84e8" stroke-width="2" stroke-linecap="round"/></svg>',
        warning: '<svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="#ff9500" stroke-width="2" stroke-linecap="round"/></svg>'
    };
    const container = document.getElementById('toast-container');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `${icons[type] || icons.info}<span class="toast-msg">${message}</span><button onclick="this.closest('.toast').remove()" style="background:none;border:none;color:#aeaeb2;cursor:pointer;font-size:1rem;padding:0 .2rem;">&#x2715;</button>`;
    container.appendChild(toast);
    requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.add('show')));
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 4000);
};

// ─── Charts (to be called from dashboard page) ───
let chartRegistry = {};
window.initDashboardCharts = function() {
    const colors = document.documentElement.classList.contains('dark')
        ? { grid: 'rgba(255,255,255,0.05)', tick: '#636366' }
        : { grid: 'rgba(0,0,0,0.04)', tick: '#aeaeb2' };
    // Example: uploads line chart
    const uploadCtx = document.getElementById('uploadsChart');
    if (uploadCtx && !chartRegistry.uploadsChart) {
        chartRegistry.uploadsChart = new Chart(uploadCtx, {
            type: 'line',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    label: 'Uploads',
                    data: [42, 68, 54, 93, 81, 56, 74],
                    borderColor: '#0e84e8',
                    backgroundColor: 'rgba(14,132,232,0.08)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { x: { grid: { color: colors.grid } }, y: { grid: { color: colors.grid } } } }
        });
    }
    // Storage doughnut
    const storageCtx = document.getElementById('storageChart');
    if (storageCtx && !chartRegistry.storageChart) {
        chartRegistry.storageChart = new Chart(storageCtx, {
            type: 'doughnut',
            data: { labels: ['Documents','Images','Videos','Other'], datasets: [{ data: [42,28,18,12], backgroundColor: ['#0e84e8','#34c759','#ff9500','#5e5ce6'], borderWidth: 0 }] },
            options: { responsive: true, cutout: '70%', plugins: { legend: { display: false } } }
        });
    }
};