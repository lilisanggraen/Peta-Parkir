<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingSpot;

class ParkingSpotSeeder extends Seeder
{
    public function run(): void
    {
        // Data Parkir 1
        ParkingSpot::create([
            'name' => 'Parkir Alun-alun Pancasila',
            'latitude' => -7.3305,
            'longitude' => 110.5084,
            'status' => 'aktif',
            'description' => 'Area parkir luas pusat kota Salatiga'
        ]);

        // Data Parkir 2
        ParkingSpot::create([
            'name' => 'Parkir Kampus UIN Salatiga',
            'latitude' => -7.3475,
            'longitude' => 110.5002,
            'status' => 'aktif',
            'description' => 'Area parkir gedung utama'
        ]);
    }
}
