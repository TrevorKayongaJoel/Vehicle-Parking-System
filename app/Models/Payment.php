<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'type', 'reference', 'amount', 'notes',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function parkingSlot() {
        return $this->belongsTo(ParkingSlot::class);
    }
}
