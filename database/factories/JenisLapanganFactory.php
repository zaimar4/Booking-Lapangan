<?php

namespace Database\Factories;

use App\Models\JenisLapangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JenisLapangan>
 */
class JenisLapanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'nama_jenis' => fake()->randomElement([
            'Futsal',
            'Basket',
            'Badminton',
            'Mini Soccer',
            'Voli'
        ]),
    ];
}
}
