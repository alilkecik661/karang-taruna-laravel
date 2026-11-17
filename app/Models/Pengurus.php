<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';

    protected $fillable = [
        'nama',
        'jabatan',
        'bidang_id',
        'foto',
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

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    public function getInisialAttribute(): string
    {
        $words = preg_split('/\s+/', trim($this->nama)) ?: [];
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }

        return $initials ?: 'KT';
    }
}
