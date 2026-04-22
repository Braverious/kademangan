<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratSktmSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('surat_sktm')->insert([
            [
                'nomor_surat_rt' => '001/SKTM/RT01',
                'tanggal_surat_rt' => '2025-11-14',
                'dokumen_pendukung' => json_encode(['dummy1.pdf']),
                'nomor_surat' => '470/001/KDM/2025',
                'nama_pemohon' => 'Agus Setiawan',
                'tempat_lahir' => 'Tangerang',
                'tanggal_lahir' => '1990-07-15',
                'nik' => '3275011507900001',
                'telepon_pemohon' => '081234567890',
                'jenis_kelamin' => 'Laki-laki',
                'warganegara' => 'Indonesia',
                'agama' => 'Islam',
                'pekerjaan' => 'Karyawan Swasta',
                'nama_orang_tua' => 'Budi Setiawan',
                'alamat' => 'Kademangan RT 01 RW 02',
                'id_dtks' => 'DTKS001',
                'penghasilan_bulanan' => 'Rp 1.000.000',
                'keperluan' => 'Pengajuan Beasiswa',
                'status' => 'Disetujui',
                'id_user' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor_surat_rt' => '002/SKTM/RT02',
                'tanggal_surat_rt' => '2025-12-01',
                'dokumen_pendukung' => json_encode(['dummy2.pdf']),
                'nomor_surat' => null,
                'nama_pemohon' => 'Siti Aisyah',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1995-03-20',
                'nik' => '3275011507900002',
                'telepon_pemohon' => '082345678901',
                'jenis_kelamin' => 'Perempuan',
                'warganegara' => 'Indonesia',
                'agama' => 'Islam',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'nama_orang_tua' => 'Ahmad',
                'alamat' => 'Kademangan RT 03 RW 04',
                'id_dtks' => null,
                'penghasilan_bulanan' => 'Rp 500.000',
                'keperluan' => 'Bantuan Sosial',
                'status' => 'Pending',
                'id_user' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
