<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Event;
use App\Imports\GuestImport;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use AfricasTalking\SDK\AfricasTalking;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuestController extends Controller
{
    public function showpublic($code)
    {
        // Find the guest by their QR code
        $guest = Guest::where('qrcode', $code)->first();

        if (!$guest) {
            // If code is invalid or not found
            return view('guestcard.notguestcard'); // fallback view
        }

        // Load the event related to this guest
        $event = Event::find($guest->order_id);

        if (!$event) {
            // Optional: handle if event not found
            return view('guestcard.notguestcard')->with('message', 'Event not found.');
        }

        // Pass both guest and event data to the view
        return view('guestcard.guestcard', [
            'guest' => $guest,
            'event' => $event, // now you have all event fields
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

    // public function guestadd(Request $request)
    // {
    //     $validated = $request->validate([
    //         'full_name' => [
    //             'required',
    //             'string',
    //             'max:100',
    //             'regex:/^[A-Za-z\s\-\'\.]+$/',
    //         ],
    //         'title' => ['required', 'string', 'max:900'],
    //         'event_id' => ['required', 'numeric', 'max:900'],
    //         'address' => ['required', 'string', 'max:900'],
    //         'delivery_method' => ['required', 'in:sms,email,whatsapp'],
    //         'email' => ['required', 'email'],
    //         'phone' => [
    //             'required',
    //             'string',
    //             'regex:/^(\+?255|0)[0-9]{9}$/',
    //         ],
    //     ]);

    //     $cleanPhone = $this->normalizePhone($validated['phone']);
    //     $validated['full_name'] = Str::title(strtolower($validated['full_name']));

    //     // Generate unique 4-digit short code for this event
    //     $eventId = $validated['event_id'];
    //     do {
    //         $shortCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    //         $exists = Guest::where('order_id', $eventId)
    //             ->where('invitation_code', $shortCode)
    //             ->exists();
    //     } while ($exists);

    //     $guest = Guest::create([
    //         'full_name' => $validated['full_name'],
    //         'title' => $validated['title'] ?? null,
    //         'email' => $validated['email'] ?? null,
    //         'phone' => $cleanPhone,
    //         'address' => $validated['address'] ?? null,
    //         'delivery_method' => $validated['delivery_method'],
    //         'order_id' => $validated['event_id'],
    //         'counter' => '[0/2]',
    //         'invitation_code' => $shortCode,
    //     ]);


    //     // Generate unique code
    //     $code = 'GUEST-' . strtoupper(Str::random(10));

    //     // 🔥 Build the public URL for that guest
    //     $publicUrl = url('/guest/' . $code);

    //     // Update guest record with both code and link
    //     $guest->update([
    //         'qrcode' => $code,
    //         'more' => $publicUrl,
    //     ]);

    //     // ✅ Generate QR code based on the URL, not the random code
    //     $qrImage = QrCode::format('svg')
    //         ->size(300)
    //         ->generate($publicUrl);

    //     // Optional: Save if you want (not required)
    //     // Storage::put("public/qrcodes/{$guest->id}.svg", $qrImage);

    //     return redirect()
    //         ->back()->with([
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
            ],
            'title' => ['required', 'string', 'max:900'],
            'event_id' => ['required', 'numeric', 'max:900'],
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
        $eventId = $validated['event_id'];

        // ✅ Prevent same number registering twice in same event
        $exists = Guest::where('order_id', $eventId)
            ->where('phone', $cleanPhone)
            ->exists();

        if ($exists) {
            return back()->with([
                'status' => 'error',
                'message' => 'Guest already registered for this event.',
            ]);
        }

        DB::beginTransaction();

        try {
            // ✅ generate unique short code per event
            for ($i = 0; $i < 5; $i++) {
                $shortCode = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

                if (!Guest::where('order_id', $eventId)->where('invitation_code', $shortCode)->exists()) {
                    break;
                }
            }

            // ✅ generate guaranteed unique QR code
            do {
                $code = 'GUEST-' . strtoupper(Str::random(10));
            } while (Guest::where('qrcode', $code)->exists());

            $publicUrl = url('/guest/' . $code);

            $guest = Guest::create([
                'full_name' => $validated['full_name'],
                'title' => $validated['title'],
                'email' => $validated['email'],
                'phone' => $cleanPhone,
                'address' => $validated['address'],
                'delivery_method' => $validated['delivery_method'],
                'order_id' => $validated['event_id'],
                'counter' => '[0/2]',
                'invitation_code' => $shortCode,
                'qrcode' => $code,
                'more' => $publicUrl,
            ]);

            DB::commit();

            // ✅ generate QR SVG
            $qrImage = QrCode::format('svg')
                ->size(300)
                ->generate($publicUrl);

            return back()->with([
                'status' => 'success',
                'message' => 'Guest registered successfully.',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
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

    public function guestupdate(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);

        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],
            'title' => ['required', 'string', 'max:900'],
            'event_id' => ['required', 'numeric', 'max:900'],
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

        $guest->update([
            'full_name' => $validated['full_name'],
            'title' => $validated['title'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $cleanPhone,
            'address' => $validated['address'] ?? null,
            'delivery_method' => $validated['delivery_method'],
            'order_id' => $validated['event_id'],
        ]);

        return redirect()
            ->back()->with([
                'status' => 'success',
                'message' => 'Guest updated successfully!',
            ]);
    }

    public function testSms()
    {
        $username   = "eventcards";
        $apiKey     = "atsk_6828b786a46709868d8d49d106e07ad1287e6646b6e172f07284bc1ba4572fbfcfcabee0";

        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();

        $recipients = "+255778515202"; // your phone number
        $message    = "Sendoff SMS test message from EventCard App.";
        $from       = "AFRICASTALKING";    // your approved senderId

        try {
            $result = $sms->send([
                'to'      => $recipients,
                'message' => $message,
                'from'    => $from
            ]);

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // public function testSms()
    // {
    //     $username   = "sandbox";
    //     $apiKey     = "atsk_cefff8c1e236e0df3dce2fe07271ccdbab83f4cc9c6a755174b48dd36195f87c74bbf70a";

    //     $AT  = new AfricasTalking($username, $apiKey, 'sandbox');
    //     $sms = $AT->sms();

    //     $recipients = "+255778515202"; // sandbox test number
    //     $message    = "Sendoff SMS test message from EventCard App.";
    //     $from       = "AFRICASTALKING"; // default sandbox sender

    //     try {
    //         $result = $sms->send([
    //             'to'      => $recipients,
    //             'message' => $message,
    //             'from'    => $from
    //         ]);

    //         return response()->json($result);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    public function generateCardImage($events, $guests, Request $request)
    {
        // find event by id 
        $event = Event::find($events);
        $guest = Guest::where('id', $guests)->first();

        $html = view('cardview', compact('event', 'guest'))->render();

        $fileName = 'event-card-' . time() . '.png';
        $path = storage_path('app/public/cards/' . $fileName);

        $dir = storage_path('app/public/cards');

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $remote = env('BROWSERLESS_URL');

        Browsershot::html($html)
            ->setRemoteInstance($remote) // 👈 THIS forces cloud chromium
            ->windowSize(650, 1000)
            ->deviceScaleFactor(2)
            ->waitUntilNetworkIdle()
            ->select('#idcard')
            ->timeout(60)
            ->setDelay(300)
            ->noSandbox() 
            ->save($path);

        return response()->download($path, $fileName);
    }

    public function importGuests(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:20480',
            'event_id' => 'required|numeric',
        ]);

        $requiredHeaders = [
            's/n',
            'full name',
            'card type',
            'method',
            'phone',
            'email',
            'address',
        ];

        try {
            // Read raw Excel to array
            $rows = Excel::toArray([], $request->file('file'))[0];

            if (empty($rows) || count($rows) < 2) {
                return back()->withErrors(['file' => 'Excel file is empty or missing data.']);
            }

            // Extract headers from first row
            $headers = array_map('trim', $rows[0]);

            // Map headers to lowercase for comparison
            $headersLower = array_map('strtolower', $headers);

            // Check all required columns exist
            foreach ($requiredHeaders as $header) {
                if (!in_array($header, $headersLower)) {
                    throw new \Exception("Missing required column: $header");
                }
            }

            // Slice out data rows
            $dataRows = array_slice($rows, 1);

            // Filter out completely empty rows and reindex
            $dataRows = array_values(array_filter($dataRows, function ($row) {
                return array_filter($row, fn($val) => trim($val) !== '');
            }));

            $usedPhones = [];
            $emptyRowCount = 0;

            foreach ($dataRows as $rowIndex => $row) {
                // Stop if 2 empty rows in a row
                if (!array_filter($row, fn($val) => trim($val) !== '')) {
                    $emptyRowCount++;
                    if ($emptyRowCount >= 2) break;
                    continue;
                }
                $emptyRowCount = 0;

                // Combine headers with row
                $rowAssoc = array_combine($headersLower, $row);

                // Normalize data
                $fullName = Str::title(strtolower(trim($rowAssoc['full name'])));
                $phone = strtolower(trim($rowAssoc['phone'] ?? ''));
                $method = strtolower(trim($rowAssoc['method'] ?? ''));
                $email = strtolower(trim($rowAssoc['email'] ?? ''));
                $address = strtolower(trim($rowAssoc['address'] ?? ''));
                $cardType = strtolower(trim($rowAssoc['card type'] ?? ''));

                if (!$fullName || !$phone || !$method) {
                    continue; // skip invalid row
                }

                // Check duplicates in Excel
                if (in_array($phone, $usedPhones)) {
                    throw new \Exception("Duplicate phone found in Excel: $phone (row " . ($rowIndex + 2) . ")");
                }
                $usedPhones[] = $phone;

                // Normalize phone using your controller method
                $cleanPhone = $this->normalizePhone($phone);

                // Generate unique 4-digit code per event
                do {
                    $shortCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                    $exists = Guest::where('order_id', $request->event_id)
                        ->where('invitation_code', $shortCode)
                        ->exists();
                } while ($exists);

                // Create guest
                $guest = Guest::create([
                    'full_name' => $fullName,
                    'title' => strtolower($cardType),
                    'email' => $email ?: null,
                    'phone' => $cleanPhone,
                    'address' => $address ?: null,
                    'delivery_method' => $method,
                    'order_id' => $request->event_id,
                    'counter' => '[0/2]',
                    'invitation_code' => $shortCode,
                ]);

                // Generate public guest code & URL
                $code = 'GUEST-' . strtoupper(Str::random(10));
                $publicUrl = url('/guest/' . $code);

                // Update guest record
                $guest->update([
                    'qrcode' => $code,
                    'more' => $publicUrl,
                ]);

                // Generate QR code SVG (optional storage)
                QrCode::format('svg')->size(300)->generate($publicUrl);
            }

            return back()->with('status', 'success')->with('message', 'Guests imported successfully 🎉');
        } catch (\Exception $e) {
            return back()->with('status', 'invalid')->with('message', $e->getMessage());
        }
    }
}
