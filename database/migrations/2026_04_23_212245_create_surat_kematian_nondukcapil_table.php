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
        Schema::create('surat_kematian_nondukcapil', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ahli_waris', 255);
            $table->string('nik_ahli_waris', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat_ahli_waris');
            $table->string('hubungan_ahli_waris', 100);
            $table->string('nama_almarhum', 255);
            $table->string('nik_almarhum', 16);
            $table->string('tempat_meninggal', 255);
            $table->date('tanggal_meninggal');
            $table->text('alamat_almarhum');
            $table->string('keterangan_almarhum', 255)->nullable();
            $table->string('nomor_surat_rt', 100);
            $table->date('tanggal_surat_rt');
            $table->text('dokumen_pendukung')->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->string('keperluan', 255)->nullable();
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
        Schema::dropIfExists('surat_kematian_nondukcapil');
    }
};
