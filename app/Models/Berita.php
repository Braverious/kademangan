<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'judul_berita',
        'slug_berita',
        'isi_berita',
        'kategori',
        'gambar',
        'tgl_publish',
        'id_user',
    ];

    public $timestamps = false;

    protected $casts = [
        'tgl_publish' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
