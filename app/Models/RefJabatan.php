<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefJabatan extends Model
{
    protected $table = 'ref_jabatan';
    
    // Matikan timestamps karena di tabelmu tidak ada created_at/updated_at
    public $timestamps = false; 

    protected $fillable = [
        'nama',
        'urut',
        'is_active',
    ];
}