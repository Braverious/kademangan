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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Ini otomatis BIGINT UNSIGNED AUTO_INCREMENT
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['staff', 'citizen']);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Staff Details
        Schema::create('staff_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('nip')->unique()->nullable();
            $table->string('full_name');
            $table->integer('jabatan_id')->nullable();
            $table->string('photo')->nullable();
        });

        Schema::create('citizen_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            // Data Diri
            $table->char('nik', 16)->unique();
            $table->string('full_name');
            $table->string('birth_place', 50)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('religion', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'])->nullable();
            $table->enum('marital_status', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('nationality', 50)->default('WNI');
            $table->string('ktp_expiry', 50)->default('Seumur Hidup');

            // Data Kartu Keluarga
            $table->char('no_kk', 16);
            $table->string('family_head_name')->nullable();
            $table->text('address')->nullable();
            $table->char('rt', 3)->nullable();
            $table->char('rw', 3)->nullable();
            $table->string('village', 50)->default('Kademangan');
            $table->string('district', 50)->default('Setu');
            $table->string('city', 50)->default('Tangerang Selatan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_details');
        Schema::dropIfExists('staff_details');
        Schema::dropIfExists('users');
    }
};
