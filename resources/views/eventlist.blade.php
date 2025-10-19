@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <x-error_show />
            <div class="rounded">
                <div class="card bg-base-100 mb-5 card-md shadow-lg">
                    <div class="card-body p-3">
                        <div class="justify-start card-actions">
                            <a href="{{ route('user.addevent') }}" class="btn btn-outline btn-primary">
                                Add Event
                                <i class="fa fa-circle-plus ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative bg-base-100 overflow-x-auto shadow-md rounded">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase">
                            <tr class="border border-stone-700/10">
                                <th scope="col" class="px-6 py-3">
                                    S/N
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Event Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Event Host
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Even Type
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Event Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Card
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Payment Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $idcounter = 1;
                            @endphp
                            @foreach ($events as $event)
                                <tr class="border border-stone-700/10 hover:bg-base-300"
                                    onclick="window.location='{{ route('user.eventview', ['id' => $event->id]) }}'">
                                    <td class="text-center">
                                        {{ $idcounter }}
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                        {{ $event->order_name }}
                                    </th>
                                    <td>
                                        {{ $event->event_host }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $event->event_type }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- {{ $guest->delivery_method }} --}}
                                        @if ($event->event_status == 'active')
                                            <div class="inline-grid *:[grid-area:1/1] mr-2">
                                                <div class="status status-info animate-ping"></div>
                                                <div class="status status-info"></div>
                                            </div> Active
                                        @elseif ($event->event_status == 'cancelled')
                                            <div class="status status-error mr-2"></div> cancelled
                                        @elseif ($event->event_status == 'completed')
                                            <div class="status status-success mr-2"></div> completed
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('j M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $event->guest_limit }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($event->payment_status == 'paid')
                                            <div class="badge badge-soft badge-success">paid</div>
                                        @elseif($event->payment_status == 'pending')
                                            <div class="badge badge-soft badge-info">Pending</div>
                                        @else
                                            <div class="badge badge-soft badge-error">Cancelled</div>
                                        @endif
                                    </td>
                                </tr>

                                @php
                                    $idcounter++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
