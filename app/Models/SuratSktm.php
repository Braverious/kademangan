<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratSktm extends Model
{
    protected $table = 'surat_sktm';

    protected $fillable = [
        'nomor_surat_rt',
        'tanggal_surat_rt',
        'dokumen_pendukung',
        'nomor_surat',
        'nama_pemohon',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'telepon_pemohon',
        'jenis_kelamin',
        'warganegara',
        'agama',
        'pekerjaan',
        'nama_orang_tua',
        'alamat',
        'id_dtks',
        'penghasilan_bulanan',
        'keperluan',
        'status',
        'id_user'
    ];

    protected $casts = [
        'tanggal_surat_rt' => 'date',
        'tanggal_lahir' => 'date',
    ];
}
