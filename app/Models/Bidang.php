<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class, 'bidang_id');
    }

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class, 'bidang_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'bidang_id');
    }
}
