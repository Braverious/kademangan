<?php

namespace App\Http\Controllers;

class LkkController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Lembaga Kemasyarakatan Kelurahan',
            'cards' => [
                [
                    'icon' => 'fa-solid fa-users',
                    'title' => 'RT dan RW',
                    'desc' => 'Rukun Tetangga dan Rukun Warga sebagai unsur kewilayahan yang membantu pelayanan, koordinasi, dan penyampaian informasi kepada masyarakat.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-hand-holding-heart',
                    'title' => 'PKK',
                    'desc' => 'Pemberdayaan dan Kesejahteraan Keluarga sebagai wadah peran serta masyarakat dalam meningkatkan kesejahteraan keluarga.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-hands-helping',
                    'title' => 'Karang Taruna',
                    'desc' => 'Organisasi kepemudaan di tingkat kelurahan sebagai wadah pengembangan generasi muda, kegiatan sosial, kreativitas, dan kepedulian masyarakat.',
                    'url' => 'https://www.instagram.com/karangtarunakademangan?igsh=MWZzd2VlcGgxaGM5NQ==',
                    'external' => true,
                ],
                [
                    'icon' => 'fa-solid fa-clinic-medical',
                    'title' => 'Posyandu',
                    'desc' => 'Pos Pelayanan Terpadu sebagai layanan kesehatan dasar masyarakat, terutama untuk ibu, bayi, balita, lansia, dan keluarga.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-project-diagram',
                    'title' => 'LPM',
                    'desc' => 'Lembaga Pemberdayaan Masyarakat sebagai mitra kelurahan dalam perencanaan, pelaksanaan, dan pengawasan pembangunan wilayah.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-mosque',
                    'title' => 'MUI Kelurahan',
                    'desc' => 'Majelis Ulama Indonesia tingkat kelurahan sebagai wadah pembinaan, konsultasi, dan pelayanan keagamaan bagi masyarakat.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-mosque',
                    'title' => 'DMI Kelurahan',
                    'desc' => 'Dewan Masjid Indonesia tingkat kelurahan yang berperan dalam pembinaan, pengembangan, dan pemberdayaan fungsi masjid.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-quran',
                    'title' => 'LPTQ Kelurahan',
                    'desc' => 'Lembaga Pengembangan Tilawatil Qur’an sebagai wadah pembinaan seni baca, hafalan, pemahaman, dan pengamalan Al-Qur’an.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-book-open',
                    'title' => 'Pengajian Al Hidayah',
                    'desc' => 'Kelompok atau majelis pengajian masyarakat sebagai wadah pembinaan keagamaan, pembelajaran, dan silaturahmi warga.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-recycle',
                    'title' => 'TPS3R dan Bank Sampah',
                    'desc' => 'Tempat Pengolahan Sampah Reduce, Reuse, Recycle serta Bank Sampah sebagai upaya pengelolaan sampah dan pelestarian lingkungan.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-seedling',
                    'title' => 'KWT dan Poktan',
                    'desc' => 'Kelompok Wanita Tani dan Kelompok Tani sebagai wadah kegiatan pertanian, ketahanan pangan, penghijauan, dan pemberdayaan masyarakat.',
                    'url' => '#',
                    'external' => false,
                ],
                [
                    'icon' => 'fa-solid fa-coins',
                    'title' => 'Koperasi Merah Putih',
                    'desc' => 'Koperasi Kelurahan Merah Putih sebagai wadah pemberdayaan ekonomi, penguatan usaha warga, dan peningkatan kesejahteraan masyarakat.',
                    'url' => 'https://www.instagram.com/kkmp_kademangan?igsh=MWxsOXNhNXEzaGlsYg==',
                    'external' => true,
                ],
            ],
        ];

        return view('lkk.index', compact('data'));
    }
}