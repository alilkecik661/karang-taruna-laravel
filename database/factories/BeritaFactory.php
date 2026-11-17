<?php

namespace Database\Factories;

use App\Models\Berita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Berita>
 */
class BeritaFactory extends Factory
{
    protected $model = Berita::class;

    public function definition(): array
    {
        $judul = 'Berita Contoh ' . fake()->unique()->words(3, true);

        return [
            'judul' => ucfirst($judul),
            'slug' => Str::slug($judul) . '-' . fake()->unique()->numberBetween(100, 999),
            'isi' => fake()->paragraphs(3, true),
            'gambar_sampul' => null,
            'is_pinned' => false,
            'status' => 'publish',
            'published_at' => now(),
            'created_by' => null,
        ];
    }
}
