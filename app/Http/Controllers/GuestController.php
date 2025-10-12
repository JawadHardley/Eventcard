<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class GuestController extends Controller
{
    public function showpublic($code)
    {
        // Find the guest by their QR code
        $guest = Guest::where('qrcode', $code)->first();

        if (!$guest) {
            // If code is invalid or not found
            return view('guestcard.notguestcard'); // we’ll create this view too
        }

        // If guest found, pass data to the view
        return view('guestcard.guestcard', [
            'guest' => $guest,
            'order' => $guest->order_id, // order = event details
        ]);
    }
}
