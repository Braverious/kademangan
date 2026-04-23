<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cek apakah username sudah ada agar tidak error duplicate
        $existingUser = User::where('username', $row['username'])->first();
        if ($existingUser) {
            return null; // Skip jika user sudah ada
        }

        return new User([
            // Pastikan penamaan key array sesuai dengan judul kolom di Excel
            'nama_lengkap' => $row['nama_lengkap'],
            'username'     => $row['username'],
            'password'     => Hash::make($row['password']),
            'id_level'     => $row['id_level'],
            'nip'          => $row['nip'] ?? null,
            'jabatan_id'   => $row['jabatan_id'] ?? null,
            'foto'         => 'default.jpg', // Default sesuai struktur tabel
        ]);
    }
}