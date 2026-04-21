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
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap', 100);
            $table->string('nip', 25)->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('username', 50);
            $table->string('password');
            $table->string('foto', 100)->default('default.jpg');
            $table->unsignedBigInteger('id_level');

            $table->timestamps();

            $table->foreign('id_level')->references('id_level')->on('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
