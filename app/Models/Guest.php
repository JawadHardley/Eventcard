<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    // Explicitly specify the correct table name
    // protected $table = 'guests';

    protected $guarded = [];

    // // Relationship with Order
    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }
}
