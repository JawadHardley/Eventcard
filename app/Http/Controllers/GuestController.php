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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;

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
        $guests = Guest::whereHas('event', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->get();

        return view('guestlist', [
            'user' => $request->user(),
            'guests' => $guests,
        ]);
    }

    public function guestQr($id)
    {
        $guest = Guest::findOrFail($id);

        $link = url("/guest/" . $guest->code);

        $qr_svg = QrCode::size(200)->generate($link);

        return response()->json([
            'qr_svg' => $qr_svg,
            'link' => $link
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
            'address' => ['nullable', 'string', 'max:900'],
            'delivery_method' => ['required', 'in:sms,email,whatsapp'],
            'email' => ['nullable', 'email'],
            'phone' => [
                'required',
                'string',
                'max:40',
                'regex:/^\+?[0-9\s().-]{7,39}$/',
            ],
        ]);

        $cleanPhone = $this->normalizePhone($validated['phone']);
        if (! preg_match('/^\+[1-9]\d{7,14}$/', $cleanPhone)) {
            return back()->withErrors(['phone' => 'Enter a valid international phone number.'])->withInput();
        }

        $validated['full_name'] = Str::title(strtolower($validated['full_name']));
        $eventId = $validated['event_id'];
        // dd($cleanPhone);


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
                'counter' => $validated['title'] === 'single' ? '[0/1]' : '[0/2]',
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
        $clean = preg_replace('/[^+0-9]/', '', trim($input)) ?? '';
        $hasInternationalPrefix = str_starts_with($clean, '+') || str_starts_with($clean, '00');
        $digits = preg_replace('/\D/', '', $clean) ?? '';

        if (str_starts_with($clean, '00')) {
            $digits = substr($digits, 2);
            $hasInternationalPrefix = true;
        }

        // Keep legacy local Tanzanian numbers working; international numbers
        // submitted by the country-aware input already include a country code.
        if (! $hasInternationalPrefix && str_starts_with($digits, '0')) {
            $digits = '255' . substr($digits, 1);
        } elseif (! $hasInternationalPrefix && strlen($digits) === 9) {
            $digits = '255' . $digits;
        }

        return '+' . $digits;
    }

    public function guestupdatexx(Request $request, $id)
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
            'address' => ['nullable', 'string', 'max:900'],
            'delivery_method' => ['required', 'in:sms,email,whatsapp'],
            'email' => ['nullable', 'email'],
            'phone' => [
                'required',
                'string',
                'max:40',
                'regex:/^\+?[0-9\s().-]{7,39}$/',
            ],
        ]);

        $cleanPhone = $this->normalizePhone($validated['phone']);
        if (! preg_match('/^\+[1-9]\d{7,14}$/', $cleanPhone)) {
            return back()->withErrors(['phone' => 'Enter a valid international phone number.'])->withInput();
        }

        // Prevent duplicate phone for the SAME event, excluding this guest
        $exists = Guest::where('order_id', $validated['event_id'])
            ->where('phone', $cleanPhone)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->with([
                'status' => 'error',
                'message' => 'Another guest already uses this phone number for this event.'
            ]);
        }

        // Attendance is controlled by the check-in flow, not guest edits.
        // Keep the ticket type fixed after any check-in so its status cannot be
        // reinterpreted by changing between single and double tickets.
        $hasAttendanceProgress = (bool) $guest->verified
            || in_array($guest->counter, ['[1/2]', '[2/2]'], true);

        $changes = [
            'full_name' => Str::title(strtolower($validated['full_name'])),
            'email' => $validated['email'],
            'phone' => $cleanPhone,
            'address' => $validated['address'] ?? null,
            'delivery_method' => $validated['delivery_method'],
        ];

        if ($hasAttendanceProgress) {
            $changes['title'] = $guest->title;
        } else {
            $changes['title'] = $validated['title'];
            if ($changes['title'] !== $guest->title) {
                $changes['counter'] = $changes['title'] === 'single' ? '[0/1]' : '[0/2]';
            }
        }

        $guest->update($changes);

        return back()->with([
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

    // public function generateCardImage($events, $guests, Request $request)
    // {
    //     // find event by id 
    //     $event = Event::find($events);
    //     $guest = Guest::where('id', $guests)->first();

    //     $html = view('cardview', compact('event', 'guest'))->render();

    //     $fileName = 'event-card-' . time() . '.png';
    //     $path = storage_path('app/public/cards/' . $fileName);

    //     $dir = storage_path('app/public/cards');

    //     if (!file_exists($dir)) {
    //         mkdir($dir, 0755, true);
    //     }

    //     $remote = env('BROWSERLESS_URL');

    //     Browsershot::html($html)
    //         ->setRemoteInstance($remote) // 👈 THIS forces cloud chromium
    //         ->windowSize(650, 1000)
    //         ->deviceScaleFactor(2)
    //         ->waitUntilNetworkIdle()
    //         ->select('#idcard')
    //         ->timeout(60)
    //         ->setDelay(300)
    //         ->noSandbox()
    //         ->save($path);

    //     return response()->download($path, $fileName);
    // }

    public function generateCardImage($eventId, $guestId, Request $request)
    {
        try {
            $event = Event::findOrFail($eventId);
            $guest = Guest::findOrFail($guestId);

            $this->ensureCardOwnership($event, $guest);

            $fileName = 'event-card-' . $guest->id . '-' . Str::uuid() . '.png';
            $path = storage_path('app/public/cards/' . $fileName);

            $dir = storage_path('app/public/cards');
            if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
                throw new \RuntimeException('The card storage directory could not be created.');
            }

            $browser = $this->cardBrowser($event, $guest, 'image');
            $browser
                ->windowSize(800, 1000)
                ->deviceScaleFactor(2)
                ->waitUntilNetworkIdle()
                ->select('.invitation-shell')
                ->timeout(60)
                ->setDelay(300)
                ->noSandbox()
                ->save($path);

            return response()->download($path, $fileName)->deleteFileAfterSend(true);
        } catch (\Throwable $exception) {
            Log::error('Invitation card image generation failed.', [
                'event_id' => $eventId,
                'guest_id' => $guestId,
                'message' => $exception->getMessage(),
                'exception' => get_class($exception),
            ]);

            throw $exception;
        }
    }

    public function generateCardPdf($eventId, $guestId)
    {
        try {
            $event = Event::findOrFail($eventId);
            $guest = Guest::findOrFail($guestId);
            $this->ensureCardOwnership($event, $guest);

            $fileName = 'event-card-' . $guest->id . '-' . Str::uuid() . '.pdf';
            $path = storage_path('app/public/cards/' . $fileName);
            $dir = dirname($path);

            if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
                throw new \RuntimeException('The card storage directory could not be created.');
            }

            $this->cardBrowser($event, $guest, 'pdf')
                ->windowSize(800, 1000)
                ->paperSize(180, 233)
                ->showBackground()
                ->margins(0, 0, 0, 0)
                ->waitUntilNetworkIdle()
                ->timeout(60)
                ->setDelay(300)
                ->noSandbox()
                ->savePdf($path);

            return response()->download($path, $fileName)->deleteFileAfterSend(true);
        } catch (\Throwable $exception) {
            Log::error('Invitation card PDF generation failed.', [
                'event_id' => $eventId,
                'guest_id' => $guestId,
                'message' => $exception->getMessage(),
                'exception' => get_class($exception),
            ]);

            throw $exception;
        }
    }

    private function cardBrowser(Event $event, Guest $guest, string $format): Browsershot
    {
        $nodeBinary = config('services.browserless.node_binary');
        $nodeModulePath = config('services.browserless.node_module_path');
        $npmBinary = config('services.browserless.npm_binary');

        if (! $nodeBinary && ! $this->commandExists('node')) {
            throw new \RuntimeException(
                'Card export requires Node.js. Install Node.js on the server or set BROWSERSHOT_NODE_BINARY in the production environment.'
            );
        }

        if (! $nodeModulePath && ! $npmBinary && ! $this->commandExists('npm')) {
            throw new \RuntimeException(
                'Card export requires npm or BROWSERSHOT_NODE_MODULE_PATH. Configure the global Node modules directory in production.'
            );
        }

        $html = view('cardview', [
            'event' => $event,
            'guest' => $guest,
            'export' => true,
        ])->render();
        $browser = Browsershot::html($html);
        foreach (
            [
                'node_binary' => 'setNodeBinary',
                'npm_binary' => 'setNpmBinary',
                'node_module_path' => 'setNodeModulePath',
                'chrome_path' => 'setChromePath',
            ] as $configKey => $method
        ) {
            $value = config('services.browserless.' . $configKey);
            if ($value) {
                $browser->{$method}($value);
            }
        }

        return $format === 'image'
            ? $browser->showBackground()
            : $browser;
    }

    private function commandExists(string $command): bool
    {
        $lookup = PHP_OS_FAMILY === 'Windows' ? 'where.exe ' : 'command -v ';
        $suffix = PHP_OS_FAMILY === 'Windows' ? ' 2>NUL' : ' 2>/dev/null';
        $result = shell_exec($lookup . escapeshellarg($command) . $suffix);

        return is_string($result) && trim($result) !== '';
    }

    private function ensureCardOwnership(Event $event, Guest $guest): void
    {
        if ($guest->order_id != $event->id || $event->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
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

                // Normalize phone using your controller method
                $cleanPhone = $this->normalizePhone($phone);
                if (! preg_match('/^\+[1-9]\d{7,14}$/', $cleanPhone)) {
                    throw new \Exception('Invalid phone number on row ' . ($rowIndex + 2) . ': ' . $phone);
                }

                // Compare duplicates after normalization so formatted variations
                // of the same international number are treated as one number.
                if (in_array($cleanPhone, $usedPhones, true)) {
                    throw new \Exception('Duplicate phone found in Excel: ' . $cleanPhone . ' (row ' . ($rowIndex + 2) . ')');
                }
                $usedPhones[] = $cleanPhone;

                // Generate unique 4-digit code per event
                do {
                    $shortCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                    $exists = Guest::where('order_id', $request->event_id)
                        ->where('invitation_code', $shortCode)
                        ->exists();
                } while ($exists);

                $existingGuest = Guest::where('order_id', $request->event_id)
                    ->where('phone', $cleanPhone)
                    ->first();
                if ($existingGuest) {
                    continue; // skip, already exists
                }

                // Create guest
                $guest = Guest::create([
                    'full_name' => $fullName,
                    'title' => strtolower($cardType),
                    'email' => $email ?: null,
                    'phone' => $cleanPhone,
                    'address' => $address ?: null,
                    'delivery_method' => $method,
                    'order_id' => $request->event_id,
                    'counter' => $cardType === 'single' ? '[0/1]' : '[0/2]',
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

    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->delete();
        return response()->json(['success' => true]);
    }

    public function sendInvitation(Request $request, $guestId)
    {
        $guest = Guest::findOrFail($guestId);
        $event = Event::findOrFail($guest->order_id);

        // Build the invitation data
        $data = [
            'guest' => $guest,
            'event' => $event,
            'qr_url' => $guest->more ?? url('/guest/' . $guest->qrcode),
            'card_preview_url' => route('user.cardview', ['event' => $event->id, 'guest' => $guest->id])
        ];

        $method = $guest->delivery_method;

        try {
            switch ($method) {
                case 'email':
                    Mail::to($guest->email)->send(new InvitationMail($data));
                    break;
                case 'sms':
                    $this->sendSmsBeem($guest->phone, $data);
                    break;
                case 'whatsapp':
                    $this->sendWhatsAppBeem($guest->phone, $data);
                    break;
                default:
                    return back()->with('error', 'Unsupported delivery method');
            }
            // dd(Mail::to($guest->email)->send(new InvitationMail($data)));
            return back()->with('success', "Invitation sent via {$method}");
        } catch (\Exception $e) {
            // dd($guest->phone);
            return back()->with('error', "Failed to send: " . $e->getMessage());
        }
    }

    private function sendSmsBeem($phone, $data)
    {
        $phone = ltrim($this->normalizePhone($phone), '+');

        $message = "Dear {$data['guest']->full_name}, you are invited to {$data['event']->order_name} on " .
            \Carbon\Carbon::parse($data['event']->event_date)->format('F j, Y') .
            " at {$data['event']->event_location}. View your invitation: {$data['qr_url']}";

        // TODO: Integrate Beem SMS API using credentials from .env
        // Example using Beem (see sms.txt):
        /*
    $api_key = env('BEEM_SMS_API_KEY');
    $secret_key = env('BEEM_SMS_SECRET');
    $postData = [
        'source_addr' => env('BEEM_SENDER_ID', 'INFO'),
        'message' => $message,
        'recipients' => [['recipient_id' => 1, 'dest_addr' => $phone]]
    ];
    $ch = curl_init('https://apisms.beem.africa/v1/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode("$api_key:$secret_key"),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    $response = curl_exec($ch);
    if (curl_error($ch)) throw new \Exception(curl_error($ch));
    */

        // For now, just log
        \Log::info("SMS would be sent to $phone: $message");
    }

    private function sendWhatsAppBeem($phone, $data)
    {
        $phone = ltrim($this->normalizePhone($phone), '+');

        // TODO: Integrate Beem WhatsApp API (Moja) using WhatsApp templates
        // You need a pre-approved template.
        // Example using Beem Moja (see whatsapp.txt):
        /*
    $api_key = env('BEEM_WHATSAPP_API_KEY');
    $secret_key = env('BEEM_WHATSAPP_SECRET');
    $from = env('BEEM_WHATSAPP_FROM'); // your WhatsApp business number
    $template_id = env('BEEM_WHATSAPP_TEMPLATE_ID'); // approved template ID
    $postData = [
        'from_addr' => $from,
        'destination_addr' => [['phoneNumber' => $phone, 'params' => [$data['guest']->full_name, $data['event']->order_name, $data['qr_url']]]],
        'channel' => 'whatsapp',
        'messageTemplateData' => ['id' => $template_id]
    ];
    // send to https://apibroadcast.beem.africa/v1/broadcast/template/api-send
    */

        \Log::info("WhatsApp message would be sent to $phone using template");
    }
}
