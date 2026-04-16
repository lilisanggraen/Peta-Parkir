<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin (Agar kamu bisa login)
        User::create([
            'name' => 'Admin Lilis',
            'email' => 'admin@peta.com',
            'password' => Hash::make('password123'),
        ]);

        // Panggil Data Parkir
        $this->call([
            ParkingSpotSeeder::class,
        ]);
    }
}
