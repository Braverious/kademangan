<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    protected $table = 'pejabat';

    protected $fillable = [
        'jabatan_id',
        'nama',
        'nip'
    ];

    // =========================
    // RELASI
    // =========================

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public static function getAllSigners()
    {
        return self::with('jabatan')->get();
    }

    public static function getDefaultSigner()
    {
        $sekre = self::whereHas('jabatan', function ($q) {
            $q->where('nama', 'Sekretaris Kelurahan');
        })->first();

        if ($sekre) return $sekre;

        return self::whereHas('jabatan', function ($q) {
            $q->where('nama', 'like', 'Lurah%');
        })->first();
    }
}