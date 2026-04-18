<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunningText extends Model
{
    protected $table = 'running_texts';

    // Kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'position', 
        'content', 
        'direction', 
        'speed', 
        'is_active'
    ];
}