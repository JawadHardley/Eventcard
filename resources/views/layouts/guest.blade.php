<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'tapeventcard')</title>
    <script>
        // Dark mode detection script (same as in your HTML)
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet">
</head>

<body class="transition-colors duration-300">
    @include('partials.navbar2')
    <main>
        {{ $slot }}
    </main>
    @include('partials.footer2')
    @include('partials.back_to_top')
    @stack('modals') {{-- for page-specific modals --}}
    <div class="toast-container" id="toast-container"></div>
</body>

</html>
