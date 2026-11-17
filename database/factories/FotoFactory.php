<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Foto>
 */
class FotoFactory extends Factory
{
    protected $model = Foto::class;

    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'path' => 'sample/galeri-1.svg',
            'caption' => 'Dokumentasi kegiatan Karang Taruna (contoh)',
            'urutan' => 1,
        ];
    }
}
