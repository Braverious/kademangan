<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratPenghasilan;

class SuratPenghasilanSeeder extends Seeder
{
    public function run()
    {
        SuratPenghasilan::create([
            'nomor_surat_rt' => '001/RT01',
            'tanggal_surat_rt' => now(),

            'nama_pemohon' => 'Budi Santoso',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1995-05-10',
            'jenis_kelamin' => 'Laki-laki',

            'nik' => '1234567890123456',
            'telepon_pemohon' => '08123456789',

            'warganegara' => 'Indonesia',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',

            'alamat' => 'Jl. Contoh No.1',
            'keperluan' => 'Pengajuan bantuan',

            'status' => 'Pending',
        ]);
    }
}