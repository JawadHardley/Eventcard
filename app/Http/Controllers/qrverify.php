<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class qrverify extends Controller
{
    public function verify(Request $request)
    {
        $code = $request->query('code');
        $event_id = $request->query('event_id')

        if (!$code) {
            return response()->json(['status' => 'error', 'message' => 'No QR code provided']);
        }

        // If link or full URL scanned, extract the actual code
        if (str_contains($code, '/')) {
            $code = basename(parse_url($code, PHP_URL_PATH));
        }

        $guest = Guest::where('qrcode', $code)->first();

        if (!$guest) {
            return response()->json(['status' => 'invalid', 'message' => 'QR not found']);
        }

        $eventx = Event::where('id', $event_id)->first();

        if (!$eventx) {
            return response()->json(['status' => 'invalid', 'message' => 'QR not found']);
        }

        // verify the event belongs to the logged in user
        if ($eventx->user_id != Auth::id()) {
            return response()->json(['status' => 'invalid', 'message' => 'QR not found']);
        }


        // If mark parameter is provided → mark guest as checked-in
        if ($request->query('mark')) {
            if (!$guest->verified) {
                $guest->update(['verified' => 1]);
                return response()->json([
                    'status' => 'checked_in',
                    'name' => $guest->full_name,
                    'verified' => true,
                    'message' => 'Guest checked in successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'already_checked',
                    'name' => $guest->full_name,
                    'verified' => true,
                    'message' => 'Guest already checked in'
                ]);
            }
        }

        // Normal verification
        return response()->json([
            'status' => $guest->verified ? 'already_checked' : 'valid',
            'name' => $guest->full_name,
            'verified' => $guest->verified,
            'message' => 'Guest found'
        ]);
    }
}