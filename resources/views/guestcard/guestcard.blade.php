@extends('layouts.guest')
@section('content')
    <div class="flex justify-center py-2">

        <div class="card bg-base-100 w-96 shadow-lg border-2 border-indigo-900/20">
            <!-- <figure class="px-5 pt-5">

                @php
                    $path = storage_path('app/public/event1x.jpeg'); // full filesystem path
                    $imageData = base64_encode(file_get_contents($path));
                    $mime = mime_content_type($path);
                @endphp

                <img src="data:{{ $mime }};base64,{{ $imageData }}"
                    alt="Shoes" class="rounded-xl border border-blue-700/10" />
            </figure> -->

            <style>
                .slider-container {
                    width: 100%;
                    height: auto;
                    position: relative;
                    aspect-ratio: 5/6; /* Keeps same shape nicely; can adjust */
                }

                .slider-image {
                    transition: opacity 1.3s ease-in-out;
                }
            </style>

            <figure class="p-3 relative overflow-hidden">

                <div class="slider-container relative rounded-xl border border-blue-700/10">

                    @php
                        $images = [
                            storage_path('app/public/event1x.jpeg'),
                            storage_path('app/public/event2x.jpeg'),
                            storage_path('app/public/event3x.jpeg'),
                        ];
                    @endphp

                    @foreach ($images as $index => $path)
                        @php
                            $imageData = base64_encode(file_get_contents($path));
                            $mime = mime_content_type($path);
                        @endphp

                        <img 
                            src="data:{{ $mime }};base64,{{ $imageData }}"
                            class="slider-image absolute top-0 left-0 w-full h-full object-cover rounded-xl border border-blue-700/10
                            @if($index === 0) opacity-100 @else opacity-0 @endif"
                        />
                    @endforeach

                </div>
            </figure>

            <script>
                let slideIndex = 0;
                const slides = document.querySelectorAll('.slider-image');

                setInterval(() => {
                    slides[slideIndex].style.opacity = 0;
                    slideIndex = (slideIndex + 1) % slides.length;
                    slides[slideIndex].style.opacity = 1;
                }, 3000);
            </script>
            
            <div class="card-body">
                <h2 class="card-title text-center mb-4 font-bold text-xl">
                    {{ $event->order_name }}
                </h2>
                <p class="teal">
                    <i class="fa fa-map-location-dot text-xl mr-3 dark:text-indigo-900"></i>
                    {{ $event->event_location }}, {{ $event->event_desc }}
                </p>
                <p class="teal">
                    <i class="fa fa-calendar-day text-xl mr-3 dark:text-indigo-900"></i>
                    {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('l, d-M-Y') : 'missing' }}
                                            |
                    {{ $event->arrival_time ? \Carbon\Carbon::parse($event->arrival_time)->format('g:i A') : 'missing PM' }}
                </p>
                <p class="teal">
                    <i class="fa fa-shirt text-xl mr-3 text-[rgb(183,110,121)] dark:text-indigo-900"></i>
                    {{ $event->dresscode ?? 'Rosegold' }}
                </p>
                <div class="items-center">
                    <div class="divider divider-primary">
                        <i class="fa fa-user rounded-full text-indigo-900 border-2 border-blue-700/20 p-2"></i>
                    </div>
                    <p class="text-2xl text-center">
                        Karibu, <b>{{ $guest->full_name ?? 'Guest' }}</b>
                    </p>
                    <p class="p-5">

                    @php
                        // Combine date and time into a single Carbon datetime
                        $eventDateTime = \Carbon\Carbon::parse($event->event_date . ' ' . $event->arrival_time);
                    @endphp
                
                    <div
                        class="grid text-gray-500 auto-cols-max grid-flow-col gap-4 text-center items-center justify-center">
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="days" style="--value:0;"></span>
                            </span>
                            days
                        </div>
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="hours" style="--value:0;"></span>
                            </span>
                            hours
                        </div>
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="minutes" style="--value:0;"></span>
                            </span>
                            min
                        </div>
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="seconds" style="--value:0;"></span>
                            </span>
                            sec
                        </div>
                    </div>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- <script>
        // ⏳ Start countdown (e.g. 15 days from now)
        let totalSeconds = (15 * 24 * 60 * 60) + (10 * 60 * 60) + (24 * 60) + 59;

        const d = document.getElementById("days");
        const h = document.getElementById("hours");
        const m = document.getElementById("minutes");
        const s = document.getElementById("seconds");

        const timer = setInterval(() => {
            if (totalSeconds <= 0) {
                clearInterval(timer);
                return;
            }

            totalSeconds--;

            // Convert to readable format
            const days = Math.floor(totalSeconds / (24 * 3600));
            const hours = Math.floor((totalSeconds % (24 * 3600)) / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            // Update DaisyUI display via CSS variables
            d.style.setProperty("--value", days);
            h.style.setProperty("--value", hours);
            m.style.setProperty("--value", minutes);
            s.style.setProperty("--value", seconds);
        }, 1000);
    </script> -->

    <script>
    // 🕒 Get event datetime from PHP
    const eventTime = new Date("{{ $eventDateTime->format('Y-m-d H:i:s') }}").getTime();

    const d = document.getElementById("days");
    const h = document.getElementById("hours");
    const m = document.getElementById("minutes");
    const s = document.getElementById("seconds");

    const timer = setInterval(() => {
        const now = new Date().getTime();
        let totalSeconds = Math.floor((eventTime - now) / 1000);

        if (totalSeconds <= 0) {
            clearInterval(timer);
            d.style.setProperty("--value", 0);
            h.style.setProperty("--value", 0);
            m.style.setProperty("--value", 0);
            s.style.setProperty("--value", 0);
            return;
        }

        const days = Math.floor(totalSeconds / (24 * 3600));
        const hours = Math.floor((totalSeconds % (24 * 3600)) / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        d.style.setProperty("--value", days);
        h.style.setProperty("--value", hours);
        m.style.setProperty("--value", minutes);
        s.style.setProperty("--value", seconds);
    }, 1000);
</script>
@endsection
