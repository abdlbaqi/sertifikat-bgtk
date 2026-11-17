<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('template_sertifikat', function (Blueprint $table) {
            $table->longText('layout_json')->nullable()->after('deskripsi')
                ->comment('JSON layout posisi, ukuran, dan gaya setiap elemen kanvas sertifikat');
        });
    }

    public function down(): void
    {
        Schema::table('template_sertifikat', function (Blueprint $table) {
            $table->dropColumn('layout_json');
        });
    }
};
