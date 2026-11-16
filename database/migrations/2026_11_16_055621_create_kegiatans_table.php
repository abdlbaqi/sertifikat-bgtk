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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('template_sertifikat')->nullOnDelete(); // Relasi ke Template Desain CMS
            $table->string('kode_kegiatan')->unique(); // Misal: BGTK-2026-BIMTEK-01
            $table->string('nama_kegiatan'); // Nama Kegiatan / Pelatihan
            $table->string('slug')->unique(); // URL slug
            $table->string('jenis_kegiatan')->default('Bimtek'); // Bimtek, Diklat, Lokakarya, Webinar, Seminar
            $table->string('penyelenggara')->default('Balai Guru dan Tenaga Kependidikan Provinsi Lampung');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('jumlah_jam')->nullable(); // Jumlah Jam Pelajaran (JP), misal: 32
            $table->date('tanggal_sertifikat')->nullable(); // Tanggal penandatanganan sertifikat
            $table->string('nama_penandatangan')->nullable(); // Nama Pejabat (Kepala Balai)
            $table->string('nip_penandatangan')->nullable(); // NIP Pejabat
            $table->string('jabatan_penandatangan')->default('Kepala Balai Guru dan Tenaga Kependidikan Provinsi Lampung');
            $table->string('ttd_penandatangan')->nullable(); // File scan tanda tangan & stempel
            $table->string('template_background')->nullable(); // Override background kustom jika ada
            $table->text('deskripsi')->nullable();
            $table->boolean('status_terbit')->default(true); // Apakah sertifikat kegiatan ini sudah dipublikasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
