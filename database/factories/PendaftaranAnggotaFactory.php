<?php

namespace Database\Factories;

use App\Models\PendaftaranAnggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PendaftaranAnggota>
 */
class PendaftaranAnggotaFactory extends Factory
{
    protected $model = PendaftaranAnggota::class;

    public function definition(): array
    {
        return [
            'nama_lengkap' => 'Calon Anggota Contoh ' . fake()->numberBetween(1, 99),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => '2003-05-15',
            'alamat' => 'Jl. Contoh Desa No. 10, RT 01 / RW 02, Kelurahan Contoh',
            'no_whatsapp' => '081234567890',
            'email' => 'pendaftar.contoh@example.com',
            'bidang_minat' => 'Sosial dan lingkungan',
            'status' => 'baru',
            'catatan_admin' => null,
        ];
    }
}
