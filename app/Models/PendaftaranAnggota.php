<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranAnggota extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_anggota';

    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_whatsapp',
        'email',
        'bidang_minat',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }
}
