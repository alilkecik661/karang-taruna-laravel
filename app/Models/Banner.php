<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banner';

    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
        'tautan',
        'urutan',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'is_aktif' => 'boolean',
        ];
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true)->orderBy('urutan');
    }
}
