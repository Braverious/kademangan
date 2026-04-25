<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratBelumBekerjaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('surat_belum_bekerja')->insert([
            [
                'nomor_surat_rt' => '001/RT/2026',
                'tanggal_surat_rt' => '2026-04-01',
                'dokumen_pendukung' => json_encode([]),
                'nomor_surat' => null,

                'nama_pemohon' => 'Budi Santoso',
                'tempat_lahir' => 'Tangerang',
                'tanggal_lahir' => '2000-01-01',
                'jenis_kelamin' => 'Laki-laki',

                'nik' => '1234567890123456',
                'telepon_pemohon' => '08123456789',

                'warganegara' => 'Indonesia',
                'agama' => 'Islam',
                'pekerjaan' => 'Belum Bekerja',

                'alamat' => 'Jl. Contoh Alamat No.1',
                'keperluan' => 'Melamar pekerjaan',

                'status' => 'Pending',
                'id_user' => 1,

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}