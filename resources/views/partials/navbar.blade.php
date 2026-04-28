<header id="navbar" class="fixed top-0 left-0 right-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-14">

            <!-- Logo -->
            <a href="/"
                class="flex items-center gap-2.5 font-display text-lg font-bold text-gray-900 dark:text-white">
                <div class="w-7 h-7 rounded-xl bg-brand-500 flex items-center justify-center shadow-sm">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <circle cx="7" cy="7" r="5.5" stroke="white" stroke-width="2" />
                        <circle cx="7" cy="7" r="2.2" fill="white" />
                    </svg>
                </div>
                Delvatz
            </a>

            <!-- Center Nav -->
            <nav class="hidden md:flex items-center gap-1">
                @foreach ([['name' => 'Home', 'route' => 'home'], ['name' => 'About', 'route' => 'about'], ['name' => 'Pricing', 'route' => 'pricing'], ['name' => 'FAQ', 'route' => 'faq'], ['name' => 'Contact', 'route' => 'contact']] as $link)
                    <a href="#"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded-lg hover:bg-black/5 dark:hover:bg-white/10 transition-all">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Right Side -->
            <div class="flex items-center gap-3">

                <!-- Theme Toggle -->
                <button id="theme-toggle"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2">
                    🌙
                </button>

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

                            <a href="#" class="dropdown-item">Dashboard</a>
                            <a href="#" class="dropdown-item">Settings</a>

                            <div class="dropdown-sep"></div>

                            <form method="POST" action="#">
                                @csrf
                                <button class="dropdown-item danger w-full text-left">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth

                <!-- Mobile -->
                <button id="ham-btn" onclick="toggleMobileMenu()"
                    class="ham-btn flex flex-col justify-center w-9 h-9 md:hidden">
                    <span class="ham-line"></span>
                    <span class="ham-line"></span>
                    <span class="ham-line"></span>
                </button>

            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden bg-white dark:bg-[#1c1c1e] rounded-b-2xl shadow-xl">

            <div class="py-3 px-2 space-y-1 border-t border-gray-100 dark:border-gray-800">

                @foreach (['Home', 'About', 'Pricing', 'FAQ', 'Contact'] as $item)
                    <a href="#"
                        class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl">
                        {{ $item }}
                    </a>
                @endforeach

                @guest
                    <div class="pt-2 space-y-2">
                        <a href="{{ route('login') }}" class="btn btn-ghost w-full">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary w-full">Register</a>
                    </div>
                @endguest

                @auth
                    <div class="pt-2">
                        <form method="POST" action="#">
                            @csrf
                            <button class="btn btn-danger w-full">Logout</button>
                        </form>
                    </div>
                @endauth

            </div>
        </div>

    </div>
</header>
