<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jangkauan extends Model
{
    protected $table = 'jangkauan';

    protected $fillable = [
        'jumlah_kk',
        'jumlah_penduduk',
        'jumlah_rw',
        'jumlah_rt',
        'icon_kk',
        'icon_penduduk',
        'icon_rw',
        'icon_rt'
    ];

    public $timestamps = false;
}
