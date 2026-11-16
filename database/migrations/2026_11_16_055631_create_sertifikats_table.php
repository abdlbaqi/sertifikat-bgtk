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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete();
            $table->string('nomor_sertifikat')->unique(); // Misal: 001/BGTK-LPG/PP.01.07/2026
            $table->string('kode_verifikasi')->unique()->index(); // Kode unik QR Code / validasi online, misal: BGTK-7A8B9C
            $table->string('nama_peserta'); // Nama Lengkap beserta Gelar
            $table->string('nomor_identitas')->nullable()->index(); // NIP / NUPTK / NIK peserta
            $table->string('instansi')->nullable(); // Asal Sekolah / Satuan Pendidikan (misal: SMAN 1 Bandar Lampung)
            $table->string('kabupaten_kota')->nullable(); // Kab/Kota di Lampung
            $table->string('email')->nullable();
            $table->string('peran')->default('Peserta'); // Peserta, Narasumber, Fasilitator, Moderator, Panitia
            $table->string('file_sertifikat')->nullable(); // Path berkas PDF jika disimpan permanen
            $table->unsignedInteger('jumlah_unduh')->default(0); // Hitungan berapa kali sertifikat diunduh
            $table->enum('status', ['aktif', 'dicabut'])->default('aktif'); // Status keabsahan sertifikat
            $table->text('alasan_dicabut')->nullable(); // Alasan jika sertifikat dibatalkan/direvisi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
