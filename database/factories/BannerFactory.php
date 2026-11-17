<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition(): array
    {
        return [
            'judul' => 'Bersama pemuda, membangun desa yang lebih berdaya',
            'subjudul' => 'Karang Taruna · Pemuda Bergerak',
            'gambar' => null,
            'tautan' => '/daftar',
            'urutan' => 1,
            'is_aktif' => true,
        ];
    }
}
