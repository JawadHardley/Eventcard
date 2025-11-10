<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('dashboard', [
            'user' => $request->user(),
        ]);
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
        $guests = Guest::where('id', $guest->id)->first();

        if (!$eventModel) {
            // not found -> 404 or you can customize
            abort(404, 'Event not found.');
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
