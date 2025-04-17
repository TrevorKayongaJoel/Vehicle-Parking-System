<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\ParkingRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParkingController extends Controller
{
    public function index()
{
    dd('Reached controller'); // Debugging line
    $slots = ParkingSlot::all();
    return Inertia::render('Attendant/Parking', [
        'slots' => $slots
    ]);
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

public function checkOut(Request $request)
{
    $validated = $request->validate([
        'slot_id' => 'required|exists:parking_slots,id',
    ]);

    $slot = ParkingSlot::find($validated['slot_id']);

    $record = ParkingRecord::where('parking_slot_id', $slot->id)
                ->whereNull('check_out_time')
                ->latest()
                ->first();

    if (!$record) {
        return back()->withErrors(['slot' => 'No active parking record found for this slot.']);
    }

    $checkIn = Carbon::parse($record->check_in_time);
    $checkOut = now();
    $durationInMinutes = $checkIn->diffInMinutes($checkOut);

    $ratePerHour = 2.00;
    $durationInHours = $durationInMinutes / 60;
    $fee = round($durationInHours * $ratePerHour, 2);

    $record->update([
        'check_out_time' => $checkOut,
        'fee' => $fee
    ]);

    $slot->update(['is_occupied' => false]);

    return redirect()->back()->with([
        'success' => "Vehicle checked out!",
        'duration_minutes' => $durationInMinutes,
        'fee' => $fee,
    ]);
}
// public function index()
// {
//     $slots = ParkingSlot::all();
//     return Inertia::render('Attendant.vue', [
//         'slots' => $slots,
//     ]);
// }


}


