@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <x-error_show />
            <div class="rounded">
                <div class="card mb-5 card-md">
                    <div class="card-body p-3">
                        <div class="grid grid-cols-12">
                            <div class="col-span-1 m-auto">
                                <div class="avatar">
                                    <div class="rounded-xl bg-indigo-900/30 p-4 text-2xl">
                                        <i class="fa fa-calendar-days"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-7">
                                <h2 class="text-2xl">{{ $events->order_name }}</h2>
                                <h2 class="text-lg opacity-60">{{ $events->event_host }}</h2>
                                <p class="py-2">
                                <div class="badge badge-soft badge-success mr-2">
                                    <i class="fa fa-play"></i> Event Active
                                </div>
                                <div class="badge badge-soft badge-primary mr-2">
                                    <i class="fa fa-money-check-dollar"></i> Pending Payment
                                </div>
                                </p>
                            </div>
                            <div class="col-span-4 my-auto flex justify-end">

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
                                </ul>

                                <a href="{{ route('user.cameralog') }}" class="btn btn-outline btn-primary mx-1">
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
        <div class="col-span-8">
            {{-- <div class="p-3 m-3 bg-base-100 border border-stone-900/10 rounded-lg">
                <h3>{{ $events->order_name }}</h3>
            </div> --}}
            <div class="p-3 m-3 bg-base-100 border border-stone-900/10 rounded-lg">
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead class="bg-base-100">
                            <tr>
                                <th>s/n</th>
                                <th>Guest name</th>
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
                                <tr class="my-4">
                                    <th>{{ $counter }}</th>
                                    {{-- <td>{{ $guest->full_name }}</td> --}}
                                    <td scope="row" class="flex items-center px-6 py-4 whitespace-nowrap">
                                        <i class="fa fa-user rounded-full p-3 bg-blue-900/90 text-center text-white"></i>
                                        <div class="ps-3">
                                            <div class="font-semibold">{{ $guest->full_name }}</div>
                                            <div class="font-normal text-gray-500">{{ $guest->phone }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $guest->qrcode }}</td>
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
                                        @if ($guest->verified == 1)
                                            <div class="badge badge-soft badge-success">used</div>
                                        @else
                                            <div class="badge badge-soft badge-error">pending</div>
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
                                        <div class="modal-action">
                                            <form method="dialog">
                                                <!-- if there is a button in form, it will close the modal -->
                                                <button class="btn btn-outline btn-error rounded-full">
                                                    <i class="fa fa-xmark text-rose-700"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="divider">
                                            <i class="fa fa-object-ungroup"></i>
                                        </div>
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
            </div>
        </div>
        <div class="col-span-4">
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
@endsection
