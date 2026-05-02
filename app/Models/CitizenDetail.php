<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitizenDetail extends Model
{
    protected $table = 'citizen_details';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nik',
        'full_name',
        'birth_place',
        'birth_date',
        'religion',
        'marital_status',
        'occupation',
        'nationality',
        'ktp_expiry',
        'no_kk',
        'family_head_name',
        'address',
        'rt',
        'rw',
        'village',
        'district',
        'city',
        'province'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
