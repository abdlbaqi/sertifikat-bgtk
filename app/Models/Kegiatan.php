<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'template_id',
        'kode_kegiatan',
        'nama_kegiatan',
        'slug',
        'jenis_kegiatan',
        'penyelenggara',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_jam',
        'tanggal_sertifikat',
        'nama_penandatangan',
        'nip_penandatangan',
        'jabatan_penandatangan',
        'ttd_penandatangan',
        'template_background',
        'deskripsi',
        'status_terbit',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_sertifikat' => 'date',
        'status_terbit' => 'boolean',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(TemplateSertifikat::class, 'template_id');
    }

    public function sertifikat(): HasMany
    {
        return $this->hasMany(Sertifikat::class, 'kegiatan_id');
    }

    public function materi(): HasMany
    {
        return $this->hasMany(MateriKegiatan::class, 'kegiatan_id')->orderBy('urutan');
    }
}
