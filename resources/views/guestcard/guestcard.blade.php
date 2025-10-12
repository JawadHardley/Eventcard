@extends('layouts.guest')
@section('content')
    <div class="flex justify-center py-10">

        <div class="card bg-base-100 w-96 shadow-lg border-2 border-indigo-900/20">
            <figure class="px-5 pt-5">
                <img src="https://joshuastruth.com/wp-content/uploads/2020/08/one-zone-studio-MwzvSYNccWk-unsplash-scaled.jpg"
                    alt="Shoes" class="rounded-xl border border-blue-700/10" />
            </figure>
            <div class="card-body">
                <h2 class="card-title mb-5 font-bold text-xl">SARAH <span class="dark:text-indigo-900">&</span> JOHN's
                    Wedding
                </h2>
                <p class="teal">
                    <i class="fa fa-map-location-dot text-xl mr-3 dark:text-indigo-900"></i>
                    {{ $order->location ?? 'Serena Hotel, Dar es salaam' }}
                </p>
                <p class="teal">
                    <i class="fa fa-calendar-day text-xl mr-3 dark:text-indigo-900"></i>
                    {{ $order->date ?? 'Saturday, 20-Oct-2025  |  6:00 PM' }}
                </p>
                <p class="teal">
                    <i class="fa fa-shirt text-xl mr-3 dark:text-indigo-900"></i>
                    {{ $order->dresscode ?? 'Navy Blue' }}
                </p>
                <div class="items-center">
                    <div class="divider divider-primary">
                        <i class="fa fa-user rounded-full text-indigo-900 border-2 border-blue-700/20 p-2"></i>
                    </div>
                    <p class="text-2xl text-center">
                        Welcome, <b>{{ $guest->full_name ?? 'Guest' }}</b>
                    </p>
                    <p class="p-5">
                    <div
                        class="grid text-gray-500 auto-cols-max grid-flow-col gap-5 text-center items-center justify-center">
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="days" style="--value:8;"></span>
                            </span>
                            days
                        </div>
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="hours" style="--value:12;"></span>
                            </span>
                            hours
                        </div>
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="minutes" style="--value:02;"></span>
                            </span>
                            min
                        </div>
                        <div class="flex flex-col">
                            <span class="countdown font-mono text-5xl">
                                <span id="seconds" style="--value:59;"></span>
                            </span>
                            sec
                        </div>
                    </div>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <script>
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
    </script>
@endsection
