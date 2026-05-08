<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

<<<<<<< HEAD
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin2@example.com',
            'role' => 'admin',
            'password' => bcrypt('123456789'),
        ]);
=======
        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@example.com',
        //     'role' => 'admin',
        //     'password' => bcrypt('12345678'),
        // ]);

        JenisLapangan::factory(4)->create();
>>>>>>> e61863a5d0af244b9145c4153bdc08635bc21305
    }
}
