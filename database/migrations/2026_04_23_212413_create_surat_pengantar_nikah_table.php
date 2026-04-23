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
        Schema::create('surat_pengantar_nikah', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_rt', 100);
            $table->date('tanggal_surat_rt');
            $table->text('dokumen_pendukung')->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->string('pria_nama', 150);
            $table->string('pria_nik', 16);
            $table->enum('pria_jenis_kelamin', ['Laki-laki', 'Perempuan'])->default('Laki-laki');
            $table->string('pria_tempat_lahir', 100);
            $table->date('pria_tanggal_lahir');
            $table->string('pria_kewarganegaraan', 50);
            $table->string('pria_agama', 50);
            $table->string('pria_pekerjaan', 100);
            $table->text('pria_alamat');
            $table->enum('pria_status', ['Jejaka', 'Duda', 'Beristri']);
            $table->unsignedTinyInteger('pria_istri_ke')->nullable();
            $table->string('ortu_nama', 150);
            $table->string('ortu_nik', 16)->nullable();
            $table->string('ortu_tempat_lahir', 100)->nullable();
            $table->date('ortu_tanggal_lahir')->nullable();
            $table->string('ortu_kewarganegaraan', 50)->default('Indonesia');
            $table->string('ortu_agama', 50)->nullable();
            $table->string('ortu_pekerjaan', 100)->nullable();
            $table->text('ortu_alamat')->nullable();
            $table->string('wanita_nama', 150);
            $table->string('wanita_nik', 16);
            $table->string('wanita_tempat_lahir', 100);
            $table->date('wanita_tanggal_lahir');
            $table->string('wanita_kewarganegaraan', 50);
            $table->string('wanita_agama', 50);
            $table->string('wanita_pekerjaan', 100);
            $table->text('wanita_alamat');
            $table->enum('wanita_status', ['Perawan', 'Janda']);
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
        Schema::dropIfExists('surat_pengantar_nikah');
    }
};
