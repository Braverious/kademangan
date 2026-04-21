<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('layanan')->insert([
            [
                'judul' => 'Tangsel',
                'deskripsi' => 'Logo Tangerang Selatan',
                'gambar' => 'layanan/sample.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
