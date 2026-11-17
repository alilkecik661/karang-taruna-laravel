<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';

    protected $fillable = [
        'album_id',
        'path',
        'caption',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
