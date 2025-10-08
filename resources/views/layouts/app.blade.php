<html lang="en" data-theme="light">

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Heroicons outline -->
    <script src="https://unpkg.com/@heroicons/react/outline"></script>

    <!-- Heroicons solid -->
    <script src="https://unpkg.com/@heroicons/react/solid"></script>
    @vite(['resources/css/user.css', 'resources/js/app.js'])
</head>

<body class=""><noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root">
        <div class="drawer  lg:drawer-open"><input id="left-sidebar-drawer" type="checkbox" class="drawer-toggle">
            <div class="drawer-content flex flex-col ">
                <div class="navbar sticky top-0 bg-base-100  z-10 shadow-md ">
                    <div class="flex-1">
                        <label for="left-sidebar-drawer" class="btn btn-primary drawer-button lg:hidden">
                            <i data-lucide="menu" class="h-5 w-5"></i>
                        </label>

                        <h1 class="text-2xl font-semibold">Dashboard</h1>
                        <div class="breadcrumbs text-sm">
                            <ul>
                                <li><a>Home</a></li>
                                <li><a>Dashboard</a></li>
                                <li>Main Tree</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex-none">
                        <label class="swap">
                            <input type="checkbox" class="sr-only" id="theme-toggle">
                            <i data-lucide="sun" class="swap-on w-6 h-6"></i>
                            <i data-lucide="moon" class="swap-off w-6 h-6"></i>
                        </label>
                        <div class="dropdown dropdown-end ml-4">
                            <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                                <i data-lucide="circle-user" class=""></i>
                            </label>
                            <span class="small">
                                @auth
                                    {{ Auth::user()->name }}
                                @endauth
                            </span>
                            <ul tabindex="0"
                                class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                                <li class="justify-between">
                                    <a href="{{ route('profile.edit') }}">
                                        Profile Settings <span class="badge">New</span>
                                    </a>
                                </li>
                                <li><a href="/app/settings-billing">Bill History</a></li>
                                <div class="divider mt-0 mb-0"></div>
                                <li>
                                    <button onclick="my_modal_1.showModal()">Logout</button>
                                </li>

                                <!-- Open the modal using ID.showModal() method -->
                                {{-- <button class="btn" onclick="my_modal_1.showModal()">open modal</button> --}}

                            </ul>
                        </div>
                    </div>
                </div>
                <main class="flex-1 overflow-y-auto md:pt-4 pt-4 px-6  bg-base-200">
                    <div class="grid grid-cols-1">
                        <div class="acme">

                            @yield('content')

                        </div>
                        <div class="h-16"></div>
                </main>
            </div>
            <div class="drawer-side  z-30  "><label for="left-sidebar-drawer" class="drawer-overlay"></label>
                <ul class="menu  pt-2 w-80 bg-base-100 min-h-full   text-base-content">
                    <button
                        class="btn btn-ghost bg-base-300 btn-circle z-50 top-0 right-0 mt-4 mr-2 absolute lg:hidden">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                    <li class="mb-2 font-semibold text-xl">
                        <a href="/">
                            <i data-lucide="layers-2" class="mask mask-squircle w-10"></i> EventCard
                        </a>
                    </li>
                    <li class="">
                        <div tabindex="0" class="collapse">
                            <a href="{{ route('user.dashboard') }}" class="rin">
                                <div class="collapse-title flex items-center py-1 gap-2">
                                    <i data-lucide="layout-dashboard" class="h-6 w-6 inline"></i> Dashboard
                                    <span class="absolute inset-y-0 left-0 w-1 rounded-tr-md rounded-br-md bg-primary"
                                        aria-hidden="true"></span>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="">
                        <div tabindex="0" class="collapse">
                            <a href="{{ route('user.cameralog') }}" class="rin">
                                <div class="collapse-title flex items-center py-1 gap-2">
                                    <i data-lucide="camera" class="h-6 w-6 inline"></i> camera
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="">
                        <div tabindex="0" class="collapse">
                            <a href="{{ route('user.guestlist') }}" class="rin">
                                <div class="collapse-title flex items-center py-1 gap-2">
                                    <i data-lucide="users" class="h-6 w-6 inline"></i> Guest List
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="">
                        <div tabindex="0" class="collapse collapse-arrow">
                            {{-- <input type="checkbox" class="peer" /> --}}
                            <div class="collapse-title flex items-center py-1 gap-2">
                                <i data-lucide="file-text" class="h-6 w-6 inline"></i> Pages
                            </div>
                            <div class="collapse-content">
                                <ul>
                                    <li><a href="/app/page1">Page 1</a></li>
                                    <li><a href="/app/page2">Page 2</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div
            class=" fixed overflow-hidden z-20 bg-gray-900 bg-opacity-25 inset-0 transform ease-in-out  transition-all delay-500 opacity-0 translate-x-full  ">
            <section
                class="w-80 md:w-96  right-0 absolute bg-base-100 h-full shadow-xl delay-400 duration-500 ease-in-out transition-all transform   translate-x-full ">
                <div class="relative  pb-5 flex flex-col  h-full">
                    <div class="navbar   flex pl-4 pr-4   shadow-md ">
                        <!-- For modal and sidebar close buttons -->
                        <button class="float-left btn btn-circle btn-outline btn-sm">
                            <i data-lucide="x" class="h-5 w-5"></i>
                        </button><span class="ml-2 font-bold text-xl"></span>
                    </div>
                    <div class="overflow-y-scroll pl-4 pr-4">
                        <div class="flex flex-col w-full"></div>
                    </div>
                </div>
            </section>
            <section class=" w-screen h-full cursor-pointer "></section>
        </div>
        <div class="notification-container notification-container-empty">
            <div></div>
        </div>
        <div class="modal ">
            <div class="modal-box  "><button class="btn btn-sm btn-circle absolute right-2 top-2">✕</button>
                <h3 class="font-semibold text-2xl pb-6 text-center"></h3>
                <div></div>
            </div>
        </div>
    </div>

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


        document.querySelectorAll('li > .flex.flex-col > .w-full').forEach(header => {
            header.addEventListener('click', () => {
                const parent = header.parentElement;
                const submenu = parent.querySelector('.submenu'); // your collapse content
                const chevron = header.querySelector('i.w-5');

                if (submenu) {
                    submenu.classList.toggle('hidden');
                }
                if (chevron) {
                    chevron.classList.toggle('rotate-180');
                }
            });
        });
    </script>

    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="text-lg text-center font-bold">Alert!</h3>
            <p class="py-4">Are you sure you want to logout ?!</p>
            <div class="modal-action">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-soft btn-secondary">Yes, Logout</button>
                    <button class="btn btn-outline btn-primary">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</body>

</html>
