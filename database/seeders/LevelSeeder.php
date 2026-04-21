<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('level')->insert([
            ['id_level' => 1, 'nama_level' => 'Superadmin'],
            ['id_level' => 2, 'nama_level' => 'Admin/Staff'],
        ]);
    }
}
