<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingRecord extends Model
{
    protected $fillable = ['vehicle_number', 'parking_slot_id', 'check_in_time', 'check_out_time'];

    public function slot()
    {
        return $this->belongsTo(ParkingSlot::class, 'parking_slot_id');
    }
}
