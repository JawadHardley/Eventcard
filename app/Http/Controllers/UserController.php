<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // User's events
        $userEvents = Event::where('user_id', $user->id)->get();
        $totalEvents = $userEvents->count();

        // User's guests (via their events)
        $eventIds = $userEvents->pluck('id');
        $totalGuests = Guest::whereIn('order_id', $eventIds)->count();
        $checkedIn = Guest::whereIn('order_id', $eventIds)->where('verified', true)->count();
        $pendingGuests = $totalGuests - $checkedIn;

        // Check-in rate
        $checkinRate = $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0;

        // Chart: check-ins per day for last 7 days (only user's events)
        $checkinsPerDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Guest::whereIn('order_id', $eventIds)
                ->whereDate('updated_at', $date)
                ->where('verified', true)
                ->count();
            $checkinsPerDay[] = $count;
        }

        // Recent events (latest 5)
        $recentEvents = Event::where('user_id', $user->id)->latest()->take(5)->get();

        // Top events by guest count
        $topEvents = Event::where('user_id', $user->id)
            ->withCount('guests')
            ->orderBy('guests_count', 'desc')
            ->take(5)
            ->get();

        // Recent guest check-ins (last 10)
        $recentCheckins = Guest::whereIn('order_id', $eventIds)
            ->where('verified', true)
            ->latest('updated_at')
            ->take(10)
            ->get();

        // Payment summary
        $pendingPaymentEvents = Event::where('user_id', $user->id)
            ->where('payment_status', 'pending')
            ->count();
        $paidEvents = Event::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->count();

        return view('dashboard', compact(
            'user',
            'totalEvents',
            'totalGuests',
            'checkedIn',
            'pendingGuests',
            'checkinRate',
            'checkinsPerDay',
            'recentEvents',
            'topEvents',
            'recentCheckins',
            'pendingPaymentEvents',
            'paidEvents'
        ));
    }

    public function cameralog($event, Request $request)
    {
        // find event by id
        $eventModel = Event::find($event);

        if (!$eventModel) {
            // not found -> 404 or you can customize
            abort(404, 'Event not found.');
        }

        // check ownership
        if ($eventModel->user_id != Auth::id()) {
            abort(403, 'Unauthorized — you do not own this event.');
        }

        return view('cameralog', [
            'user' => $request->user(),
            'event' => $eventModel,
        ]);
    }

    public function cardview(Request $request, $event, $guest)
    {
        // find event by id
        $eventModel = Event::find($event);
        // $guests = Guest::where('id', $guest->id)->first();
        $guests = Guest::find($guest);

        if (!$eventModel) {
            abort(404, 'Event not found.');
        }

        if (!$guests) {
            abort(404, 'Guest not found.');
        }

        // check ownership
        if ($eventModel->user_id != Auth::id()) {
            abort(403, 'Unauthorized — you do not own this event.');
        }

        return view('cardview', [
            'user' => $request->user(),
            'event' => $eventModel,
            'guest' => $guests,
        ]);
    }
}
