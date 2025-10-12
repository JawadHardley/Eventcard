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
    <meta property="og:image" content="https://img.daisyui.com/images/components/countdown.webp" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="alternate" hreflang="en" href="https://daisyui.com/components/countdown/?lang=en" />
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Heroicons outline -->
    <script src="https://unpkg.com/@heroicons/react/outline"></script>

    <!-- Heroicons solid -->
    <script src="https://unpkg.com/@heroicons/react/solid"></script>
    @vite(['resources/css/user.css', 'resources/js/app.js'])

</head>

<body class="">
    <div class="grid grid-cols-12">
        <div class="col-span-12 p-5 flex justify-center">
            <label class="swap border-2 border-blue-800/10 rounded-full p-3">
                <input type="checkbox" class="sr-only" id="theme-toggle">
                <i data-lucide="sun" class="swap-on w-6 h-6"></i>
                <i data-lucide="moon" class="swap-off w-6 h-6"></i>
            </label>
        </div>
    </div>
    @yield('content')


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
</body>

</html>
