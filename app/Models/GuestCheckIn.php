<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestCheckIn extends Model
{
    protected $fillable = [
        'guest_id',
        'event_id',
        'attendee_number',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
