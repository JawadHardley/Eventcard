<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class qrverify extends Controller
{
    public function verify(Request $request)
    {
        $code = $request->query('code');

        if (!$code) return response()->json(['success' => false, 'message' => 'No QR code provided']);
        if (str_contains($code, '/')) {
            $code = basename(parse_url($code, PHP_URL_PATH));
        }

        $guest = Guest::where('qrcode', $code)->first();

        if (!$guest) return response()->json(['success' => false, 'message' => 'QR not found']);

        // Mark attended if requested
        if ($request->query('mark')) {
            $guest->update(['verified' => true]);
        }

        return response()->json([
            'success' => true,
            'name' => $guest->full_name,
            'verified' => $guest->verified,
            'message' => 'Guest found!'
        ]);
    }
}
