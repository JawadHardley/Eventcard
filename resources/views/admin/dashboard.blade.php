@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="fade-up">
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div>
                <button class="btn btn-primary btn-sm" onclick="location.href='{{ route('user.addevent') }}'">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                    New Event
                </button>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="stat-card">
                <div class="stat-icon bg-blue-100 dark:bg-blue-900/20">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" stroke="#0e84e8"
                            stroke-width="1.8" />
                    </svg>
                </div>
                <div class="stat-value">{{ $totalEvents }}</div>
                <div class="stat-label">Total Events</div>
                <div class="stat-change up">+12%</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-green-100 dark:bg-green-900/20">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#34c759" stroke-width="1.8" />
                        <circle cx="9" cy="7" r="4" stroke="#34c759" stroke-width="1.8" />
                    </svg>
                </div>
                <div class="stat-value">{{ $totalGuests }}</div>
                <div class="stat-label">Total Guests</div>
                <div class="stat-change up">+8%</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-yellow-100 dark:bg-yellow-900/20">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <ellipse cx="12" cy="5" rx="9" ry="3" stroke="#ff9500"
                            stroke-width="1.8" />
                        <path d="M3 5v14c0 1.657 4.03 3 9 3s9-1.343 9-3V5" stroke="#ff9500" stroke-width="1.8" />
                        <path d="M3 12c0 1.657 4.03 3 9 3s9-1.343 9-3" stroke="#ff9500" stroke-width="1.8" />
                    </svg>
                </div>
                <div class="stat-value">{{ round(($checkedIn / max($totalGuests, 1)) * 100) }}%</div>
                <div class="stat-label">Check-in Rate</div>
                <div class="stat-change up">+5%</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-purple-100 dark:bg-purple-900/20">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <path d="M3 17l6-6 4 4 8-8" stroke="#5e5ce6" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="stat-value">${{ number_format($revenue) }}</div>
                <div class="stat-label">Revenue</div>
                <div class="stat-change up">+22%</div>
            </div>
        </div>

        <!-- Charts row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="chart-card lg:col-span-2">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Guest Check-ins</div>
                        <div class="chart-subtitle">Last 7 days</div>
                    </div>
                </div>
                <canvas id="uploadsChart" height="200"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <div class="chart-title">Event Types</div>
                        <div class="chart-subtitle">Distribution</div>
                    </div>
                </div>
                <canvas id="storageChart" height="180"></canvas>
            </div>
        </div>

        <!-- Recent events table -->
        <div class="card" style="padding:0; overflow:hidden;">
            <div class="p-4 border-b flex justify-between items-center">
                <div class="section-title">Recent Events</div>
                <a href="{{ route('user.eventlist') }}" class="btn btn-ghost btn-xs">View all</a>
            </div>
            <div class="table-container">
                <table class="aura-table">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Guests</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            use App\Models\Event;
                        $recentEvents = Event::latest()->take(5)->get(); @endphp
                        @foreach ($recentEvents as $event)
                            <tr onclick="window.location='{{ route('user.eventview', $event->id) }}'"
                                style="cursor:pointer;">
                                <td>{{ $event->guests->count() }}</td>
                                <td>{{ $event->guest_limit ?? '∞' }}</td>
                                <td><span
                                        class="badge {{ $event->event_status == 'active' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($event->event_status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.initDashboardCharts === 'function') {
                    window.initDashboardCharts();
                }
            });
        </script>
    @endsection
