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
        Schema::create('surat_belum_memiliki_rumah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon', 255);
            $table->string('nik', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('kewarganegaraan', 100)->default('Indonesia');
            $table->string('agama', 50);
            $table->string('pekerjaan', 150);
            $table->text('alamat');
            $table->text('keperluan');
            $table->string('nomor_surat_rt', 100);
            $table->date('tanggal_surat_rt');
            $table->text('dokumen_pendukung')->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');

            $table->foreignId('id_user')->nullable()->constrained('user', 'id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_belum_memiliki_rumah');
    }
};
