<?php

use App\Models\Guest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('attendee_number');
            $table->timestamps();
            $table->unique(['guest_id', 'attendee_number']);
        });

        // Seed the log from existing attendance state. Older double-card
        // timestamps can only be approximated using the guest's last update.
        Guest::query()
            ->where(function ($query) {
                $query->where('verified', true)
                    ->orWhereIn('counter', ['[1/2]', '[2/2]']);
            })
            ->orderBy('id')
            ->chunkById(500, function ($guests) {
                foreach ($guests as $guest) {
                    $attendeeCount = $guest->title === 'double'
                        ? match ($guest->counter) {
                            '[2/2]' => 2,
                            '[1/2]' => 1,
                            default => 1,
                        }
                        : 1;

                    for ($attendeeNumber = 1; $attendeeNumber <= $attendeeCount; $attendeeNumber++) {
                        \Illuminate\Support\Facades\DB::table('guest_check_ins')->insertOrIgnore([
                            'guest_id' => $guest->id,
                            'event_id' => $guest->order_id,
                            'attendee_number' => $attendeeNumber,
                            'created_at' => $guest->updated_at,
                            'updated_at' => $guest->updated_at,
                        ]);
                    }
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_check_ins');
    }
};
