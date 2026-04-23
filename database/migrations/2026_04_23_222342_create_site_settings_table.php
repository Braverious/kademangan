<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->increments('id'); // int, primary key
            $table->mediumText('about_html')->nullable();
            $table->mediumText('related_links')->nullable();
            $table->mediumText('social_links')->nullable();
            $table->string('favicon', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('youtube_link', 255)->nullable();
            
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};