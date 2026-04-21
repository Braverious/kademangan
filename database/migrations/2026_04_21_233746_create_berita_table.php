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

        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->string('judul_berita');
            $table->string('slug_berita');
            $table->text('isi_berita');
            $table->enum('kategori', ['Kegiatan', 'Pengumuman', 'Layanan', 'Umum'])->default('Umum');
            $table->string('gambar', 100);
            $table->dateTime('tgl_publish')->useCurrent();
            $table->unsignedBigInteger('id_user');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
