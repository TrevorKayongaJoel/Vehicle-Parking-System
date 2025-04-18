<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    protected $fillable = ['slot_number', 'is_occupied'];

    public function records()
    {
        return $this->hasMany(ParkingRecord::class);
    }
}
