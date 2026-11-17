<?php

namespace Database\Factories;

use App\Models\Bidang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bidang>
 */
class BidangFactory extends Factory
{
    protected $model = Bidang::class;

    public function definition(): array
    {
        return [
            'nama' => 'Bidang ' . ucfirst(fake()->unique()->word()),
            'deskripsi' => fake()->sentence(10),
        ];
    }
}
