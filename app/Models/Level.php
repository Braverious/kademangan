<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    // Relasi balik ke tabel User (Opsional, tapi good practice)
    public function users()
    {
        return $this->hasMany(User::class, 'id_level', 'id_level');
    }
}