<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Lapangan;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $lapangans = Lapangan::all();

        for ($i = 0; $i < 20; $i++) {

            $jamMulai = rand(8, 20);

            $durasi = rand(1, 3);

            $jamSelesai = $jamMulai + $durasi;

            Booking::create([
                'lapangan_id' => $lapangans->random()->id,

                'user_id' => $users->random()->id,

                'tanggal' => now()->addDays(rand(0, 7))->format('Y-m-d'),

                'jam_mulai' => sprintf('%02d:00:00', $jamMulai),

                'jam_selesai' => sprintf('%02d:00:00', $jamSelesai),

                'total_harga' => rand(50000, 200000),

                'status' => collect([
                    'pending',
                    'success',
                    'cancel'
                ])->random()
            ]);
        }
    }
}