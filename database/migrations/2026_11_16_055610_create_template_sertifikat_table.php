<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('template_sertifikat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template'); // Contoh: "Template Emas Kedinasan BGTK", "Template Guru Penggerak"
            $table->string('kode_template')->unique(); // Misal: tpl-emas-resmi
            $table->enum('orientasi', ['landscape', 'portrait'])->default('landscape'); // Format A4 Landscape/Portrait
            $table->string('file_gambar_depan')->nullable(); // Gambar blanko / background halaman depan
            $table->string('file_gambar_belakang')->nullable(); // Gambar blanko halaman belakang (materi JP)
            $table->string('font_nama')->default('Montserrat'); // Font khusus nama peserta (misal: 'Great Vibes', 'Playfair Display')
            $table->string('font_teks')->default('Plus Jakarta Sans'); // Font teks isi
            $table->string('warna_primer')->default('#1e3a8a'); // Warna aksen / tema (Hex code)
            $table->string('warna_teks')->default('#1f2937'); // Warna teks utama
            $table->boolean('tampilkan_garis_tepi')->default(true); // Bingkai / ornamen sertifikat
            $table->boolean('tampilkan_qr_code')->default(true); // Tampilkan QR verifikasi
            $table->json('posisi_elemen')->nullable(); // Koordinat X, Y, ukuran font untuk CMS fleksibel
            $table->boolean('status_aktif')->default(true);
            $table->boolean('is_bawaan')->default(false); // Template bawaan sistem (tidak bisa sembarangan dihapus)
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_sertifikat');
    }
};

