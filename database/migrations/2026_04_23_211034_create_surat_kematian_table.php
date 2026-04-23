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
        Schema::create('surat_kematian', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nik', 16);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('agama', 50);
            $table->string('pekerjaan', 150);
            $table->text('alamat');
            $table->string('hari_meninggal', 20);
            $table->date('tanggal_meninggal');
            $table->time('jam_meninggal');
            $table->string('tempat_meninggal', 150);
            $table->string('sebab_meninggal', 200);
            $table->string('tempat_pemakaman', 200);
            $table->string('pelapor_nama', 255);
            $table->string('pelapor_tempat_lahir', 100);
            $table->date('pelapor_tanggal_lahir');
            $table->string('pelapor_agama', 50);
            $table->string('pelapor_pekerjaan', 150);
            $table->string('pelapor_nik', 16);
            $table->string('pelapor_no_telepon', 30);
            $table->text('pelapor_alamat');
            $table->string('pelapor_hubungan', 50);
            $table->string('nomor_surat_rt', 100)->nullable();
            $table->date('tanggal_surat_rt')->nullable();
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
        Schema::dropIfExists('surat_kematian');
    }
};
