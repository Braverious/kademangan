<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->insert([
            [
                'id_user' => 1,
                'nama_lengkap' => 'Kelurahan Kademangan',
                'nip' => null,
                'jabatan_id' => null,
                'username' => 'superadmin',
                'password' => '$2y$10$rJ3kkPFOdVPyKv8UX8SYMer75wf769CXvxoGvB9HoBrP4oG4Em2H6',
                'foto' => '1776493013_bOCgVAy7WJjSHRgH6G9WFqg9jVlcZWBDvVKqz0fP.png',
                'id_level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'nama_lengkap' => 'Madsuki, S.H.',
                'nip' => '196911051989121002',
                'jabatan_id' => 1,
                'username' => 'madsuki',
                'password' => '$2y$10$b5vRbZ5M3rj11uFp4fXi9.tUSLf2Dgym6jBzWRqJDughAWE1wwXUC',
                'foto' => '1776655473_vqvX0mcjG3jquN7WdVvWwwqNmgavYA3ar8CF2veV.png',
                'id_level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 3,
                'nama_lengkap' => 'Muhammad Djupri, S.KOM., M.AK',
                'nip' => '198507222011011012',
                'jabatan_id' => 2,
                'username' => 'djupri',
                'password' => '$2y$10$b5vRbZ5M3rj11uFp4fXi9.tUSLf2Dgym6jBzWRqJDughAWE1wwXUC',
                'foto' => 'default.jpg',
                'id_level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
