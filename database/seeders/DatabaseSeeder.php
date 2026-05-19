<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\JenisLapangan;
use App\Models\Lapangan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin2@example.com',
        //     'role' => 'admin',
        //     'password' => bcrypt('123456789'),
        // ]);
        // User::factory(100)->create();
        // JenisLapangan::factory(4)->create();
        // Lapangan::factory(4)->create();
        // Booking::factory(20)->create();
        

    }
}
