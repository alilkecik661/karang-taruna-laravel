<?php

namespace Database\Factories;

use App\Models\Pengurus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pengurus>
 */
class PengurusFactory extends Factory
{
    protected $model = Pengurus::class;

    public function definition(): array
    {
        return [
            'nama' => 'Pengurus Contoh ' . fake()->numberBetween(1, 99),
            'jabatan' => 'Anggota Bidang',
            'bidang_id' => null,
            'foto' => null,
            'urutan' => fake()->numberBetween(1, 20),
            'is_aktif' => true,
        ];
    }
}
