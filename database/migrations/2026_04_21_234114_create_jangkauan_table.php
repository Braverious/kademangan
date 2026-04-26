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
        Schema::create('jangkauan', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_kk')->default(0);
            $table->integer('jumlah_penduduk')->default(0);
            $table->integer('jumlah_rw')->default(0);
            $table->integer('jumlah_rt')->default(0);

            $table->string('icon_kk')->nullable();
            $table->string('icon_penduduk')->nullable();
            $table->string('icon_rw')->nullable();
            $table->string('icon_rt')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coverage_stats');
    }
};
