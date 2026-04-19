<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;

    // 1. Nama tabel tunggal sesuai database Anda
    protected $table = 'user';

    // 2. Tentukan Primary Key kustom
    protected $primaryKey = 'id_user';

    // 3. Matikan timestamps karena di struktur tabel Anda tidak ada created_at/updated_at
    public $timestamps = false;

    // 4. Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama_lengkap',
        'nip',
        'jabatan_id',
        'username',
        'password',
        'foto',
        'id_level',
    ];

    // 5. Sembunyikan data sensitif saat model dipanggil
    protected $hidden = [
        'password',
    ];

    /**
     * Karena Laravel secara default mencari kolom 'id', 
     * kita pastikan dia tahu id_user adalah kuncinya.
     */
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    /**
     * Relasi ke tabel Level
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    public function relasiJabatan()
    {
        // Relasi belongsTo(NamaModel, foreign_key_di_user, primary_key_di_referensi)
        return $this->belongsTo(RefJabatan::class, 'jabatan_id', 'id');
    }
}