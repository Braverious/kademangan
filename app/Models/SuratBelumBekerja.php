<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratBelumBekerja extends Model
{
    protected $table = 'surat_belum_bekerja';

    protected $fillable = [
        'nomor_surat_rt',
        'tanggal_surat_rt',
        'nomor_surat',
        'status',
        'telepon_pemohon',
        'nama_pemohon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
        'warganegara',
        'agama',
        'pekerjaan',
        'alamat',
        'keperluan',
        'dokumen_pendukung',
        'user_id'
    ];

    protected $casts = [
        'dokumen_pendukung' => 'array',
        'tanggal_surat_rt' => 'date',
        'tanggal_lahir' => 'date',
    ];
}
