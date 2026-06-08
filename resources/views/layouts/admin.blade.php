<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aura Admin')</title>
    <!-- Dark mode script (prevents flash) -->
    <script>
        (function() {
            var t = localStorage.getItem('aura-theme');
            if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>

    <!-- Mobile sidebar overlay -->
    <div id="sidebar-overlay" onclick="closeMobileSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-mar">
                <a href="#hero"
                    class="flex items-center gap-2.5 text-lg font-bold text-gray-900 dark:text-white scrollspy-link"
                    data-section="hero">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm bg-gray-900 dark:bg-red-900/30">
                        <img src="{{ asset('storage/logos/logo1.png') }}" alt="Tapeventcard Logo">
                    </div>
                </a>
            </div>
            <span class="logo-text">Tapevent</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                href="{{ route('user.dashboard') }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="8" height="8" rx="2" stroke="currentColor"
                        stroke-width="1.8" />
                    <rect x="13" y="3" width="8" height="8" rx="2" stroke="currentColor"
                        stroke-width="1.8" />
                    <rect x="3" y="13" width="8" height="8" rx="2" stroke="currentColor"
                        stroke-width="1.8" />
                    <rect x="13" y="13" width="8" height="8" rx="2" stroke="currentColor"
                        stroke-width="1.8" />
                </svg>
                <span class="nav-label">Dashboard</span>
                <span class="nav-tooltip">Dashboard</span>
            </a>

            <div class="nav-section-label">Events</div>
            <a class="nav-item {{ request()->routeIs('user.eventlist*') ? 'active' : '' }}"
                href="{{ route('user.eventlist') }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"
                        stroke="currentColor" stroke-width="1.8" />
                </svg>
                <span class="nav-label">Events</span>
                <span class="nav-tooltip">Events</span>
            </a>
            <a class="nav-item {{ request()->routeIs('user.addevent') ? 'active' : '' }}"
                href="{{ route('user.addevent') }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                </svg>
                <span class="nav-label">Add Event</span>
                <span class="nav-tooltip">Add Event</span>
            </a>

            <div class="nav-section-label">Guests</div>
            <a class="nav-item {{ request()->routeIs('user.guestlist') ? 'active' : '' }}"
                href="{{ route('user.guestlist') }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" />
                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.8" />
                    <path d="M23 21v-2a4 4 0 00-3-3.87" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" />
                    <path d="M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                </svg>
                <span class="nav-label">Guest List</span>
                <span class="nav-tooltip">Guest List</span>
            </a>

            <div class="nav-section-label">Management</div>
            <a class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}"
                href="{{ route('admin.users') }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" />
                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.8" />
                </svg>
                <span class="nav-label">Users</span>
                <span class="nav-tooltip">Users</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.transactions') ? 'active' : '' }}"
                href="{{ route('admin.transactions') }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor"
                        stroke-width="1.8" />
                    <path d="M2 10h20" stroke="currentColor" stroke-width="1.8" />
                </svg>
                <span class="nav-label">Billing</span>
                <span class="nav-tooltip">Billing</span>
            </a>
            <a class="nav-item" href="#" onclick="return false;">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <path
                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2m-6 0V9m6 8V9m0 8a2 2 0 002 2h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2 2"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                </svg>
                <span class="nav-label">Reports</span>
                <span class="nav-tooltip">Reports</span>
            </a>

            <div class="nav-divider"></div>
            <a class="nav-item" href="{{ route('profile.edit') }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
                    <path
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                        stroke="currentColor" stroke-width="1.8" />
                </svg>
                <span class="nav-label">Settings</span>
                <span class="nav-tooltip">Settings</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user" onclick="window.location='{{ route('profile.edit') }}'">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div class="sidebar-user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
            <button class="collapse-btn" onclick="toggleSidebar()">
                <svg id="collapse-icon" width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <path d="M11 19l-7-7 7-7m8 14l-7-7 7-7" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" />
                </svg>
                <span class="collapse-btn-text">Collapse</span>
            </button>
        </div>
    </aside>

    <!-- Topbar -->
    <header id="topbar">
        <button class="topbar-btn md:hidden" id="ham-btn" onclick="toggleMobileSidebar()" aria-label="Menu">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>

        <div class="topbar-search">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
                <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <input type="search" placeholder="Search...">
        </div>

        <div class="topbar-actions" style="margin-left:auto;display:flex;align-items:center;gap:.35rem;">
            <button class="topbar-btn" onclick="toggleTheme()" title="Dark mode">
                <svg id="theme-icon-sun" width="17" height="17" fill="none" viewBox="0 0 24 24"
                    style="display:none;">
                    <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2" />
                    <path
                        d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <svg id="theme-icon-moon" width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                </svg>
            </button>

            <div class="dropdown" id="notif-dropdown">
                <button class="topbar-btn" onclick="toggleDropdown('notif-dropdown')">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                        <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                    <span class="notif-dot"></span>
                </button>
                <div class="dropdown-menu notif-dropdown" style="min-width:320px;padding:0;">
                    <div style="padding:.85rem 1rem;border-bottom:1px solid #f0f0f5;"><span
                            class="font-bold">Notifications</span></div>
                    <div class="notif-item">
                        <div class="notif-icon">📄</div>
                        <div>No new notifications</div>
                    </div>
                </div>
            </div>

            <div class="dropdown" id="user-dropdown">
                <button class="avatar-btn"
                    onclick="toggleDropdown('user-dropdown')">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</button>
                <div class="dropdown-menu">
                    <div class="dropdown-item" onclick="window.location='{{ route('profile.edit') }}'">Profile</div>
                    <div class="dropdown-item" onclick="window.location='/'">Home</div>
                    <div class="dropdown-sep"></div>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <div class="dropdown-item danger" onclick="document.getElementById('logout-form').submit();">
                            Sign out</div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- <header id="topbar">
        <!-- Mobile hamburger -->
        <button class="topbar-btn md:hidden" id="ham-btn" onclick="toggleMobileSidebar()" aria-label="Toggle menu">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>
        </button>

        <!-- Search -->
        <div class="topbar-search">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" style="color:#aeaeb2;flex-shrink:0;">
            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"></circle>
            <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>
            <input type="search" placeholder="Search files, users...">
            <kbd style="font-size:.65rem;color:#aeaeb2;background:rgba(0,0,0,.06);border-radius:5px;padding:.1rem .4rem;flex-shrink:0;">⌘K</kbd>
        </div>

        <div style="margin-left:auto;display:flex;align-items:center;gap:.35rem;">

            <!-- Dark mode toggle -->
            <button class="topbar-btn" id="theme-btn" onclick="toggleTheme()" title="Toggle dark mode">
            <svg id="icon-sun" width="17" height="17" fill="none" viewBox="0 0 24 24" style="display: block;">
                <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2"></circle>
                <path d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>
            <svg id="icon-moon" width="16" height="16" fill="none" viewBox="0 0 24 24" style="display: none;">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>
            </button>

            <!-- Notifications -->
            <div class="dropdown" id="notif-dropdown-wrap">
            <button class="topbar-btn" onclick="toggleDropdown('notif-dropdown-wrap')" title="Notifications">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"></path>
                <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"></path>
                </svg>
                <span class="notif-dot"></span>
            </button>
            <div class="dropdown-menu notif-dropdown" id="notif-panel" style="min-width:320px;padding:0;overflow:hidden;">
                <div style="padding:.85rem 1rem;border-bottom:1px solid #f0f0f5;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size: 0.875rem; font-weight: 700; color: rgb(255, 255, 255);" class="dark:text-white" id="notif-title">Notifications</span>
                <span class="badge badge-blue">3 New</span>
                </div>
                <div class="notif-item notif-unread">
                <div class="notif-icon" style="background:rgba(52,199,89,.12);">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#34c759" stroke-width="2" stroke-linecap="round"></path></svg>
                </div>
                <div>
                    <div class="notif-text">File <strong>Q4_Report.pdf</strong> uploaded successfully</div>
                    <div class="notif-time">2 minutes ago</div>
                </div>
                </div>
                <div class="notif-item notif-unread">
                <div class="notif-icon" style="background:rgba(14,132,232,.12);">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#0e84e8" stroke-width="2" stroke-linecap="round"></path><circle cx="9" cy="7" r="4" stroke="#0e84e8" stroke-width="2"></circle></svg>
                </div>
                <div>
                    <div class="notif-text"><strong>Sarah Chen</strong> joined the workspace</div>
                    <div class="notif-time">1 hour ago</div>
                </div>
                </div>
                <div class="notif-item notif-unread">
                <div class="notif-icon" style="background:rgba(255,149,0,.12);">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke="#ff9500" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </div>
                <div>
                    <div class="notif-text">Storage is at <strong>78%</strong> capacity</div>
                    <div class="notif-time">3 hours ago</div>
                </div>
                </div>
                <div class="notif-item">
                <div class="notif-icon" style="background:rgba(94,92,230,.12);">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke="#5e5ce6" stroke-width="1.8"></rect><rect x="14" y="3" width="7" height="7" rx="1" stroke="#5e5ce6" stroke-width="1.8"></rect><rect x="3" y="14" width="7" height="7" rx="1" stroke="#5e5ce6" stroke-width="1.8"></rect><rect x="14" y="14" width="7" height="7" rx="1" stroke="#5e5ce6" stroke-width="1.8"></rect></svg>
                </div>
                <div>
                    <div class="notif-text">Weekly report generated</div>
                    <div class="notif-time">Yesterday</div>
                </div>
                </div>
                <div style="padding:.6rem 1rem;border-top:1px solid #f0f0f5;text-align:center;">
                <a href="#" style="font-size:.8rem;color:#0e84e8;font-weight:600;text-decoration:none;">View all notifications</a>
                </div>
            </div>
            </div>

            <!-- User menu -->
            <div class="dropdown" id="user-dropdown-wrap">
            <button class="avatar-btn" onclick="toggleDropdown('user-dropdown-wrap')" title="User menu">AJ</button>
            <div class="dropdown-menu" id="user-panel">
                <div style="padding:.6rem .75rem .5rem;border-bottom:1px solid #f0f0f5;">
                <div style="font-size:.82rem;font-weight:700;color:#1d1d1f;">Alex Johnson</div>
                <div style="font-size:.72rem;color:#aeaeb2;">alex@company.com</div>
                </div>
                <div class="dropdown-item" onclick="showPage('page-profile', null);toggleDropdown('user-dropdown-wrap')">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.8"></circle><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"></path></svg>
                Profile
                </div>
                <div class="dropdown-item" onclick="showPage('page-settings', null);toggleDropdown('user-dropdown-wrap')">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"></circle><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke="currentColor" stroke-width="1.8"></path></svg>
                Settings
                </div>
                <div class="dropdown-sep"></div>
                <div class="dropdown-item danger">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4m7 14l5-5-5-5m5 5H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                Sign out
                </div>
            </div>
            </div>

        </div>
    </header> --}}

    <!-- Main content -->
    <div id="main-content">
        <div class="page-inner">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer id="admin-footer">
        <div class="border-t py-3 px-6 flex justify-between text-xs text-gray-400">
            <span>EventCard Admin v2.0</span>
            <span>© {{ date('Y') }} TapEventCard</span>
        </div>
    </footer>

    <!-- Toast container -->
    <div id="toast-container"></div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const fadeElements = document.querySelectorAll('.fade-up');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            fadeElements.forEach(el => observer.observe(el));
        });
    </script>

    <script>
        // Initialize dark mode icons
        (function() {
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById('theme-icon-sun').style.display = isDark ? 'block' : 'none';
            document.getElementById('theme-icon-moon').style.display = isDark ? 'none' : 'block';
        })();

        // Close mobile sidebar on window resize if open
        window.addEventListener('resize', function() {
            if (window.innerWidth > 767) closeMobileSidebar();
        });

        // Show flash messages as toasts
        @if (session('status'))
            showToast("{{ session('status') }}", "success");
        @elseif (session('error'))
            showToast("{{ session('error') }}", "error");
        @endif
    </script>
</body>

</html>
