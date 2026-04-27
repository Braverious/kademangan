<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('layanan')->insert([
            [
                'judul' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Layanan pengajuan surat keterangan bagi warga yang membutuhkan bukti kondisi ekonomi untuk keperluan bantuan, keringanan biaya, pendidikan, kesehatan, atau administrasi lainnya.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'tidak-mampu',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Keterangan Belum Bekerja',
                'deskripsi' => 'Layanan pengajuan surat keterangan bahwa pemohon belum atau tidak sedang bekerja, biasanya digunakan untuk keperluan administrasi melamar kerja, bantuan, pendidikan, atau kebutuhan resmi lainnya.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'belum-bekerja',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Domisili Yayasan',
                'deskripsi' => 'Layanan pengajuan surat keterangan domisili untuk yayasan, organisasi, atau lembaga yang berkedudukan di wilayah kelurahan sebagai pelengkap administrasi legalitas dan kegiatan kelembagaan.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'domisili-yayasan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Belum Memiliki Rumah',
                'deskripsi' => 'Layanan pengajuan surat keterangan bahwa pemohon belum memiliki rumah pribadi, biasanya digunakan untuk keperluan program bantuan perumahan, subsidi, atau administrasi kependudukan lainnya.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'belum-memiliki-rumah',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Keterangan Kematian Dukcapil',
                'deskripsi' => 'Layanan pengajuan surat keterangan kematian yang diperlukan untuk proses administrasi kependudukan di Dukcapil, seperti pelaporan kematian, perubahan data keluarga, atau pengurusan dokumen resmi.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'kematian',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Kematian Non Dukcapil',
                'deskripsi' => 'Layanan pengajuan surat keterangan kematian untuk keperluan non-Dukcapil, seperti pengurusan bank, asuransi, ahli waris, tempat kerja, lembaga pendidikan, atau kebutuhan administrasi lainnya.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'kematian-nondukcapil',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Keterangan Suami Istri',
                'deskripsi' => 'Layanan pengajuan surat keterangan yang menyatakan hubungan suami istri secara administratif, biasanya digunakan untuk kebutuhan perbankan, asuransi, pekerjaan, keluarga, atau keperluan resmi lainnya.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'suami-istri',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Pengantar Nikah',
                'deskripsi' => 'Layanan pengajuan surat pengantar nikah dari kelurahan untuk melengkapi persyaratan administrasi pernikahan, termasuk data calon pengantin dan dokumen pendukung yang dibutuhkan.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'pengantar-nikah',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Surat Keterangan Penghasilan',
                'deskripsi' => 'Layanan pengajuan surat keterangan penghasilan bagi warga yang membutuhkan bukti penghasilan untuk keperluan pendidikan, beasiswa, pinjaman, bantuan sosial, administrasi kerja, atau kebutuhan resmi lainnya.',
                'gambar' => 'layanan/sample.png',
                'slug' => 'penghasilan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}