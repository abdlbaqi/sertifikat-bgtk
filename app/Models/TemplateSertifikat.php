<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateSertifikat extends Model
{
    use HasFactory;

    protected $table = 'template_sertifikat';

    protected $fillable = [
        'nama_template',
        'kode_template',
        'orientasi',
        'file_gambar_depan',
        'file_gambar_belakang',
        'font_nama',
        'font_teks',
        'warna_primer',
        'warna_teks',
        'tampilkan_garis_tepi',
        'tampilkan_qr_code',
        'posisi_elemen',
        'status_aktif',
        'is_bawaan',
        'deskripsi',
    ];

    protected $casts = [
        'posisi_elemen' => 'array',
        'tampilkan_garis_tepi' => 'boolean',
        'tampilkan_qr_code' => 'boolean',
        'status_aktif' => 'boolean',
        'is_bawaan' => 'boolean',
    ];

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class, 'template_id');
    }
}

