<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        'kegiatan_id',
        'nomor_sertifikat',
        'kode_verifikasi',
        'nama_peserta',
        'nomor_identitas',
        'instansi',
        'kabupaten_kota',
        'email',
        'peran',
        'file_sertifikat',
        'jumlah_unduh',
        'status',
        'alasan_dicabut',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    /**
     * Scope untuk mengambil hanya sertifikat yang aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
