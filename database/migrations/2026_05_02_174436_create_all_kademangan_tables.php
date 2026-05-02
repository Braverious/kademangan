<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. TABEL MASTER & REFERENSI
        Schema::create('level', function (Blueprint $table) {
            $table->id();
            $table->string('nama_level', 50);
        });

        Schema::create('ref_jabatan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100)->unique();
            $table->unsignedTinyInteger('urut')->default(0);
            $table->boolean('is_active')->default(true);
        });

        // 2. TABEL USERS (Dimodifikasi dari default Laravel)
        // Catatan: Pastikan migration bawaan Laravel (create_users_table) dihapus agar tidak bentrok
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('notelp', 15)->nullable();
            $table->enum('role', ['staff', 'citizen']);
            $table->foreignId('level_id')->nullable()->constrained('level', 'id');
            $table->string('created_by', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('inactive_reason')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel user (Legacy/Lama - Tetap dibuat sesuai SQL)
        Schema::create('user', function (Blueprint $table) {
            $table->integer('id_user', true);
            $table->string('nama_lengkap', 100);
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('foto', 100)->default('default.jpg');
            $table->foreignId('id_level')->constrained('level', 'id');
            $table->string('nip', 25)->nullable();
            $table->integer('jabatan_id')->nullable();
            $table->timestamps();
        });

        // 3. TABEL DETAIL PENGGUNA & LOG
        Schema::create('citizen_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->char('nik', 16)->unique();
            $table->string('full_name', 100);
            $table->string('birth_place', 50)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('religion', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'])->nullable();
            $table->enum('marital_status', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('nationality', 50)->default('WNI');
            $table->string('ktp_expiry', 50)->default('Seumur Hidup');
            $table->char('no_kk', 16);
            $table->string('family_head_name', 100)->nullable();
            $table->text('address')->nullable();
            $table->char('rt', 3)->nullable();
            $table->char('rw', 3)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('village', 50)->default('Kademangan');
            $table->string('district', 50)->default('Setu');
            $table->string('city', 50)->default('Tangerang Selatan');
        });

        Schema::create('staff_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nip', 30)->unique()->nullable();
            $table->string('full_name', 100);
            $table->integer('jabatan_id')->nullable();
            $table->string('photo', 255)->nullable();
        });

        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('username')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('location')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('device', 50)->nullable();
            $table->enum('status', ['SUCCESS', 'FAILED']);
            $table->timestamps();
        });

        // 4. TABEL KONTEN WEBSITE & PENGATURAN
        Schema::create('berita', function (Blueprint $table) {
            $table->increments('id_berita');
            $table->string('judul_berita');
            $table->string('slug_berita');
            $table->text('isi_berita');
            $table->enum('kategori', ['Kegiatan', 'Pengumuman', 'Layanan', 'Umum'])->default('Umum');
            $table->string('gambar', 100);
            $table->dateTime('tgl_publish')->useCurrent();
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('chatbot_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->timestamps();
        });

        Schema::create('galeri', function (Blueprint $table) {
            $table->increments('id_galeri');
            $table->string('judul_foto');
            $table->string('foto', 100);
            $table->dateTime('tgl_upload')->useCurrent();
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('jangkauan', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jumlah_kk')->default(0);
            $table->integer('jumlah_penduduk')->default(0);
            $table->integer('jumlah_rw')->default(0);
            $table->integer('jumlah_rt')->default(0);
            $table->string('icon_kk')->nullable();
            $table->string('icon_penduduk')->nullable();
            $table->string('icon_rw')->nullable();
            $table->string('icon_rt')->nullable();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('layanan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul', 120);
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->string('slug', 100);
            $table->boolean('is_active');
            $table->timestamp('created_by')->useCurrent()->nullable();
            $table->dateTime('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->nullable();
        });

        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->text('isi');
            $table->enum('tipe', ['info', 'peringatan', 'penting'])->default('info');
            $table->dateTime('mulai_tayang')->useCurrent();
            $table->dateTime('berakhir_tayang')->nullable();
            $table->enum('status', ['draft', 'publish'])->default('publish');
            $table->string('created_by', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('running_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('position', ['top', 'bottom']);
            $table->string('content');
            $table->enum('direction', ['left', 'right'])->default('left');
            $table->unsignedTinyInteger('speed')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->mediumText('about_html')->nullable();
            $table->mediumText('related_links')->nullable();
            $table->mediumText('social_links')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->text('home_title')->nullable();
            $table->text('home_description')->nullable();
            $table->string('youtube_link')->nullable();
            $table->json('section_order')->nullable();
            $table->timestamps();
            $table->integer('user_id')->nullable();
        });

        Schema::create('uploadvideo', function (Blueprint $table) {
            $table->integer('id_konfigurasi', true);
            $table->string('nama_konfigurasi', 100);
            $table->text('nilai_konfigurasi');
        });

        // 5. TABEL SURAT MENYURAT
        $suratCommonCols = function (Blueprint $table) {
            $table->string('nomor_surat_rt', 100)->nullable();
            $table->date('tanggal_surat_rt')->nullable();
            $table->text('dokumen_pendukung')->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        };

        Schema::create('surat_belum_bekerja', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
            $table->string('nama_pemohon', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->string('warganegara', 50);
            $table->string('agama', 50);
            $table->string('pekerjaan', 100);
            $table->text('alamat');
            $table->text('keperluan');
            $suratCommonCols($table);
        });

        Schema::create('surat_sktm', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
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
            $suratCommonCols($table);
        });

        Schema::create('surat_penghasilan', function (Blueprint $table) use ($suratCommonCols) {
            $table->increments('id');
            $table->string('nama_pemohon', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nik', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->string('warganegara', 50);
            $table->string('agama', 50);
            $table->string('pekerjaan', 100);
            $table->text('alamat');
            $table->text('keperluan');
            $suratCommonCols($table);
        });

        Schema::create('surat_belum_memiliki_rumah', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
            $table->string('nama_pemohon');
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
            $suratCommonCols($table);
        });

        Schema::create('surat_domisili_yayasan', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
            $table->string('nama_penanggung_jawab', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('nik', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('kewarganegaraan', 50);
            $table->string('agama', 50);
            $table->text('alamat_pemohon');
            $table->string('nama_organisasi');
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
            $suratCommonCols($table);
        });

        Schema::create('surat_kematian', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
            $table->string('nama');
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
            $table->string('pelapor_nama');
            $table->string('pelapor_tempat_lahir', 100);
            $table->date('pelapor_tanggal_lahir');
            $table->string('pelapor_agama', 50);
            $table->string('pelapor_pekerjaan', 150);
            $table->string('pelapor_nik', 16);
            $table->string('pelapor_no_telepon', 30);
            $table->text('pelapor_alamat');
            $table->string('pelapor_hubungan', 50);
            $suratCommonCols($table);
        });

        Schema::create('surat_kematian_nondukcapil', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
            $table->string('nama_ahli_waris');
            $table->string('nik_ahli_waris', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat_ahli_waris');
            $table->string('hubungan_ahli_waris', 100);
            $table->string('nama_almarhum');
            $table->string('nik_almarhum', 16);
            $table->string('tempat_meninggal');
            $table->date('tanggal_meninggal');
            $table->text('alamat_almarhum');
            $table->string('keterangan_almarhum')->nullable();
            $table->string('keperluan')->nullable();
            $suratCommonCols($table);
        });

        Schema::create('surat_keterangan_suami_istri', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
            $table->string('nama_pihak_satu');
            $table->string('nik_pihak_satu', 16);
            $table->string('telepon_pemohon', 20)->nullable();
            $table->string('tempat_lahir_pihak_satu', 100);
            $table->date('tanggal_lahir_pihak_satu');
            $table->enum('jenis_kelamin_pihak_satu', ['Laki-laki', 'Perempuan']);
            $table->string('agama_pihak_satu', 50);
            $table->string('pekerjaan_pihak_satu', 100);
            $table->string('warganegara_pihak_satu', 100);
            $table->text('alamat_pihak_satu');
            $table->string('nama_pihak_dua');
            $table->string('nik_pihak_dua', 16);
            $table->text('alamat_pihak_dua');
            $table->text('keperluan');
            $suratCommonCols($table);
        });

        Schema::create('surat_pengantar_nikah', function (Blueprint $table) use ($suratCommonCols) {
            $table->integer('id', true);
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
            $table->tinyInteger('pria_istri_ke')->unsigned()->nullable();
            
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
            $suratCommonCols($table);
        });
    }

    public function down()
    {
        // Drop tables in reverse dependency order
        Schema::dropIfExists('surat_pengantar_nikah');
        Schema::dropIfExists('surat_keterangan_suami_istri');
        Schema::dropIfExists('surat_kematian_nondukcapil');
        Schema::dropIfExists('surat_kematian');
        Schema::dropIfExists('surat_domisili_yayasan');
        Schema::dropIfExists('surat_belum_memiliki_rumah');
        Schema::dropIfExists('surat_penghasilan');
        Schema::dropIfExists('surat_sktm');
        Schema::dropIfExists('surat_belum_bekerja');
        Schema::dropIfExists('uploadvideo');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('running_texts');
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('jangkauan');
        Schema::dropIfExists('galeri');
        Schema::dropIfExists('chatbot_settings');
        Schema::dropIfExists('berita');
        Schema::dropIfExists('login_logs');
        Schema::dropIfExists('staff_details');
        Schema::dropIfExists('citizen_details');
        Schema::dropIfExists('user');
        Schema::dropIfExists('users');
        Schema::dropIfExists('ref_jabatan');
        Schema::dropIfExists('level');
    }
};