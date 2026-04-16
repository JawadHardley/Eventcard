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

    <div class="navbar bg-base-100 shadow-sm fixed top-0 z-50">
        <div class="flex-1">
            <a class="text-xl bg-white">
                <img class="w-[60px] h-[60px] object-cover" src="{{ asset('storage/images/logo.svg') }}"
                    alt="logo" />
            </a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li><a>Home</a></li>
                <li><a>About</a></li>
                <li><a>Contact</a></li>
                <li><a>Pricing</a></li>
                <li class="ml-5">
                    <label class="swap">
                        <input type="checkbox" class="sr-only" id="theme-toggle">
                        <i data-lucide="sun" class="swap-on w-6 h-6"></i>
                        <i data-lucide="moon" class="swap-off w-6 h-6"></i>
                    </label>
                </li>
                <li>
                    @auth
                    <li class="m-auto">
                        <i class="fa fa-user text-warning"></i>
                    </li>

                    <details>
                        <!-- If user is logged in -->
                        <summary>{{ Auth::user()->name }}</summary>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <ul class="bg-base-100 rounded-t-none p-2">
                                <li><button class="" type="submit">logout</button></li>
                                <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            </ul>
                        </form>
                    </details>
                @endauth
                </li>
                @guest
                    <!-- If user is NOT logged in -->
                    <li>
                        <a href="{{ route('login') }}" class="mr-2 btn btn-primary">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="text-decoration-none btn btn-warning">Register</a>
                    </li>


                @endguest
            </ul>
        </div>
    </div>

    <div class="carousel w-full min-h-screen">
        <div class="hero-overlay bg-black/70"></div>
        <div id="slide1" class="carousel-item relative w-full"
            style="background-image: url('{{ asset('storage/images/background.png') }}');">
            <img src="{{ asset('storage/images/background.png') }}" class="w-full" />
            <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">

                <a href="#slide4" class="btn btn-circle">❮</a>
                <div class="w-full">
                    <div class="text-center p-20 rounded-2xl">
                        <h1 class="mb-5 text-5xl font-bold">
                            <bgcolor="black">We Tap. We Connect. We Celebrate.

                        </h1>
                        <button class="btn btn-dark border border-black bg-black text-white">Get Started</button>
                        <button class="btn btn-secondary">Get Started</button>
                    </div>
                </div>
                <a href="#slide2" class="btn btn-circle">❯</a>
            </div>
        </div>
        <div id="slide2" class="carousel-item relative w-full">
            <img src="{{ asset('storage/images/background.png') }}" class="w-full" />
            <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                <a href="#slide1" class="btn btn-circle">❮</a>
                <div class="w-full">
                    <div class="text-center p-20">
                        <h1 class="mb-5 text-5xl font-medium">
                            Enjoy Your Wonderful Holidays With A Great Luxury Experience! Most Relaxing Place

                        </h1>
                        <button class="btn btn-dark border border-black bg-black text-white">Get Started</button>
                        <button class="btn btn-secondary">Get Started</button>
                    </div>
                </div>
                <a href="#slide3" class="btn btn-circle">❯</a>
            </div>
        </div>
        <div id="slide3" class="carousel-item relative w-full">
            <img src="{{ asset('storage/images/background.png') }}" class="w-full" />
            <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                <a href="#slide2" class="btn btn-circle">❮</a>
                <div class="w-full">
                    <div class="text-center p-20">
                        <h1 class="mb-5 text-5xl font-medium">
                            Enjoy Your Wonderful Holidays With A Great Luxury Experience! Most Relaxing Place

                        </h1>
                        <button class="btn btn-dark border border-black bg-black text-white">Get Started</button>
                        <button class="btn btn-secondary">Get Started</button>
                    </div>
                </div>
                <a href="#slide4" class="btn btn-circle">❯</a>
            </div>
        </div>
        <div id="slide4" class="carousel-item relative w-full">
            <img src="{{ asset('storage/images/background.png') }}" class="w-full" />
            <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                <a href="#slide3" class="btn btn-circle">❮</a>
                <div class="w-full">
                    <div class="text-center p-20">
                        <h1 class="mb-5 text-5xl font-medium">
                            Enjoy Your Wonderful Holidays With A Great Luxury Experience! Most Relaxing Place

                        </h1>
                        <button class="btn btn-dark border border-black bg-black text-white">Get Started</button>
                        <button class="btn btn-secondary">Get Started</button>
                    </div>
                </div>
                <a href="#slide1" class="btn btn-circle">❯</a>
            </div>
        </div>
    </div>

    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content flex-col lg:flex-row">
            <div class="grid grid-cols-2 gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="card bg-black/50 image-full w-50 shadow-sm">
                        <figure>
                            {{-- <img src="{{ asset('storage/images/background.png') }}" alt="Shoes" /> --}}
                        </figure>
                        <div class="card-body text-center m-auto">
                            <h1 class="text-2xl font-bold">
                                OUR MISSION
                            </h1>
                        </div>
                    </div>
                    <div class="card bg-base-100 image-full w-50 shadow-sm">
                        <figure>
                            <img src="{{ asset('storage/images/image1.png') }}" alt="Shoes" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">
                                <i class="fa fa-location-arrow"></i>
                            </h2>
                        </div>
                    </div>
                    <div class="card bg-base-100 image-full w-50 shadow-sm">
                        <figure>
                            <img src="{{ asset('storage/images/image2.png') }}" alt="Shoes" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">
                                <i class="fa fa-location-arrow"></i>
                            </h2>
                        </div>
                    </div>
                    <div class="card bg-black/50 image-full w-50 shadow-sm">
                        <figure>
                            {{-- <img src="{{ asset('storage/images/background.png') }}" alt="Shoes" /> --}}
                        </figure>
                        <div class="card-body text-center m-auto">
                            <h1 class="text-2xl font-bold">
                                OUR VISION
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="my-auto mx-5">
                    <h1 class="text-5xl font-bold">About Us</h1>
                    <p class="py-6">
                        We are a team of passionate individuals dedicated to providing the best experience for our
                        users.
                        Our mission is to create innovative solutions that make your life easier and more enjoyable.
                        With
                        years of experience in the industry, we strive to deliver high-quality products and exceptional
                        customer service. Join us on this exciting journey as we continue to grow and evolve together.
                    </p>
                    <button class="btn btn-primary">Read More ...</button>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h1 class="text-6xl font-bold">Our Services</h1>
    </div>

    <div class="hero bg-base-200 my-10">
        <div class="hero-content flex-col lg:flex-row">
            <div class="grid grid-cols-1">
                <div class="grid grid-cols-5 gap-4">
                    <div class="card w-96 shadow-sm">

                        <div class="card-body items-center text-center">
                            <i class="fa-solid fa-champagne-glasses font-bold text-6xl"></i>
                            <h2 class="card-title">
                                Party
                            </h2>
                        </div>

                    </div>
                    <div class="card w-96 shadow-sm">

                        <div class="card-body items-center text-center">
                            <i class="fa-solid fa-ring font-bold text-6xl"></i>
                            <h2 class="card-title">
                                Wedding
                            </h2>
                        </div>

                    </div>
                    <div class="card w-96 shadow-sm">

                        <div class="card-body items-center text-center">
                            <i class="fa-solid fa-martini-glass-citrus font-bold text-6xl"></i>
                            <h2 class="card-title">
                                Kitchen Party
                            </h2>
                        </div>

                    </div>
                    <div class="card w-96 shadow-sm">

                        <div class="card-body items-center text-center">
                            <i class="fa-solid fa-cake-candles font-bold text-6xl"></i>
                            <h2 class="card-title">
                                Birthdays
                            </h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel rounded-box">
        <div class="carousel-item">
            <img class="w-[300px] h-[400px] object-cover" src="{{ asset('storage/images/img1.png') }}"
                alt="Burger" />
        </div>
        <div class="carousel-item">
            <img class="w-[300px] h-[400px] object-cover" src="{{ asset('storage/images/img7.png') }}"
                alt="Burger" />
        </div>
        <div class="carousel-item">
            <img class="w-[300px] h-[400px] object-cover" src="{{ asset('storage/images/img3.png') }}"
                alt="Burger" />
        </div>
        <div class="carousel-item">
            <img class="w-[300px] h-[400px] object-cover" src="{{ asset('storage/images/img8.png') }}"
                alt="Burger" />
        </div>
        <div class="carousel-item">
            <img class="w-[300px] h-[400px] object-cover" src="{{ asset('storage/images/img5.png') }}"
                alt="Burger" />
        </div>
        <div class="carousel-item">
            <img class="w-[300px] h-[400px] object-cover" src="{{ asset('storage/images/img9.png') }}"
                alt="Burger" />
        </div>
    </div>

    <div class="text-center my-20">
        <h1 class="text-6xl font-bold">Our Packages</h1>
    </div>

    <div class="hero p-2 mb-20">
        <div class="grid grid-cols-3 gap-4">

            <div class="card w-96 bg-base-100 shadow-lg border border-gray-400">
                <div class="card-body">
                    {{-- <span class="badge badge-xs badge-warning">Most Popular</span> --}}
                    <div class="flex justify-between">
                        <h2 class="text-3xl font-bold">Basic Card</h2>
                        <span class="text-xl">1,500 <span class="text-xs">Tsh/card</span></span>
                    </div>
                    <ul class="mt-6 flex flex-col gap-2 text-xs">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>High-resolution image generation</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Customizable style templates</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Batch processing capabilities</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>AI-driven image enhancements</span>
                        </li>
                        <li class="opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="size-4 me-2 inline-block text-base-content/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="line-through">Seamless cloud integration</span>
                        </li>
                        <li class="opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="size-4 me-2 inline-block text-base-content/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="line-through">Real-time collaboration tools</span>
                        </li>
                        <li class="opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="size-4 me-2 inline-block text-base-content/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="line-through">Real-time collaboration tools</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <button class="btn btn-primary btn-block">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="card w-96 bg-base-100 shadow-lg border border-gray-400">
                <div class="card-body">
                    {{-- <span class="badge badge-xs badge-warning">Most Popular</span> --}}
                    <div class="flex justify-between">
                        <h2 class="text-3xl font-bold">Standard Card</h2>
                        <span class="text-xl">2,000 <span class="text-xs">Tsh/card</span></span>
                    </div>
                    <ul class="mt-6 flex flex-col gap-2 text-xs">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>High-resolution image generation</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Customizable style templates</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Batch processing capabilities</span>
                        </li>
                        <li class="opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="size-4 me-2 inline-block text-base-content/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="line-through">Real-time collaboration tools</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>AI-driven image enhancements</span>
                        </li>
                        <li class="opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="size-4 me-2 inline-block text-base-content/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="line-through">Seamless cloud integration</span>
                        </li>
                        <li class="opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="size-4 me-2 inline-block text-base-content/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="line-through">Real-time collaboration tools</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <button class="btn btn-primary btn-block">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="card w-96 bg-base-100 shadow-lg border border-gray-400">
                <div class="card-body">
                    <span class="badge badge-xs badge-warning">Most Popular</span>
                    <div class="flex justify-between">
                        <h2 class="text-3xl font-bold">Premium Card</h2>
                        <span class="text-xl">2,500 <span class="text-xs">Tsh/card</span></span>
                    </div>
                    <ul class="mt-6 flex flex-col gap-2 text-xs">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>High-resolution image generation</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Customizable style templates</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Batch processing capabilities</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>AI-driven image enhancements</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>AI-driven image enhancements</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>AI-driven image enhancements</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <button class="btn btn-primary btn-block">Subscribe</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="hero min-h-screen relative overflow-hidden">

        <!-- 🎥 Background Video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('storage/images/wedding.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- 🌑 Overlay (DaisyUI style) -->
        <div class="hero-overlay bg-black/70 absolute inset-0"></div>

        <!-- 🧠 Content -->
        <div class="hero-content text-neutral-content text-center relative z-10">
            <div class="max-w-xl">
                <h1 class="mb-5 text-5xl font-bold">Watch one of our videos</h1>
                <p class="mb-5">
                    Take a glimpse into our world with this captivating video showcasing our services and the
                    unforgettable experiences we create for our clients.
                </p>
                <i class="fa fa-play text-5xl text-white"></i>
            </div>
        </div>

    </div>

    <div class="text-center my-20">
        <h1 class="text-6xl font-medium">Customer Feedback</h1>
    </div>

    <div class="hero p-5 px-20 mb-20">
        <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical mx-20">
            <li>
                <div class="timeline-middle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end">
                    <div class="avatar">
                        <div class="w-20 rounded-full">
                            <img src="https://img.daisyui.com/images/profile/demo/batperson@192.webp" />
                        </div>
                    </div><br>
                    <span class="font-mono italic">April 2025</span>
                    <div class="text-lg font-black">Eunice Johnson</div>
                    The services provided by this company were exceptional! From the initial consultation to the final
                    execution, every step was handled with utmost professionalism and care. The team went above and
                    beyond to ensure that our event was a resounding success, and we couldn't be happier with the
                    results. Highly recommended!
                </div>
                <hr />
            </li>
            <li>
                <hr />
                <div class="timeline-middle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-end md:mb-10">
                    <div class="avatar">
                        <div class="w-20 rounded-full">
                            <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                        </div>
                    </div><br>
                    <span class="font-mono italic">April 2025</span>
                    <div class="text-lg font-black">Alex Jerome</div>
                    iMac is a family of all-in-one Mac desktop computers designed and built by Apple Inc. It has
                    been the primary part of Apple's consumer desktop offerings since its debut in August 1998,
                    and has evolved through seven distinct forms
                </div>
                <hr />
            </li>
        </ul>
    </div>

    <footer class="footer sm:footer-horizontal bg-base-200 text-base-content p-10">
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
    <footer class="footer bg-base-200 text-base-content border-base-300 border-t px-10 py-4">
        <aside class="grid-flow-col items-center">
            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                fill-rule="evenodd" clip-rule="evenodd" class="fill-current">
                <path
                    d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z">
                </path>
            </svg>
            <p>
                Tapeventcard.
                <br />
                Providing reliable tech since 2022
            </p>
        </aside>
        <nav class="md:place-self-center md:justify-self-end">
            <div class="grid grid-flow-col gap-4">
                <a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                        </path>
                    </svg>
                </a>
                <a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                        </path>
                    </svg>
                </a>
                <a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        class="fill-current">
                        <path
                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                        </path>
                    </svg>
                </a>
            </div>
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

    <div class="fab">
        <!-- a focusable div with tabindex is necessary to work on all browsers. role="button" is necessary for accessibility -->
        <div tabindex="0" role="button" class="btn btn-lg btn-circle btn-primary">F</div>

        <!-- buttons that show up when FAB is open -->
        <button class="btn btn-lg btn-circle">A</button>
        <button class="btn btn-lg btn-circle">B</button>
        <button class="btn btn-lg btn-circle">C</button>
    </div>

</body>

</html>
