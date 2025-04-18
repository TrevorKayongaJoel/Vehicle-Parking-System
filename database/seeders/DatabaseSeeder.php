<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\ParkingSlot;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@vpms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    
        User::create([
            'name' => 'Attendant User',
            'email' => 'attendant@vpms.com',
            'password' => Hash::make('password'),
            'role' => 'attendant',
        ]);

        foreach (range(1, 10) as $i) {
            ParkingSlot::create([
                'slot_number' => 'P-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'is_occupied' => false,
            ]);
        }
    }
}
