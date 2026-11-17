<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Album>
 */
class AlbumFactory extends Factory
{
    protected $model = Album::class;

    public function definition(): array
    {
        $judul = 'Album Dokumentasi ' . fake()->unique()->words(2, true);

        return [
            'judul' => ucfirst($judul),
            'slug' => Str::slug($judul) . '-' . fake()->unique()->numberBetween(100, 999),
            'deskripsi' => fake()->sentence(12),
            'kegiatan_id' => null,
            'created_by' => null,
        ];
    }
}
