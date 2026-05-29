@extends('layouts.admin')
@section('title', 'Events')
@section('content')
    <div class="fade-up">
        <div class="page-header">
            <div>
                <h1 class="page-title">Events</h1>
                <p class="page-subtitle">Manage all your events</p>
            </div>
            <a href="{{ route('user.addevent') }}" class="btn btn-primary btn-sm">+ New Event</a>
        </div>

        <div class="card" style="padding:0; overflow:hidden;">
            <div class="table-container">
                <table class="aura-table">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Event Name</th>
                            <th>Host</th>
                            <th>Date</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $index => $event)
                            <tr onclick="window.location='{{ route('user.eventview', $event->id) }}'"
                                style="cursor:pointer;">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $event->order_name }}</td>
                                <td>{{ $event->event_host }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                                <td>{{ \App\Models\Guest::where('order_id', $event->id)->count() }}/{{ $event->guest_limit ?? '-' }}
                                </td>
                                <td><span
                                        class="badge {{ $event->event_status == 'active' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($event->event_status) }}</span>
                                </td>
                                <td><span
                                        class="badge {{ $event->payment_status == 'paid' ? 'badge-blue' : 'badge-yellow' }}">{{ ucfirst($event->payment_status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
