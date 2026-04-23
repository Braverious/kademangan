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
        Schema::create('surat_domisili_yayasan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penanggung_jawab', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('nik', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('kewarganegaraan', 50);
            $table->string('agama', 50);
            $table->text('alamat_pemohon');
            $table->string('nama_organisasi', 255);
            $table->string('jenis_kegiatan', 100);
            $table->text('alamat_kantor');
            $table->integer('jumlah_pengurus');
            $table->string('nama_notaris_pendirian', 100);
            $table->string('nomor_akta_pendirian', 50);
            $table->date('tanggal_akta_pendirian');
            $table->string('nama_notaris_perubahan', 100)->nullable();
            $table->string('nomor_akta_perubahan', 50)->nullable();
            $table->date('tanggal_akta_perubahan')->nullable();
            $table->string('npwp', 50);
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
        Schema::dropIfExists('surat_domisili_yayasan');
    }
};
