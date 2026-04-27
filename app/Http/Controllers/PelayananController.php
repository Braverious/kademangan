<?php

namespace App\Http\Controllers;

class PelayananController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pelayanan Kelurahan',
            'cards' => [
                [
                    'icon' => 'bi-shield-check',
                    'title' => 'Surat Keterangan Tidak Mampu',
                    'desc' => 'Surat keterangan untuk keperluan keringanan biaya.',
                    'slug' => 'tidak-mampu',
                ],
                [
                    'icon' => 'bi-file-earmark-person',
                    'title' => 'Surat Ket. Belum Bekerja',
                    'desc' => 'Ajukan surat keterangan status belum atau tidak bekerja.',
                    'slug' => 'belum-bekerja',
                ],
                [
                    'icon' => 'bi-building',
                    'title' => 'Surat Domisili Yayasan',
                    'desc' => 'Ajukan surat keterangan domisili untuk organisasi.',
                    'slug' => 'domisili-yayasan',
                ],
                [
                    'icon' => 'bi-house',
                    'title' => 'Surat Belum Memiliki Rumah',
                    'desc' => 'Ajukan surat keterangan bahwa pemohon belum memiliki rumah.',
                    'slug' => 'belum-memiliki-rumah',
                ],
                [
                    'icon' => 'bi-person-x',
                    'title' => 'Surat Keterangan Kematian Dukcapil',
                    'desc' => 'Ajukan surat keterangan resmi tentang kematian seseorang.',
                    'slug' => 'kematian',
                ],
                [
                    'icon' => 'bi-person-x-fill',
                    'title' => 'Surat Kematian (Non Dukcapil)',
                    'desc' => 'Untuk kebutuhan non-dukcapil seperti bank, asuransi, dan keperluan lainnya.',
                    'slug' => 'kematian-nondukcapil',
                ],
                [
                    'icon' => 'bi-people-fill',
                    'title' => 'Surat Keterangan Suami Istri',
                    'desc' => 'Ajukan surat untuk menyatakan status hubungan pernikahan.',
                    'slug' => 'suami-istri',
                ],
                [
                    'icon' => 'bi-suit-heart',
                    'title' => 'Surat Pengantar Nikah',
                    'desc' => 'Ajukan pengantar nikah untuk kebutuhan administrasi pernikahan.',
                    'slug' => 'pengantar-nikah',
                ],
                [
                    'icon' => 'bi-cash-coin',
                    'title' => 'Surat Ket. Penghasilan',
                    'desc' => 'Ajukan surat keterangan penghasilan.',
                    'slug' => 'penghasilan',
                ],
            ],
        ];

        return view('pelayanan.index', compact('data'));
    }
}