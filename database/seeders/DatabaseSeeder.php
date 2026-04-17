<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat User Admin secara otomatis
        User::updateOrCreate(
            ['email' => 'admin@parkir.com'], // Cek email ini dulu
            [
                'name' => 'Admin Salatiga',
                'password' => Hash::make('rahasia123'), // Password kamu
            ]
        );

        $this->call([
            ParkingSpotSeeder::class,
        ]);
    }
}
