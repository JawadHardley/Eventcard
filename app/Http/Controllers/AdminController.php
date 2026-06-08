<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Guest;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function dashboardx(Request $request)
    {
        return view('admin.dashboard', [
            'user' => $request->user(),
        ]);
    }

    public function transactions(Request $request)
    {
        return view('admin.transactions', [
            'user' => $request->user(),
        ]);
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Total stats
        $totalEvents = Event::count();
        $totalGuests = Guest::count();
        $checkedIn = Guest::where('verified', true)->count();
        $pendingGuests = $totalGuests - $checkedIn;

        // Revenue (example: assume each guest card costs 1500 Tsh, but only for paid events)
        $paidEvents = Event::where('payment_status', 'paid')->get();
        $revenue = 0;
        foreach ($paidEvents as $event) {
            $guestCount = Guest::where('order_id', $event->id)->count();
            $revenue += $guestCount * 1500; // adjust pricing logic
        }

        // Chart data: check-ins per day for last 7 days
        $checkinsPerDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Guest::whereDate('updated_at', $date)->where('verified', true)->count();
            $checkinsPerDay[] = $count;
        }

        // Recent events (latest 5)
        $recentEvents = Event::latest()->take(5)->get();

        // Top events by guest count
        $topEvents = Event::withCount('guests')->orderBy('guests_count', 'desc')->take(5)->get();

        // Recent guest check-ins (last 10)
        $recentCheckins = Guest::where('verified', true)->latest('updated_at')->take(10)->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'totalGuests',
            'checkedIn',
            'pendingGuests',
            'revenue',
            'checkinsPerDay',
            'recentEvents',
            'topEvents',
            'recentCheckins',
            'user'
        ));
    }
}
