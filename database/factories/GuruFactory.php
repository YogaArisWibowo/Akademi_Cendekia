<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guru>
 */
class GuruFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'jenjang' => $this->faker->randomElement(['TK', 'SD', 'SMP', 'SMA']),
            'kelas' => $this->faker->numberBetween(1, 12),
            'asal_sekolah' => $this->faker->company(),
            'no_hp' => $this->faker->phoneNumber(),
            'status' => 'aktif',
        ];
    }
}
