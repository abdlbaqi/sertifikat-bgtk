<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MateriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'materi_kegiatan';

    protected $fillable = [
        'kegiatan_id',
        'nama_materi',
        'jumlah_jam',
        'urutan',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}
