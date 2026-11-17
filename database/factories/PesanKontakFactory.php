<?php

namespace Database\Factories;

use App\Models\PesanKontak;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PesanKontak>
 */
class PesanKontakFactory extends Factory
{
    protected $model = PesanKontak::class;

    public function definition(): array
    {
        return [
            'nama' => 'Warga Contoh',
            'email' => 'warga.contoh@example.com',
            'subjek' => 'Pertanyaan Kegiatan Karang Taruna',
            'isi' => 'Halo pengurus Karang Taruna, saya ingin menanyakan jadwal kegiatan bakti sosial bulan ini.',
            'sudah_dibaca' => false,
        ];
    }
}
