<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Inertia\Inertia;
use App\Models\ParkingSlot;
use App\Models\ParkingRecord;
use Carbon\Carbon;


class PaymentController extends Controller
{
    public function create(Request $request)
{
    $slotId = $request->query('slot_id');
    $fee = null;

    // Try to fetch the active parking record
    if ($slotId) {
        $record = ParkingRecord::where('parking_slot_id', $slotId)
            ->whereNull('check_out_time')
            ->latest()
            ->first();

        if ($record) {
            $checkIn = Carbon::parse($record->check_in_time);
            $now = now();
            $durationMinutes = $checkIn->diffInMinutes($now);
            $ratePerHour = 2.00;

            $fee = round(($durationMinutes / 60) * $ratePerHour, 2);
        }
    }

    return Inertia::render('Payments/Create', [
        'slots' => \App\Models\ParkingSlot::all(),
        'slot_id' => $slotId,
        'amount' => $fee,
    ]);
}

    public function store(Request $request)
    {
       

        $request->validate([
            'type' => 'required|in:cash,fake',
            'amount' => 'required|numeric|min:0',
           // 'reference' => 'nullable|string|max:255',
            'slot_id' => 'required|exists:parking_slots,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        Payment::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'slot_id' => $request->slot_id,
            //'reference' => $request->reference,
            'notes' => $request->notes,
        ]);

        // Mark the slot as unoccupied
$slot = \App\Models\ParkingSlot::find($request->slot_id);
if ($slot) {
    $slot->is_occupied = false;
    $slot->save();
}
        // Mark the parking record as paid
        $record = ParkingRecord::where('parking_slot_id', $request->slot_id)
            ->whereNull('check_out_time')
            ->latest()
            ->first();
        if ($record) {
            $record->update([
                'check_out_time' => now(),
                'fee' => $request->amount,
            ]);
        }

        return redirect()
    ->route('attendant.dashboard') // or 'admin.dashboard' based on role
    ->with('status', '✅ Payment submitted successfully!');

    }

    
}
