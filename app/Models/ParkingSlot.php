<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    const STATUS_AVAILABLE = 'available';
    const STATUS_OCCUPIED = 'occupied';
    
    protected $fillable = [
        'slot_number', 
        'is_occupied',
        'type',
        'hourly_rate'
    ];
    
    protected $attributes = [
        'is_occupied' => false,
        'type' => 'standard',
        'hourly_rate' => 5.00
    ];

    public function parkingRecords()
    {
        return $this->hasMany(ParkingRecord::class);
    }

    public function occupy()
    {
        $this->update(['is_occupied' => true]);
    }

    public function vacate()
    {
        $this->update(['is_occupied' => false]);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_occupied', false);
    }

    public function scopeOccupied($query)
    {
        return $query->where('is_occupied', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}