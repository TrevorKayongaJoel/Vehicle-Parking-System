<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $fillable = [
        'vehicle_number',
        'check_in_time',
        'check_out_time',
        'attendant_id',
        'fee',
    ];

    protected $dates = ['check_in_time', 'check_out_time'];

    public function attendant()
    {
        return $this->belongsTo(User::class, 'attendant_id');
    }

}
