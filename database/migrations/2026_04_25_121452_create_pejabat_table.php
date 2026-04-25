<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pejabat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jabatan_id');
            $table->string('nama', 100);
            $table->string('nip', 25);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pejabat');
    }
};