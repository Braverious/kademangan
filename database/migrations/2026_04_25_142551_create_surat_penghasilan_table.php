<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat_penghasilan', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_surat_rt');
            $table->date('tanggal_surat_rt');

            $table->text('dokumen_pendukung')->nullable();

            $table->string('nomor_surat')->nullable();

            $table->string('nama_pemohon');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');

            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);

            $table->string('nik', 20);
            $table->string('telepon_pemohon', 20)->nullable();

            $table->string('warganegara');
            $table->string('agama');
            $table->string('pekerjaan');

            $table->text('alamat');
            $table->text('keperluan');

            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');

            $table->unsignedBigInteger('id_user')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_penghasilan');
    }
};