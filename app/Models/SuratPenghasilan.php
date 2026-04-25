<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPenghasilan extends Model
{
    use HasFactory;

    protected $table = 'surat_penghasilan';

    protected $fillable = [
        'nomor_surat_rt',
        'tanggal_surat_rt',
        'dokumen_pendukung',
        'nomor_surat',
        'nama_pemohon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
        'telepon_pemohon',
        'warganegara',
        'agama',
        'pekerjaan',
        'alamat',
        'keperluan',
        'status',
        'id_user',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_surat_rt' => 'date',
    ];
}