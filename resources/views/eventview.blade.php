@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <x-error_show />
            <div class="rounded">
                <div class="card mb-5 card-md">
                    <div class="card-body p-3">
                        <div class="grid grid-cols-12">
                            <div class="col-span-12 md:col-span-1 m-auto">
                                <div class="avatar">
                                    <div class="rounded-xl bg-indigo-900/30 p-4 text-2xl">
                                        <i class="fa fa-calendar-days"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-7 m-auto p-4 md:m-0 md:p-2">
                                <h2 class="text-2xl">{{ $events->order_name }}</h2>
                                <h2 class="text-lg opacity-60">{{ $events->event_host }}</h2>
                                <p class="py-2">
                                    @if ($events->event_status == 'active')
                                        <div class="badge badge-soft badge-success mr-2">
                                            <i class="fa fa-play"></i> Event Active
                                        </div>
                                    @elseif($events->event_status == 'completed')
                                        <div class="badge badge-success mr-2">
                                            <i class="fa fa-circle-check"></i> Event Ended
                                        </div>
                                    @else
                                        <div class="badge badge-soft badge-error mr-2">
                                            <i class="fa fa-circle-stop"></i> Event Cancelled
                                        </div>
                                    @endif


                                    @if ($events->payment_status == 'pending')
                                        <div class="badge badge-soft badge-primary mr-2">
                                            <i class="fa fa-money-check-dollar"></i> Pending Payment
                                        </div>
                                    @elseif($events->payment_status == 'paid')
                                        <div class="badge badge-soft badge-success mr-2">
                                            <i class="fa fa-money-check-dollar"></i> Paid
                                        </div>
                                    @else
                                        <div class="badge badge-soft badge-error mr-2">
                                            <i class="fa fa-money-check-dollar"></i> Cancelled Payment
                                        </div>
                                    @endif
                                </p>
                            </div>
                            <div class="col-span-12 md:col-span-4 my-auto flex justify-end">

                                <button class="btn btn-outline btn-primary mx-1" popovertarget="popover-1"
                                    style="anchor-name:--anchor-1">
                                    <i class="fa fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown menu w-52 rounded-box bg-base-100 shadow-xl" popover id="popover-1"
                                    style="position-anchor:--anchor-1">
                                    <li>
                                        <a onclick="editevent.showModal()">
                                            <i class="fa fa-edit"></i> Edit Event
                                        </a>
                                    </li>
                                    <li>
                                        <a onclick="deleted.showModal()">
                                            <i class="fa fa-trash text-rose-800"></i> Delete Event
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-eye"></i> See Card
                                        </a>
                                    </li>
                                    <li>
                                        <a onclick="csvmodal.showModal()">
                                            <i class="fa fa-table text-teal-800"></i> Multi-upload Guests
                                        </a>
                                    </li>
                                </ul>

                                <a href="{{ route('user.cameralog', ['event' => $events->id]) }}"
                                    class="btn btn-outline btn-primary mx-1">
                                    <i class="fa fa-camera"></i>
                                </a>

                                <button class="btn btn-outline btn-primary mx-1" onclick="guest_form.showModal()">
                                    <i class="fa fa-circle-plus mr-1"></i> Guest
                                </button>
                                {{-- the modal for the guest form --}}
                                <dialog id="guest_form" class="modal">
                                    <div class="modal-box">
                                        <h3 class="text-lg font-bold text-center">Add Guest</h3>
                                        <p class="py-4">
                                        <form method="POST" action="{{ route('user.guestadd') }}" class="w-full">
                                            @csrf

                                            <fieldset class="fieldset w-full">
                                                <label class="text-base">Full Name</label>
                                                <input type="text" name="full_name" class="input w-full"
                                                    placeholder="full name" required />
                                                <input type="hidden" name="event_id" class="input w-full"
                                                    placeholder="full name" value="{{ $events->id }}" required />

                                                <div class="flex flex-wrap gap-4 mt-5">
                                                    <div class="flex-1">
                                                        <label class="text-base mt-5">Card Type</label>
                                                        <select class="select w-50" name="title" required>
                                                            <option selected value="single">Single</option>
                                                            <option value="double">Double</option>
                                                        </select>
                                                    </div>
                                                    <div class="flex-1">
                                                        <label class="text-base mt-5">Delivery Method</label>
                                                        <select class="select w-full" name="delivery_method" required>
                                                            <option selected value="sms">sms</option>
                                                            <option value="email">email</option>
                                                            <option value="whatsapp">whatsapp</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label class="text-base mt-5">Email</label>
                                                <input type="email" name="email" class="input w-full"
                                                    placeholder="example@mail.com" required />

                                                <label class="text-base mt-5">Phonenumber</label>
                                                <input type="text" name="phone" class="input w-full"
                                                    placeholder="+255XX or 06XX" required />


                                                <label class="text-base mt-5">Address</label>
                                                <textarea class="textarea w-full" name="address" placeholder="Bio"></textarea>

                                                <div class="pt-4">
                                                    <button type="submit" class="btn btn-primary w-full">Save</button>
                                                </div>
                                            </fieldset>
                                        </form>
                                        </p>
                                        <div class="modal-action">
                                            <form method="dialog">
                                                <!-- if there is a button in form, it will close the modal -->
                                                <button class="btn">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>

                                <a href="{{ route('user.addevent') }}" class="btn btn-primary mx-1">
                                    <i class="fa fa-circle-plus mr-1s"></i> Add Event
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-8">
            {{-- <div class="p-3 m-3 bg-base-100 border border-stone-900/10 rounded-lg">
                <h3>{{ $events->order_name }}</h3>
            </div> --}}
            <div class="p-3 m-3 bg-base-100 border border-stone-900/10 rounded-lg">
                <div class="mb-5">
                    <input 
                        type="text"
                        id="guestSearch"
                        placeholder="Search guest..."
                        class="input input-bordered w-full"
                    />
                </div>
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead class="bg-base-100">
                            <tr>
                                <th>s/n</th>
                                <th>Guest name</th>
                                <th>Contact Validity</th>
                                <th>Qr/Code</th>
                                <th>Method</th>
                                <th>Card</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody class="mb-4">
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($guests as $guest)
                                <!-- row 1 -->
                                <tr class="my-4 guest-row">
                                    <th>{{ $counter }}</th>
                                    {{-- <td>{{ $guest->full_name }}</td> --}}
                                    <td scope="row" class="flex items-center px-6 py-4 whitespace-nowrap">
                                        <i class="fa fa-user rounded-full p-3 bg-blue-900/90 text-center text-white"></i>
                                        <div class="ps-3">
                                            <div class="font-semibold">{{ $guest->full_name }}</div>
                                            <div class="font-normal text-gray-500">{{ $guest->phone }}</div>
                                        </div>
                                    </td>
                                    @php
                                        $digits = preg_replace('/\D/', '', $guest->phone);
                                    @endphp

                                    <td>
                                        @if (strlen($digits) == 10)
                                            <span class="text-success">
                                                <div class="badge badge-dash badge-accent">Valid</div>
                                            </span>
                                        @elseif(strlen($digits) < 10)
                                            <span class="text-danger">
                                                <div class="badge badge-dash badge-warning">invalid--</div>
                                            </span>
                                        @else
                                            <span class="text-danger">
                                                <div class="badge badge-dash badge-error">invalid++</div>
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $guest->invitation_code }}</td>
                                    <td>

                                        @if ($guest->delivery_method == 'sms')
                                            <i class="fa fa-comment-sms p-2 text-xl text-blue-700/90">
                                            </i>
                                        @elseif ($guest->delivery_method == 'whatsapp')
                                            <i class="fa fa-comments p-2 text-xl text-lime-700/90">
                                            </i>
                                        @elseif ($guest->delivery_method == 'email')
                                            <i class="fa fa-envelope p-2 text-xl text-rose-700/90">
                                            </i>
                                        @endif

                                    </td>
                                    <td>
                                        @if ($guest->title == 'double')
                                            <div class="badge badge-soft badge-primary">2x Double</div>
                                        @else
                                            <div class="badge badge-soft badge-indigo">Single</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($guest->title == 'double')
                                            @if ($guest->verified == 0 && $guest->counter == '[0/2]')
                                                <div class="badge badge-soft badge-error">pending</div>
                                            @elseif($guest->verified == 1 && $guest->counter == '[1/2]')
                                                <div class="badge badge-soft badge-warning">used [1/2]</div>
                                            @elseif($guest->verified == 1 && $guest->counter == '[2/2]')
                                                <div class="badge badge-soft badge-success">used [2/2]</div>
                                            @endif
                                        @else
                                            @if ($guest->verified == 1)
                                                <div class="badge badge-soft badge-success">used</div>
                                            @else
                                                <div class="badge badge-soft badge-error">pending</div>
                                            @endif
                                        @endif

                                    </td>
                                    <td>
                                        <a href="#" class="text-blue-500/90"
                                            onclick="qrmodal_{{ $counter }}.showModal()">
                                            <span class="mx-1"><i class="fa fa-expand mx-1"></i> view</span>
                                        </a>
                                    </td>
                                </tr>

                                <dialog id="qrmodal_{{ $counter }}" class="modal">
                                    <div class="modal-box">
                                        <form method="dialog">
                                            <button
                                                class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                        </form>
                                        <h3 class="text-lg text-center font-bold">{{ $guest->full_name }}</h3>
                                        <div class="col">
                                            <p class="py-1 text-center">{{ $guest->qrcode }}</p>
                                            <p class="p-3 bg-stone-50 rounded-lg flex justify-center align-center">
                                                @if ($guest->qrcode)
                                                    {!! QrCode::size(200)->generate($guest->more ?? $guest->qrcode) !!}
                                                @else
                                                    <span class="text-red-500">No QR assigned</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="divider">
                                            <i class="fa fa-object-ungroup"></i>
                                        </div>
                                        <div class="dd">
                                            <a href="{{ route('user.generateCardImage', ['code' => $events->id, 'guest' => $guest->id]) }}"
                                                id="downloadBtn" class="btn btn-primary">Download Card</a>

                                                
                                            <a href="{{ route('user.cardview', ['event' => $events->id, 'guest' => $guest->id]) }}"
                                                id="downloadBtn" target="_blank" class="btn btn-success">View Card</a>
                                        </div>
                                        <form method="POST" action="{{ route('user.guestupdate', $guest->id) }}"
                                            class="w-full">
                                            @csrf

                                            <fieldset class="fieldset w-full">
                                                <div class="flex flex-wrap gap-4 mt-5">
                                                    <div class="flex-1">
                                                        <label class="text-base">Full Name</label>
                                                        <input type="text" name="full_name" class="input w-full"
                                                            placeholder="full name" value="{{ $guest->full_name }}"
                                                            required />
                                                        <input type="hidden" name="event_id" class="input w-full"
                                                            placeholder="full name" value="{{ $events->id }}"
                                                            required />
                                                    </div>
                                                    <div class="flex-1">
                                                        <label class="text-base mt-5">Email</label>
                                                        <input type="email" name="email" class="input w-full"
                                                            placeholder="example@mail.com" value="{{ $guest->email }}"
                                                            required />
                                                    </div>
                                                </div>
                                                <div class="flex flex-wrap gap-4 mt-5">
                                                    <div class="flex-1">
                                                        <label class="text-base mt-5">Card Type</label>
                                                        <select class="select w-50" name="title" required>
                                                            <option value="single"
                                                                {{ $guest->title == 'single' ? 'selected' : 'y' }}>
                                                                Single</option>
                                                            <option value="double"
                                                                {{ $guest->title == 'double' ? 'selected' : 'x' }}>
                                                                Double</option>
                                                        </select>
                                                    </div>
                                                    <div class="flex-1">
                                                        <label class="text-base mt-5">Delivery Method</label>
                                                        <select class="select w-full" name="delivery_method" required>
                                                            <option value="sms"
                                                                {{ $guest->delivery_method == 'sms' ? 'selected' : '' }}>
                                                                sms</option>
                                                            <option value="email"
                                                                {{ $guest->delivery_method == 'email' ? 'selected' : '' }}>
                                                                email</option>
                                                            <option value="whatsapp"
                                                                {{ $guest->delivery_method == 'whatsapp' ? 'selected' : '' }}>
                                                                whatsapp</option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <label class="text-base mt-5">Phonenumber</label>
                                                <input type="text" name="phone" class="input w-full"
                                                    placeholder="+255XX or 06XX" value="{{ $guest->phone }}" required />


                                                <label class="text-base mt-5">Address</label>
                                                <textarea class="textarea w-full" name="address" placeholder="Bio">{{ $guest->address }}
                                                </textarea>

                                                <label class="text-base mt-5">Invitation Text</label>

                                                <div class="text-base">
                                                    <h3 class="font-bold">*{{ $events->order_name }}*</h3>
                                                    <br />

                                                    <p class="py-3">

                                                        Familia ya Anyosisye B. Mwandumbya wa Magomeni Kagera, Wanapenda kukualika *<span class="font-bold">{{ $guest->full_name }}</span>* Kwenye sendoff ya binti yao mpendwa *<span class="font-bold">{{ $events->event_host }}</span>*

                                                    </p>

                                                    Tarehe:
                                                    {{ $events->event_date ? \Carbon\Carbon::parse($events->event_date)->format('l, d-M-Y') : 'missing' }}
                                                    |
                                                    {{ $events->arrival_time ? \Carbon\Carbon::parse($events->arrival_time)->format('g:i A') : 'missing PM' }}
                                                    <br />
                                                    Ukumbi: {{ $events->event_location ?? 'missing' }} <br />
                                                    Mahali (location): {{ $events->event_desc ?? 'missing' }} <br />
                                                    dresscode: Rosegold <br />
                                                    Aina: {{ $guest->title ?? 'missing' }} <br />
                                                    S/N: {{ $guest->invitation_code ?? 'missing' }} <br /> <br />

                                                    Location: https://maps.app.goo.gl/JqaKFPZhVwuCUURo6

                                                    <br /> <br />

                                                    Asante na Karibu Sana <br />
                                                    {{ $guest->more }}
                                                    <br /><br />
                                                    Designed by TapEventCard 0778515202

                                                </div>

                                                <div class="pt-4">
                                                    <button type="submit" class="btn btn-primary w-full">Save</button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </dialog>
                                @php
                                    $counter++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <script>
                document.getElementById('guestSearch').addEventListener('keyup', function () {
                    let filter = this.value.toLowerCase();
                    document.querySelectorAll('.guest-row').forEach(row => {
                        let text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
                </script>
            </div>
        </div>
        <div class="col-span-12 md:col-span-4">
            <div class="p-3 m-3 bg-base-100 border border-stone-700/10 rounded-lg">
                <h3 class="font-bold text-lg">Event Info</h3>
                <ul class="list bg-base-100 rounded-box">
                    <li class="list-row">
                        <div class="m-auto text-xl text-indigo-900/90">
                            <i class="fa fa-address-card"></i>
                        </div>
                        <div>
                            <div>{{ $counter - 1 }} / {{ $events->guest_limit }}</div>
                            <div class="text-xs font-semibold opacity-60">Guest limit (Cards)</div>
                        </div>
                        {{-- <button class="btn btn-square btn-ghost">
                            <i class="fa fa-play"></i>
                            </svg>
                        </button> --}}
                    </li>
                    <li class="list-row">
                        <div class="m-auto text-xl text-indigo-900/90">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div>
                            <div>{{ \Carbon\Carbon::parse($events->event_date)->format('j F Y') }}</div>
                            <div class="text-xs font-semibold opacity-60">Event Date</div>
                        </div>
                        {{-- <button class="btn btn-square btn-ghost">
                            <i class="fa fa-play"></i>
                            </svg>
                        </button> --}}
                    </li>
                    <li class="list-row">
                        <div class="m-auto text-xl text-indigo-900/90">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div>
                            <div>{{ date('g:i A', strtotime($events->arrival_time)) }}</div>
                            <div class="text-xs font-semibold opacity-60">Arrival time</div>
                        </div>
                        {{-- <button class="btn btn-square btn-ghost">
                            <i class="fa fa-play"></i>
                            </svg>
                        </button> --}}
                    </li>
                    <li class="list-row">
                        <div class="m-auto text-xl text-indigo-900/90">
                            <i class="fa fa-map-location-dot"></i>
                        </div>
                        <div>
                            <div>{{ $events->event_location }}</div>
                            <div class="text-xs font-semibold opacity-60">Event location</div>
                        </div>
                        {{-- <button class="btn btn-square btn-ghost">
                            <i class="fa fa-play"></i>
                            </svg>
                        </button> --}}
                    </li>
                    <li class="list-row">
                        <div class="m-auto text-xl text-indigo-900/90">
                            <i class="fa fa-martini-glass-citrus"></i>
                        </div>
                        <div>
                            <div>{{ $events->event_type }}</div>
                            <div class="text-xs font-semibold opacity-60">Event type</div>
                        </div>
                        {{-- <button class="btn btn-square btn-ghost">
                            <i class="fa fa-play"></i>
                            </svg>
                        </button> --}}
                    </li>
                </ul>
            </div>
            <div class="p-3 m-3 bg-base-100 border border-stone-700/10 rounded-lg">
                <h3 class="font-bold text-lg">Addtional Description</h3>
                <p class="py-2 opacity-80">
                    {{ $events->event_desc }}
                </p>
            </div>
        </div>
    </div>


    {{-- event edit modal --}}
    {{-- event edit modal --}}
    {{-- event edit modal --}}

    <dialog id="editevent" class="modal w-full">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <fieldset class="fieldset rounded-xl p-4 bg-base-100">
                <h2 class="text-xl font-bold mb-3 text-center text-primary">
                    <i class="fa fa-edit mr-3"></i> Update Event
                </h2>
                <div class="divider"></div>

                <form action="{{ route('user.eventupdate', ['id' => $events->id]) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Row 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label font-semibold">Order Name</label>
                            <input type="text" name="order_name" value="{{ $events->order_name }}"
                                class="input input-bordered w-full" placeholder="Event Order Name" />
                        </div>

                        <div>
                            <label class="label font-semibold">Event Host</label>
                            <input type="text" name="event_host" value="{{ $events->event_host }}"
                                class="input input-bordered w-full" placeholder="Hosted by..." />
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                        <div>
                            <label class="label font-semibold">Event Type</label>
                            <input type="text" name="event_type" value="{{ $events->event_type }}"
                                class="input input-bordered w-full" placeholder="Wedding, Party..." />
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="label font-semibold">Event Date</label>
                            <input type="date" name="event_date" value="{{ $events->event_date }}"
                                class="input input-bordered w-full" />
                        </div>

                        <div>
                            <label class="label font-semibold">Arrival Time</label>
                            <input type="time" name="arrival_time" value="{{ $events->arrival_time }}"
                                class="input input-bordered w-full" />
                        </div>

                        <div>
                            <label class="label font-semibold">Reminder Date</label>
                            <input type="date" name="reminder_date" value="{{ $events->reminder_date }}"
                                class="input input-bordered w-full" />
                        </div>
                    </div>

                    <!-- Row 4 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label font-semibold">Event Location</label>
                            <input type="text" name="event_location" value="{{ $events->event_location }}"
                                class="input input-bordered w-full" placeholder="Venue / City" />
                        </div>

                        <div>
                            <label class="label font-semibold">Timezone (by IP)</label>
                            <input type="text" name="timezone" value="{{ $events->timezone }}"
                                class="input input-bordered w-full" placeholder="Africa/Dar_es_Salaam" />
                        </div>
                    </div>

                    <!-- Row 5 -->
                    <div>
                        <label class="label font-semibold">Event Description</label>
                        <textarea name="event_desc" rows="3" class="textarea textarea-bordered w-full"
                            placeholder="Write a short description about the event...">{{ $events->event_desc }}</textarea>
                    </div>

                    <!-- Row 7 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label font-semibold">Slug (SEO)</label>
                            <input type="text" name="slug" value="{{ $events->slug }}"
                                class="input input-bordered w-full" placeholder="my-awesome-event" />
                        </div>

                        <div>
                            <label class="label font-semibold">Guest/Card Limit</label>
                            <input type="number" name="guest_limit" value="{{ $events->guest_limit }}"
                                class="input input-bordered w-full" placeholder="100" disabled />
                        </div>
                    </div>

                    <div class="divider"></div>

                    <button type="submit" class="btn btn-primary w-full text-lg font-semibold">
                        <i class="fa fa-check-circle mr-2"></i> Update Event
                    </button>
                </form>
            </fieldset>
        </div>
    </dialog>


    <!-- Open the modal for excel upload -->
    <dialog id="csvmodal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold text-center mb-10">
                <i class="fa fa-table mx-1 text-teal-900"></i> Multi-upload Guests with Excel/CSV
            </h3>
            <form method="POST" action="{{ route('user.importGuests') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 p-2">
                    <div>
                        <label class="label font-semibold mb-5">Upload Excel file</label>
                        <input type="file" name="file" class="input input-bordered w-full" />
                        <input type="hidden" name="event_id" value="{{ $events->id }}" />
                    </div>
                </div>

                <div class="divider"></div>
                <div class="modal-action">
                    <form method="dialog">
                        <!-- if there is a button in form, it will close the modal -->
                        <button class="btn">Close</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-arrow-up"></i> Save</button>
                    </form>
                </div>
            </form>
        </div>
    </dialog>
@endsection
