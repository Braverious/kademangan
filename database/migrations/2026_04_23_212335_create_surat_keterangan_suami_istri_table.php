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
        Schema::create('surat_keterangan_suami_istri', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pihak_satu', 255);
            $table->string('nik_pihak_satu', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->string('tempat_lahir_pihak_satu', 100);
            $table->date('tanggal_lahir_pihak_satu');
            $table->enum('jenis_kelamin_pihak_satu', ['Laki-laki', 'Perempuan']);
            $table->string('agama_pihak_satu', 50);
            $table->string('pekerjaan_pihak_satu', 100);
            $table->string('warganegara_pihak_satu', 100);
            $table->text('alamat_pihak_satu');
            $table->string('nama_pihak_dua', 255);
            $table->string('nik_pihak_dua', 16);
            $table->text('alamat_pihak_dua');
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
        Schema::dropIfExists('surat_keterangan_suami_istri');
    }
};
