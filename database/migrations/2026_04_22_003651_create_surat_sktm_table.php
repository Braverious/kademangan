<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_sktm', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_surat_rt', 100);
            $table->date('tanggal_surat_rt');

            $table->text('dokumen_pendukung')->nullable();

            $table->string('nomor_surat', 100)->nullable();

            $table->string('nama_pemohon', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');

            $table->string('nik', 16);

            $table->string('telepon_pemohon', 20)->nullable();

            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);

            $table->string('warganegara', 50);
            $table->string('agama', 50);
            $table->string('pekerjaan', 100);

            $table->string('nama_orang_tua', 100);

            $table->text('alamat');

            $table->string('id_dtks', 50)->nullable();

            $table->string('penghasilan_bulanan', 100);

            $table->text('keperluan');

            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])
                ->default('Pending');

            $table->foreignId('id_user')->nullable()->constrained('user', 'id_user')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_sktm');
    }
};
