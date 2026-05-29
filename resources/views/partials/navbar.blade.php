<header id="navbar" class="fixed top-0 left-0 right-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-14">
            <a href="#hero"
                class="flex items-center gap-2.5 text-lg font-bold text-gray-900 dark:text-white scrollspy-link"
                data-section="hero">
                <div
                    class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm bg-gray-900 dark:bg-red-900/30">
                    <img src="{{ asset('storage/logos/logo1.png') }}" alt="Tapeventcard Logo">
                </div>
            </a>
            <nav class="hidden md:flex items-center gap-0.5" id="navbar-links">
                <a href="{{ route('landing') }}"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-all scrollspy-link"
                    data-section="s-buttons">
                    Home
                </a>
                <a href="/about"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-all scrollspy-link"
                    data-section="s-buttons">
                    About
                </a>
                <a href="/pricing"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-all scrollspy-link"
                    data-section="s-buttons">
                    Pricing
                </a>
                <a href="/contact"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-all scrollspy-link"
                    data-section="s-buttons">
                    Contact
                </a>
                <a href="#"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-all scrollspy-link"
                    data-section="s-buttons">
                    FAQ
                </a>
            </nav>
            <div class="flex items-center gap-3">
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg text-sm p-2 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                {{-- <a href="#s-buttons" class="hidden md:inline-flex btn btn-primary btn-sm">Get Started</a> --}}
                @guest
                    <!-- Logged OUT -->
                    <a href="{{ route('login') }}"
                        class="hidden md:inline-flex text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="hidden md:inline-flex btn btn-primary btn-sm">
                        Register
                    </a>
                @endguest

                @auth
                    <!-- Logged IN -->
                    <div class="relative dropdown-wrap">
                        <button onclick="toggleDropdown()"
                            class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10">
                            <div class="avatar w-8 h-8">
                                <span class="text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        </button>

                        <!-- Dropdown -->
                        <div id="profileDropdown" class="dropdown-menu right-0 left-auto mt-2">
                            <div class="px-3 py-2 text-sm text-gray-500">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="dropdown-sep"></div>

                            <a href="{{ route('user.dashboard') }}" class="dropdown-item">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Settings</a>

                            <div class="dropdown-sep"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item danger w-full text-left">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <button id="ham-btn" class="ham-btn flex flex-col justify-center w-9 h-9 md:hidden"
                    aria-label="Toggle menu">
                    <span class="ham-line"></span><span class="ham-line"></span><span class="ham-line"></span>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden bg-white dark:bg-[#1c1c1e] rounded-b-2xl shadow-xl dark:shadow-2xl">
            <div class="py-3 px-2 space-y-0.5 border-t border-gray-100 dark:border-gray-800">
                <a href="#s-buttons"
                    class="block px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors mobile-nav-link">Buttons</a>
                <a href="#s-cards"
                    class="block px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors mobile-nav-link">Cards</a>
                <a href="#s-forms"
                    class="block px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors mobile-nav-link">Forms</a>
                <a href="#s-modals"
                    class="block px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors mobile-nav-link">Modals</a>
                <a href="#s-tables"
                    class="block px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors mobile-nav-link">Tables</a>
                <div class="pt-2 px-3 pb-1">
                    <a href="#s-buttons" class="btn btn-primary btn-md w-full mobile-nav-link">Explore Components</a>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    function toggleMobileMenu() {
        document.getElementById('mobile-menu').classList.toggle('open');
    }

    function toggleDropdown() {
        document.getElementById('profileDropdown').classList.toggle('open');
    }

    // close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        if (!e.target.closest('.dropdown-wrap')) {
            dropdown?.classList.remove('open');
        }
    });
</script>
