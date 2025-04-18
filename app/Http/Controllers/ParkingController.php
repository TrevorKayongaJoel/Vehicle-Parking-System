<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\ParkingRecord;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
{
    $slots = ParkingSlot::all();
    return Inertia::render('Attendant/Parking', ['slots' => $slots]);
}

public function checkIn(Request $request)
{
    $validated = $request->validate([
        'vehicle_number' => 'required|string',
        'slot_id' => 'required|exists:parking_slots,id',
    ]);

    $slot = ParkingSlot::find($validated['slot_id']);

    if ($slot->is_occupied) {
        return back()->withErrors(['slot' => 'Slot already occupied']);
    }

    ParkingRecord::create([
        'vehicle_number' => $validated['vehicle_number'],
        'parking_slot_id' => $slot->id,
        'check_in_time' => now(),
    ]);

    $slot->update(['is_occupied' => true]);

    return redirect()->back()->with('success', 'Vehicle checked in!');
}

}


