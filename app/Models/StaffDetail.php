<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffDetail extends Model
{
    protected $table = 'staff_details';
    public $timestamps = false; // Karena di migration kita tidak buat timestamps untuk detail

    protected $fillable = [
        'user_id',
        'nip',
        'full_name',
        'jabatan_id',
        'photo',
    ];

    public function relasiJabatan()
    {
        return $this->belongsTo(RefJabatan::class, 'jabatan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
