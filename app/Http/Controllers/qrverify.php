<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class qrverify extends Controller
{
    public function verify1(Request $request)
    {
        $code = $request->query('code');
        $event_id = $request->query('event_id');

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
        } else if ($eventx->id != $guest->order_id) {
            return response()->json(['status' => 'invalid', 'message' => 'QR not found']);
        }

        // Normal verification
        if ($guest->title == 'double' && $guest->counter == '[0/2]') {
            return response()->json([
                'status' => 'valid',
                'name' => $guest->full_name,
                'verified' => $guest->verified,
                'type' => $guest->title,
                'counter' => $guest->counter,
                'message' => 'Guest found'
            ]);
        } else if ($guest->title == 'double' && $guest->counter == '[1/2]') {
            return response()->json([
                'status' => 'valid',
                'name' => $guest->full_name,
                'verified' => 0,
                'type' => $guest->title,
                'counter' => $guest->counter,
                'message' => 'Guest found'
            ]);
        } else if ($guest->title == 'double' && $guest->counter == '[2/2]') {
            return response()->json([
                'status' => $guest->verified ? 'already_checked' : 'valid',
                'name' => $guest->full_name,
                'verified' => $guest->verified,
                'type' => $guest->title,
                'counter' => $guest->counter,
                'message' => 'Guest found'
            ]);
        } else if ($guest->title == 'single') {
            return response()->json([
                'status' => $guest->verified ? 'already_checked' : 'valid',
                'name' => $guest->full_name,
                'verified' => $guest->verified,
                'type' => $guest->title,
                'counter' => null,
                'message' => 'Guest found'
            ]);
        } else {
            return response()->json([
                'status' => $guest->verified ? 'already_checked' : 'valid',
                'name' => $guest->full_name,
                'verified' => $guest->verified,
                'type' => $guest->title,
                'counter' => null,
                'message' => 'Guest found'
            ]);
        }
    }

    public function markfield1(Request $request)
    {

        $code = $request->query('code');
        // If link or full URL scanned, extract the actual code  
        if (str_contains($code, '/')) {
            $code = basename(parse_url($code, PHP_URL_PATH));
        }
        $guest = Guest::where('qrcode', $code)->first();

        // If mark parameter is provided → mark guest as checked-in
        // if ($request->query('mark')) {
        //     if (!$guest->verified) {
        //         $guest->update(['verified' => 1]);
        //         return response()->json([
        //             'status' => 'checked_in',
        //             'name' => $guest->full_name,
        //             'verified' => true,
        //             'message' => 'Guest checked in successfully',
        //             'type' => $guest->title
        //         ]);
        //     } else {
        //         return response()->json([
        //             'status' => 'already_checked',
        //             'name' => $guest->full_name,
        //             'verified' => true,
        //             'message' => 'Guest already checked in',
        //             'type' => $guest->title
        //         ]);
        //     }
        // }

        if ($request->query('mark')) {
            if ($guest->title == 'double') {
                if ($guest->counter == '[0/2]') {
                    $guest->update(['verified' => 1]);
                    $guest->update(['counter' => '[1/2]']);
                    return response()->json([
                        'status' => 'checked_in',
                        'name' => $guest->full_name,
                        'counter' => '[1/2]',
                        'verified' => true,
                        'message' => 'Guest checked in successfully',
                        'type' => $guest->title
                    ]);
                } else if ($guest->counter == '[1/2]') {
                    $guest->update(['counter' => '[2/2]']);
                    return response()->json([
                        'status' => 'checked_in',
                        'name' => $guest->full_name,
                        'counter' => '[2/2]',
                        'verified' => true,
                        'message' => 'Guest checked in successfully',
                        'type' => $guest->title
                    ]);
                } else {
                    return response()->json([
                        'counter' => '[2/2]',
                        'status' => 'already_checked',
                        'name' => $guest->full_name,
                        'verified' => true,
                        'message' => 'Guest already checked in',
                        'type' => $guest->title
                    ]);
                }
            } else {
                if (!$guest->verified) {
                    $guest->update(['verified' => 1]);
                    return response()->json([
                        'status' => 'checked_in',
                        'name' => $guest->full_name,
                        'verified' => true,
                        'message' => 'Guest checked in successfully',
                        'type' => $guest->title,
                        'counter' => ''
                    ]);
                } else {
                    return response()->json([
                        'status' => 'already_checked',
                        'name' => $guest->full_name,
                        'verified' => true,
                        'message' => 'Guest already checked in',
                        'type' => $guest->title,
                        'counter' => ''
                    ]);
                }
            }
        }
    }

    public function verify(Request $request)
    {
        // accept code from multiple param names (QR or manual 4-digit)
        $code = $request->query('code')
            ?? $request->query('invitation_code')
            ?? $request->query('manual_code');

        $event_id = $request->query('event_id');

        if (empty($code) || empty($event_id)) {
            return response()->json(['status' => 'error', 'message' => 'Missing parameters'], 400);
        }

        // If link or full URL scanned, extract the actual code  
        if (str_contains($code, '/')) {
            $code = basename(parse_url($code, PHP_URL_PATH));
        }

        // find guest by qrcode OR possible invitation code fields (covering typo)
        $guest = Guest::where('qrcode', $code)
            ->orWhere('invitation_code', $code)
            ->first();

        if (!$guest) {
            return response()->json(['status' => 'invalid', 'message' => 'QR/Code not found'], 404);
        }

        $eventx = Event::find($event_id);
        if (!$eventx || $eventx->user_id != Auth::id() || $eventx->id != $guest->order_id) {
            return response()->json(['status' => 'invalid', 'message' => 'QR/Code not found'], 404);
        }

        // normalize response payload
        $payload = [
            'name' => $guest->full_name,
            'verified' => (bool)$guest->verified,
            'type' => $guest->title,
            'counter' => $guest->counter ?? null,
        ];

        if ($guest->title === 'double') {
            // return explicit states for double
            $payload['status'] = match ($guest->counter) {
                '[0/2]' => 'valid',
                '[1/2]' => 'valid',
                '[2/2]' => ($guest->verified ? 'already_checked' : 'valid'),
                default => ($guest->verified ? 'already_checked' : 'valid'),
            };
            return response()->json($payload);
        }

        // single or fallback
        $payload['status'] = $guest->verified ? 'already_checked' : 'valid';
        return response()->json($payload);
    }

    public function markfield(Request $request)
    {
        $code = $request->query('code')
            ?? $request->query('invitation_code')
            ?? $request->query('manual_code');

        if (empty($code) || !$request->query('mark')) {
            return response()->json(['status' => 'error', 'message' => 'Missing parameters'], 400);
        }

        if (str_contains($code, '/')) {
            $code = basename(parse_url($code, PHP_URL_PATH));
        }

        $guest = Guest::where('qrcode', $code)
            ->orWhere('invitation_code', $code)
            ->first();

        if (!$guest) {
            return response()->json(['status' => 'invalid', 'message' => 'QR/Code not found'], 404);
        }

        // double ticket flow
        if ($guest->title === 'double') {
            if ($guest->counter === '[0/2]') {
                $guest->update(['verified' => 1, 'counter' => '[1/2]']);
                return response()->json([
                    'status' => 'checked_in',
                    'name' => $guest->full_name,
                    'counter' => '[1/2]',
                    'verified' => true,
                    'type' => $guest->title
                ]);
            }

            if ($guest->counter === '[1/2]') {
                $guest->update(['counter' => '[2/2]', 'verified' => 1]);
                return response()->json([
                    'status' => 'checked_in',
                    'name' => $guest->full_name,
                    'counter' => '[2/2]',
                    'verified' => true,
                    'type' => $guest->title
                ]);
            }

            return response()->json([
                'status' => 'already_checked',
                'name' => $guest->full_name,
                'counter' => $guest->counter ?? '[2/2]',
                'verified' => true,
                'type' => $guest->title
            ]);
        }

        // single ticket flow
        if (!$guest->verified) {
            $guest->update(['verified' => 1]);
            return response()->json([
                'status' => 'checked_in',
                'name' => $guest->full_name,
                'verified' => true,
                'type' => $guest->title,
                'counter' => null
            ]);
        }

        return response()->json([
            'status' => 'already_checked',
            'name' => $guest->full_name,
            'verified' => true,
            'type' => $guest->title,
            'counter' => null
        ]);
    }
}
