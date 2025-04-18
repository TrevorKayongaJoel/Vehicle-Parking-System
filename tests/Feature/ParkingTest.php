<?php

test('can check in a vehicle', function () {
    $user = \App\Models\User::factory()->create(['role' => 'attendant']);
    $slot = \App\Models\ParkingSlot::factory()->create(['is_occupied' => false]);

    $this->actingAs($user)
        ->post(route('parking.checkin'), [
            'vehicle_number' => 'XYZ123',
            'slot_id' => $slot->id,
        ])
        ->assertRedirect();

    expect(\App\Models\ParkingRecord::count())->toBe(1);
    expect(\App\Models\ParkingSlot::first()->is_occupied)->toBeTrue();
});
