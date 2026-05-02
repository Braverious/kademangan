<?php

namespace App\Models;

use App\Models\CitizenDetail;
use App\Models\StaffDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'notelp',
        'role',
        'level_id',
        'created_by',
        'is_active',
        'inactive_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function setCreator()
    {
        if (Auth::check()) {
            // Jika sedang login, berarti dibuat oleh Staff/Admin (simpan ID-nya)
            return Auth::id();
        }

        // Jika tidak login, cek apakah sedang berada di route register
        if (request()->routeIs('auth.register.process')) {
            return 'register';
        }

        // Default jika dibuat melalui SQL manual / Seeder / Command line
        return 'sysadmin';
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Relasi ke detail Staff
    public function staffDetail()
    {
        return $this->hasOne(StaffDetail::class, 'user_id');
    }

    // Relasi ke detail Warga
    public function citizenDetail()
    {
        return $this->hasOne(CitizenDetail::class, 'user_id');
    }

    public function level()
    {
        // FK di users adalah level_id, PK di level adalah id
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
