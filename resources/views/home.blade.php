<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#000000">
    <meta name="description" content="A free admin dashboard template using Daisy UI and React js.">
    <link rel="apple-touch-icon" href="/logo192.png">
    <link rel="manifest" href="/manifest.json">
    <title>Event Card</title>
    <meta name="description"
        content="Get a customizable and easily-themed admin dashboard template using Daisy UI and React js. Boost your productivity with pre-configured redux toolkit and other libraries.">
    <!-- Lucide Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/user.css', 'resources/js/app.js'])
</head>

<body>

    <div class="navbar bg-base-100 shadow-sm">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li><a>Home</a></li>
                    {{-- <li>
                        <a>Parent</a>
                        <ul class="p-2">
                            <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </li>
                    <li><a>Item 3</a></li> --}}

                    <li>
                        @auth
                            <div>
                                <!-- If user is logged in -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <summary>{{ Auth::user()->name }}</summary>
                                    <ul class="p-2">
                                        <li>
                                            <button class="" type="submit">logout</button>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        @endauth
                        @guest
                            <!-- If user is NOT logged in -->
                            <a href="{{ route('login') }}" class="mr-2">Login</a>
                            <a href="{{ route('register') }}" class="text-decoration-none">Register</a>
                        @endguest
                    </li>
                </ul>
            </div>
            <a class="btn btn-ghost text-xl"><i class="fa fa-object-ungroup text-primary mr-3"></i> EventCard</a>
        </div>
        {{-- <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a>Item 1</a></li>
                <li>
                    <details>
                        <summary>Parent</summary>
                        <ul class="p-2">
                            <li><a>X 1</a></li>
                            <li><a>X 2</a></li>
                        </ul>
                    </details>
                </li>
                <li><a>Item 3</a></li>
            </ul>
        </div> --}}
        <label class="swap">
            <input type="checkbox" class="sr-only" id="theme-toggle">
            <i data-lucide="sun" class="swap-on w-6 h-6"></i>
            <i data-lucide="moon" class="swap-off w-6 h-6"></i>
        </label>
        <div class="navbar-end">
            @auth
                <!-- If user is logged in -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <div class="navbar-center hidden lg:flex">
                        <ul class="menu menu-horizontal px-1">
                            <li>
                                <details>
                                    <summary>{{ Auth::user()->name }}</summary>
                                    <ul class="p-2">
                                        <li>
                                            <button class="" type="submit">logout</button>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </div>
                </form>
            @endauth

            @guest
                <!-- If user is NOT logged in -->
                <a href="{{ route('login') }}" class="btn btn-outline btn-primary mr-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline btn-secondary">Register</a>
            @endguest
        </div>
    </div>


    <div class="hero min-h-screen"
        style="background-image: url(https://c0.wallpaperflare.com/preview/648/294/332/ceremonial-chairs-curtain-flowers.jpg);">
        <div class="hero-overlay bg-black/80"></div>
        <div class="hero-content text-neutral-content text-center">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold">Digital Event Cards</h1>
                <p class="mb-5">
                    We are about to make your event memorable with our digital event cards. Create and share
                    beautiful event cards with your loved ones.
                </p>
                <button class="btn btn-primary">Get Started</button>
            </div>
        </div>
    </div>

    <footer class="footer sm:footer-horizontal p-10">
        <nav>
            <h6 class="footer-title">Services</h6>
            <a class="link link-hover">Branding</a>
            <a class="link link-hover">Design</a>
            <a class="link link-hover">Marketing</a>
            <a class="link link-hover">Advertisement</a>
        </nav>
        <nav>
            <h6 class="footer-title">Company</h6>
            <a class="link link-hover">About us</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Jobs</a>
            <a class="link link-hover">Press kit</a>
        </nav>
        <nav>
            <h6 class="footer-title">Legal</h6>
            <a class="link link-hover">Terms of use</a>
            <a class="link link-hover">Privacy policy</a>
            <a class="link link-hover">Cookie policy</a>
        </nav>
    </footer>

    <script>
        lucide.createIcons();
        // Theme toggle logic
        document.getElementById('theme-toggle').addEventListener('change', function(e) {
            document.documentElement.setAttribute('data-theme', e.target.checked ? 'dark' : 'light');
        });

        // On page load, restore theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
            const themeCheckbox = document.getElementById('theme-toggle');
            if (themeCheckbox) themeCheckbox.checked = savedTheme === 'dark';
        }

        // Listen for toggle
        document.getElementById('theme-toggle').addEventListener('change', function(e) {
            const theme = e.target.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    </script>

</body>

</html>
