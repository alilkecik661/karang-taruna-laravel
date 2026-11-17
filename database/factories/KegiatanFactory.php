<?php

namespace Database\Factories;

use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Kegiatan>
 */
class KegiatanFactory extends Factory
{
    protected $model = Kegiatan::class;

    public function definition(): array
    {
        $judul = 'Kegiatan Contoh ' . fake()->unique()->words(3, true);

        return [
            'judul' => ucfirst($judul),
            'slug' => Str::slug($judul) . '-' . fake()->unique()->numberBetween(100, 999),
            'bidang_id' => null,
            'deskripsi' => fake()->paragraphs(3, true),
            'tanggal_mulai' => now()->addDays(fake()->numberBetween(1, 30)),
            'tanggal_selesai' => now()->addDays(fake()->numberBetween(31, 40)),
            'lokasi' => 'Balai Desa Contoh',
            'gambar_sampul' => null,
            'status' => 'publish',
            'created_by' => null,
        ];
    }
}
