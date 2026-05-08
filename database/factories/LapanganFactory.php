<?php

namespace Database\Factories;

use App\Models\JenisLapangan;
use App\Models\Lapangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lapangan>
 */
class LapanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lapangan' => fake()->randomElement([
                'Lapangan GG',
                'Lapangan GACOR',
                'Lapangan Basket',
                'Lapangan Padel',
            ]),
            'jenis_lapangan' =>
            JenisLapangan::inRandomOrder()->first()->id,
            'deskripsi_lapangan'=>fake()->sentence(),
            'harga_sewa'=>fake()->numberBetween(1000,3000)
        ];
    }
}
