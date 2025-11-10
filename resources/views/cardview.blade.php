@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="flex justify-center py-10">

                <div id="idcard" class="card bg-base-100 w-96 shadow-lg border-2 border-indigo-900/20">
                    <div class="relative">
                        @php
                            $path = storage_path('app/public/event1x.jpeg'); // full filesystem path
                            $imageData = base64_encode(file_get_contents($path));
                            $mime = mime_content_type($path);
                        @endphp
                        <img src="data:{{ $mime }};base64,{{ $imageData }}" alt="Sendoff Card Background"
                            class="w-full h-64 object-cover rounded-t-lg">

                        <!-- Rose gold overlay -->
                        <div class="absolute inset-0 bg-[rgba(183, 110, 110, 0.35)] rounded-t-lg"></div>

                        <!-- Text on top of image -->
                        {{-- <div class="absolute top-4 left-1/2 -translate-x-1/2 text-center px-3">
                            <h2 class="text-2xl font-bold tracking-wide" style="color: #ffffffff;">
                                Gladnes' Send-off Party
                            </h2>

                            <p class="uppercase text-xs mt-1 tracking-widest text-white/90">
                                {{ $order->event_title ?? 'Wedding Celebration' }}
                            </p>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        <h2 class="font-bold text-xl text-center m-0">
                            {{ $event->order_name }}
                        </h2>
                        <div class="flex w-full flex-col">
                            <div class="divider divider-[rgba(183,110,121,1)] mt-0 mb-0"> </div>
                        </div>
                        <p class="p-0 text-base text-center mt-1">
                            Familia ya Anyosisye B. Mwandumbya wa Magomeni Kagera, Wanapenda kukualika <br /> <span class="inline-block font-bold text-indigo-900 my-2">{{ strtoupper($guest->full_name) }}</span> <br />  Kwenye sendoff ya binti yao mpendwa  <br /> <span class="font-bold">{{ $event->event_host }}</span>
                        </p>

                        <div class="w-full max-w-full mt-4 p-0">
                            <table class="table table-auto w-full">
                                <tbody>
                                    <tr>
                                        <td class="m-0 p-1 text-center">
                                            <i class="fa fa-calendar-day m-0 p-0 text-md dark:text-indigo-900"></i>
                                        </td>
                                        <td class="m-0 p-1">
                                            <span class="font-bold text-md m-0 p-0">Tarehe</span>
                                        </td>
                                        <td class="m-0 p-1 break-words break-all max-w-[400px]">
                                            {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('l, d-M-Y') : 'missing' }}
                                            |
                                            {{ $event->arrival_time ? \Carbon\Carbon::parse($event->arrival_time)->format('g:i A') : 'missing PM' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="m-0 p-1 text-center">
                                            <i class="fa fa-people-roof text-md dark:text-indigo-900"></i>
                                        </td>
                                        <td class="m-0 p-1">
                                            <span class="font-bold text-md">Ukumbi: </span>
                                        </td>
                                        <td class="m-0 p-1 break-words max-w-[400px]">
                                            {{ $event->event_location ?? 'missing' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="m-0 p-1 text-center">
                                            <i class="fa fa-location-dot text-md dark:text-indigo-900"></i>
                                        </td>
                                        <td class="m-0 p-1">
                                            <span class="font-bold text-md">Mahali: </span>
                                        </td>
                                        <td class="m-0 p-1 break-words max-w-[400px]">
                                            {{ $event->event_desc ?? 'missing' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="m-0 p-1 text-center">
                                            <i class="fa fa-shirt text-md dark:text-indigo-900"></i>
                                        </td>
                                        <td class="m-0 p-1">
                                            <span class="font-bold text-md">Dresscode: </span>
                                        </td>
                                        <td class="m-0 p-1 break-words max-w-[400px]">
                                            Rosegold <i
                                                class="fa fa-mattress-pillow ml-2 text-[rgba(183,110,121,1)] text-xl"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="m-0 p-1 text-center">
                                            <i class="fa fa-layer-group text-md dark:text-indigo-900"></i>
                                        </td>
                                        <td class="m-0 p-1">
                                            <span class="font-bold text-md">Aina: </span>
                                        </td>
                                        <td class="m-0 p-1 break-words max-w-[400px]">
                                            {{ $guest->title ?? 'missing' }}
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="m-0 p-1 whitespace-nowrap">2</td>
                                        <td class="m-0 p-1 whitespace-nowrap">X</td>
                                        <td class="m-0 p-1 break-words max-w-[400px]">
                                            Short text
                                        </td>
                                    </tr> --}}
                                    <!-- more rows -->
                                </tbody>
                            </table>
                        </div>

                        <div class="items-center mt-10">
                            <div class="divider divider-primary">
                                {{-- <i class="fa fa-user text-indigo-900 border-2 border-blue-700/20 p-2"></i> --}}
                                <div class="text-indigo-900 font-bold">
                                    <p class="p-2 flex justify-center">
                                        {!! QrCode::size(100)->generate($guest->more ?? 'missing') !!}
                                    </p>
                                </div>
                            </div>
                            <p class="text-2xl text-center mt-20" style="font-family: 'Brittany Signature', cursive;">
                                Asante <span class="text-indigo-900">na</span> Karibu Sana
                            </p>
                            <p class="text-center">
                                Designed by TapEventCard <span class="text-indigo-900 font-bold">0778515202</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/css-color-parser-js/1.0.3/css-color-parser.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        document.getElementById("downloadBtn").addEventListener("click", function() {
            const card = document.getElementById("idcard");

            html2canvas(card, {
                scale: 2
            }).then(canvas => {
                // Convert canvas to image
                const link = document.createElement("a");
                link.download = "idcard.png";
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        });
    </script>
@endsection
