<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingSpot;

class ParkingSpotSeeder extends Seeder
{
    public function run(): void
    {
        // Lokasi 1: Alun-alun Pancasila
        ParkingSpot::create([
            'name' => 'Parkir Alun-alun Pancasila',
            'latitude' => -7.3305,
            'longitude' => 110.5084,
            'status' => 'aktif',
            'description' => 'Area parkir luas pusat kota Salatiga'
        ]);

        // Lokasi 2: Kampus UIN Salatiga (Kampus 3)
        ParkingSpot::create([
            'name' => 'Parkir Gedung KH Hasyim Asyari UIN',
            'latitude' => -7.3475,
            'longitude' => 110.5002,
            'status' => 'aktif',
            'description' => 'Parkir khusus civitas akademika'
        ]);

        // Lokasi 3: Pasar Raya Salatiga
        ParkingSpot::create([
            'name' => 'Parkir Pasar Raya Salatiga',
            'latitude' => -7.3292,
            'longitude' => 110.5011,
            'status' => 'aktif',
            'description' => 'Parkir pinggir jalan pusat perbelanjaan'
        ]);
    }
}
