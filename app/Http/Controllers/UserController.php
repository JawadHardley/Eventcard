<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
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

    public function cameralog(Request $request)
    {
        return view('cameralog', [
            'user' => $request->user(),
        ]);
    }

    public function guestlist(Request $request)
    {
        // Fetch all guests, optionally filter by logged-in user’s orders
        $guests = Guest::all();

        return view('guestlist', [
            'user' => $request->user(),
            'guests' => $guests,
        ]);
    }

    // Handle guest registration
    // public function guestadd(Request $request)
    // {
    //     $validated = $request->validate([
    //         'full_name' => [
    //             'required',
    //             'string',
    //             'max:100',
    //             'regex:/^[A-Za-z\s\-\'\.]+$/', // only letters, spaces, hyphens, apostrophes, dots
    //         ],
    //         'title' => ['required', 'string', 'max:900'],
    //         'address' => ['required', 'string', 'max:900'],
    //         'delivery_method' => ['required', 'in:sms,email,whatsapp'],
    //         'email' => ['required', 'email'],
    //         'phone' => [
    //             'required',
    //             'string',
    //             'regex:/^(\+?255|0)[0-9]{9}$/', // +255XXXXXXXXX or 07XXXXXXXX
    //         ],
    //     ]);

    //     // Clean & format before saving
    //     $cleanPhone = $this->normalizePhone($validated['phone']);

    //     // dd($cleanPhone);

    //     // Format the full_name to Title Case
    //     $validated['full_name'] = Str::title(strtolower($validated['full_name']));

    //     $guest = Guest::create([
    //         'full_name' => $validated['full_name'],
    //         'title' => $validated['title'] ?? null,
    //         'email' => $validated['email'] ?? null,
    //         'phone' => $cleanPhone,
    //         'address' => $validated['address'] ?? null,
    //         'delivery_method' => $validated['delivery_method'],
    //         'order_id' => 1, // or however you handle this
    //     ]);

    //     // Generate unique code
    //     $code = 'GUEST-' . strtoupper(Str::random(10));
    //     $link = url('/guest/' . $code);
    //     // $guest->update(['qrcode' => $code]);
    //     $guest->update([
    //         'qrcode' => $code,
    //         'more' => $link,
    //     ]);

    //     // Generate and store QR
    //     // $qrImage = QrCode::format('png')->size(300)->generate($code);
    //     $qrImage = QrCode::format('svg')->size(300)->generate($link);
    //     // Storage::put("public/qrcodes/{$guest->id}.png", $qrImage);

    //     return redirect()
    //         ->route('user.guestlist')
    //         ->with([
    //             'status' => 'success',
    //             'message' => 'Registered Guest successfully.',
    //         ]);
    // }

    public function guestadd(Request $request)
    {
        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-z\s\-\'\.]+$/',
            ],
            'title' => ['required', 'string', 'max:900'],
            'address' => ['required', 'string', 'max:900'],
            'delivery_method' => ['required', 'in:sms,email,whatsapp'],
            'email' => ['required', 'email'],
            'phone' => [
                'required',
                'string',
                'regex:/^(\+?255|0)[0-9]{9}$/',
            ],
        ]);

        $cleanPhone = $this->normalizePhone($validated['phone']);
        $validated['full_name'] = Str::title(strtolower($validated['full_name']));

        $guest = Guest::create([
            'full_name' => $validated['full_name'],
            'title' => $validated['title'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $cleanPhone,
            'address' => $validated['address'] ?? null,
            'delivery_method' => $validated['delivery_method'],
            'order_id' => 1,
        ]);

        // Generate unique code
        $code = 'GUEST-' . strtoupper(Str::random(10));

        // 🔥 Build the public URL for that guest
        $publicUrl = url('/guest/' . $code);

        // Update guest record with both code and link
        $guest->update([
            'qrcode' => $code,
            'more' => $publicUrl,
        ]);

        // ✅ Generate QR code based on the URL, not the random code
        $qrImage = QrCode::format('svg')
            ->size(300)
            ->generate($publicUrl);

        // Optional: Save if you want (not required)
        // Storage::put("public/qrcodes/{$guest->id}.svg", $qrImage);

        return redirect()
            ->route('user.guestlist')
            ->with([
                'status' => 'success',
                'message' => 'Registered Guest successfully.',
            ]);
    }


    function normalizePhone(string $input): string
    {
        // 1️⃣ Remove spaces, hyphens, parentheses, dots
        $clean = preg_replace('/[\s\-\(\)\.]/', '', $input);

        // 2️⃣ Remove leading '00' (some people write 00255 instead of +255)
        $clean = preg_replace('/^00/', '', $clean);

        // 3️⃣ If starts with +, remove it
        $clean = preg_replace('/^\+/', '', $clean);

        // 4️⃣ Handle cases

        // Case A: starts with 0 → keep as local number (07XXXXXXXX)
        if (Str::startsWith($clean, '0')) {
            return $clean; // ✅ stays local format
        }

        // Case B: starts with country code (like 255, 254, 1, 44, 91, etc.)
        // Usually country codes don’t start with 0 and have 1–3 digits
        if (preg_match('/^(1|2|3|4|5|6|7|8|9)\d{6,14}$/', $clean)) {
            return $clean; // ✅ already international
        }

        // Case C: missing leading 0 but clearly local digits (like "712345678")
        if (preg_match('/^[1-9]\d{8}$/', $clean)) {
            return '0' . $clean; // ✅ convert to 07XXXXXXXX
        }

        // Case D: fallback – just return cleaned digits
        return $clean;
    }
}
