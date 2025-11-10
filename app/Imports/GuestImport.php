<?php

namespace App\Imports;

use App\Models\Guest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GuestImport implements ToCollection, WithHeadingRow
{
    public function __construct(public $eventId) {}

    public function collection(Collection $rows)
    {
        $requiredHeaders = [
            's/n',
            'full name',
            'card type',
            'method',
            'phone',
            'email',
            'address',
        ];

        if ($rows->isEmpty()) {
            throw new \Exception("Excel file is empty");
        }

        // Convert first row keys to lowercase
        $firstRowKeys = array_map('strtolower', array_keys($rows->first()->toArray()));

        // Validate headers exist
        foreach ($requiredHeaders as $header) {
            if (!in_array($header, $firstRowKeys)) {
                throw new \Exception("Missing required column: $header");
            }
        }

        $emptyRowCount = 0;
        $usedPhones = [];

        foreach ($rows as $row) {
            $rowArray = $row->toArray(); // convert collection to array

            // Stop after 2 empty rows
            if (!array_filter($rowArray)) {
                $emptyRowCount++;
                if ($emptyRowCount >= 2) break;
                continue;
            }
            $emptyRowCount = 0;

            // Map row keys to lowercase for safe access
            $rowAssoc = [];
            foreach ($rowArray as $k => $v) {
                $rowAssoc[strtolower($k)] = $v;
            }

            // Clean data
            $fullName = isset($rowAssoc['full name']) ? Str::title(strtolower(trim($rowAssoc['full name']))) : null;
            $phone = strtolower(trim($rowAssoc['phone'] ?? ''));
            $method = strtolower(trim($rowAssoc['method'] ?? ''));
            $email = strtolower(trim($rowAssoc['email'] ?? ''));
            $address = strtolower(trim($rowAssoc['address'] ?? ''));
            $cardType = strtolower(trim($rowAssoc['card type'] ?? ''));

            if (!$fullName || !$phone || !$method) {
                continue; // skip broken rows
            }

            // Check for duplicate phones
            if (in_array($phone, $usedPhones)) {
                throw new \Exception("Duplicate phone found in Excel: $phone");
            }
            $usedPhones[] = $phone;

            // Normalize phone using your controller method
            $cleanPhone = app()->make('App\Http\Controllers\Controller')->normalizePhone($phone);

            // Generate unique 4-digit code for this event
            do {
                $shortCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                $exists = Guest::where('order_id', $this->eventId)
                    ->where('invitation_code', $shortCode)
                    ->exists();
            } while ($exists);

            // Create guest
            $guest = Guest::create([
                'full_name' => $fullName,
                'title' => strtoupper($cardType),
                'email' => $email ?: null,
                'phone' => $cleanPhone,
                'address' => $address ?: null,
                'delivery_method' => $method,
                'order_id' => $this->eventId,
                'counter' => '[0/2]',
                'invitation_code' => $shortCode,
            ]);

            // Generate public guest code
            $code = 'GUEST-' . strtoupper(Str::random(10));
            $publicUrl = url('/guest/' . $code);

            // Update guest record
            $guest->update([
                'qrcode' => $code,
                'more' => $publicUrl,
            ]);

            // Generate QR code (SVG)
            QrCode::format('svg')->size(300)->generate($publicUrl);
        }
    }
}
