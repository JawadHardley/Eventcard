<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\GuestCheckIn;
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
        $guestRecords = Guest::whereIn('order_id', $eventIds)
            ->get(['order_id', 'title', 'verified', 'counter']);
        $totalGuests = $guestRecords->count();
        $usedGuestRecords = $guestRecords->filter(
            fn($guest) =>
            $guest->verified || in_array($guest->counter, ['[1/2]', '[2/2]'], true)
        );
        $checkedIn = $usedGuestRecords->count();
        $pendingGuests = $totalGuests - $checkedIn;
        $guestCardsByEvent = $guestRecords->countBy('order_id');
        $usedCardsByEvent = $usedGuestRecords->countBy('order_id');

        // A double card represents two possible attendees, not one guest record.
        $expectedAttendees = $guestRecords->sum(fn($guest) => $guest->title === 'double' ? 2 : 1);
        $peopleAttended = $guestRecords->sum(function ($guest) {
            if ($guest->title === 'double') {
                return match ($guest->counter) {
                    '[2/2]' => 2,
                    '[1/2]' => 1,
                    default => $guest->verified ? 1 : 0,
                };
            }

            return $guest->verified ? 1 : 0;
        });

        $remainingSeats = max(0, $expectedAttendees - $peopleAttended);
        $checkinRate = $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0;
        $peopleAttendanceRate = $expectedAttendees > 0
            ? round(($peopleAttended / $expectedAttendees) * 100)
            : 0;

        // Chart: check-ins per day for last 7 days (only user's events)
        $checkinsPerDay = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = GuestCheckIn::whereIn('event_id', $eventIds)
                ->whereDate('created_at', $date)
                ->count();
            $checkinsPerDay[] = $count;
        }

        // Recent events (latest 5)
        $recentEvents = Event::where('user_id', $user->id)->latest()->take(5)->get();

        // Top events by people admitted, not by guest-card records.
        $attendeesByEvent = GuestCheckIn::whereIn('event_id', $eventIds)
            ->selectRaw('event_id, COUNT(*) as attendees_count')
            ->groupBy('event_id')
            ->pluck('attendees_count', 'event_id');

        $recentEvents->each(function ($event) use ($guestCardsByEvent, $usedCardsByEvent, $attendeesByEvent) {
            $event->guest_cards_count = (int) ($guestCardsByEvent[$event->id] ?? 0);
            $event->cards_used_count = (int) ($usedCardsByEvent[$event->id] ?? 0);
            $event->attendees_count = (int) ($attendeesByEvent[$event->id] ?? 0);
        });

        $topEvents = Event::where('user_id', $user->id)
            ->get()
            ->each(fn($event) => $event->attendees_count = (int) ($attendeesByEvent[$event->id] ?? 0))
            ->sortByDesc('attendees_count')
            ->take(5)
            ->values();

        // Recent individual attendee check-ins (a double card can appear twice).
        $recentCheckins = GuestCheckIn::with('guest')
            ->whereIn('event_id', $eventIds)
            ->latest('created_at')
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
            'peopleAttended',
            'expectedAttendees',
            'remainingSeats',
            'pendingGuests',
            'checkinRate',
            'peopleAttendanceRate',
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
