@extends('layouts.admin')

@section('title', 'My Dashboard')

@section('content')
    <div class="fade-up">
        <!-- Welcome header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">My Dashboard</h1>
                <p class="page-subtitle">Welcome back, {{ $user->name }}. Here's your event overview.</p>
            </div>
            <div>
                <a href="{{ route('user.addevent') }}" class="btn btn-primary btn-sm">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                    New Event
                </a>
            </div>
        </div>

        <!-- Stats cards -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <div class="stat-card">
                <div class="stat-icon bg-blue-100 dark:bg-blue-900/20"><i
                        class="fa fa-calendar-alt text-blue-600 text-xl"></i></div>
                <div class="stat-value">{{ $totalEvents }}</div>
                <div class="stat-label">Total Events</div>
                <div class="stat-change up">
                    {{ App\Models\Event::where('user_id', $user->id)->whereMonth('created_at', \Carbon\Carbon::now()->month)->count() }}
                    this
                    month</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-green-100 dark:bg-green-900/20"><i class="fa fa-users text-green-600 text-xl"></i>
                </div>
                <div class="stat-value">{{ $totalGuests }}</div>
                <div class="stat-label">Total Guests</div>
                <div class="stat-change up">
                    {{ App\Models\Guest::whereIn('order_id', App\Models\Event::where('user_id', $user->id)->pluck('id'))->whereMonth('created_at', \Carbon\Carbon::now()->month)->count() }}
                    new</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-yellow-100 dark:bg-yellow-900/20"><i
                        class="fa fa-check-circle text-yellow-600 text-xl"></i></div>
                <div class="stat-value">{{ $checkedIn }}</div>
                <div class="stat-label">Checked In</div>
                <div class="stat-change up">{{ $checkinRate }}% rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-purple-100 dark:bg-purple-900/20"><i
                        class="fa fa-hourglass-half text-purple-600 text-xl"></i></div>
                <div class="stat-value">{{ $pendingGuests }}</div>
                <div class="stat-label">Pending</div>
                <div class="stat-change down">awaiting check-in</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-red-100 dark:bg-red-900/20"><i class="fa fa-credit-card text-red-600 text-xl"></i>
                </div>
                <div class="stat-value">{{ $paidEvents }}</div>
                <div class="stat-label">Paid Events</div>
                <div class="stat-change">{{ $pendingPaymentEvents }} pending</div>
            </div>
        </div>

        <!-- Charts row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="chart-card lg:col-span-2">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Your Guest Check-ins (Last 7 days)</div>
                        <div class="chart-subtitle">Daily attendance trend</div>
                    </div>
                </div>
                <canvas id="checkinsChart" height="200"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Top Events by Attendance</div>
                        <div class="chart-subtitle">Most popular among your events</div>
                    </div>
                </div>
                <div class="space-y-3 mt-2">
                    @foreach ($topEvents as $event)
                        <div>
                            <div class="flex justify-between text-sm"><span
                                    class="truncate">{{ $event->order_name }}</span><span>{{ $event->guests_count }}
                                    guests</span></div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                                <div class="bg-red-500 h-2 rounded-full"
                                    style="width: {{ min(100, ($event->guests_count / max($topEvents->first()->guests_count, 1)) * 100) }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($topEvents->isEmpty())
                        <div class="text-center text-gray-500 py-4">No events yet</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Events & Recent Check-ins -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
            <div class="card p-0 overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center">
                    <h3 class="font-semibold">Recent Events</h3>
                    <a href="{{ route('user.eventlist') }}" class="text-sm text-blue-600">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="aura-table min-w-full">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Date</th>
                                <th>Guests</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEvents as $event)
                                <tr onclick="window.location='{{ route('user.eventview', $event->id) }}'"
                                    style="cursor:pointer">
                                    <td class="font-medium">{{ $event->order_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                                    <td>{{ App\Models\Guest::where('order_id', $event->id)->count() }}/{{ $event->guest_limit ?? '∞' }}
                                    </td>
                                    <td><span
                                            class="badge {{ $event->event_status == 'active' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($event->event_status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-500">No events created yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card p-0 overflow-hidden">
                <div class="p-4 border-b">
                    <h3 class="font-semibold">Recent Check-ins</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentCheckins as $checkin)
                        <div class="p-3 flex justify-between items-center">
                            <div>
                                <div class="font-medium">{{ $checkin->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $checkin->phone }}</div>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-green">Checked in</span>
                                <div class="text-xs text-gray-400">{{ $checkin->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">No check-ins yet</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick actions -->
        <div class="card p-5">
            <h3 class="font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="{{ route('user.addevent') }}" class="qaction">
                    <div class="qaction-icon bg-blue-100 dark:bg-blue-900/20"><i
                            class="fa fa-plus text-blue-600 text-xl"></i></div>
                    <span class="qaction-label">Create Event</span>
                </a>
                <a href="{{ route('user.guestlist') }}" class="qaction">
                    <div class="qaction-icon bg-green-100 dark:bg-green-900/20"><i
                            class="fa fa-user-plus text-green-600 text-xl"></i></div>
                    <span class="qaction-label">Add Guest</span>
                </a>
                <a href="{{ route('user.eventlist') }}" class="qaction">
                    <div class="qaction-icon bg-purple-100 dark:bg-purple-900/20"><i
                            class="fa fa-list text-purple-600 text-xl"></i></div>
                    <span class="qaction-label">View Events</span>
                </a>
                <a href="{{ route('admin.transactions') }}" class="qaction">
                    <div class="qaction-icon bg-yellow-100 dark:bg-yellow-900/20"><i
                            class="fa fa-chart-line text-yellow-600 text-xl"></i></div>
                    <span class="qaction-label">Billing</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('checkinsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['6 days ago', '5 days', '4 days', '3 days', '2 days', 'Yesterday', 'Today'],
                    datasets: [{
                        label: 'Check-ins',
                        data: @json($checkinsPerDay),
                        borderColor: '#e8120a',
                        backgroundColor: 'rgba(232,18,10,0.05)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#e8120a'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
