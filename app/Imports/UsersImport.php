<?php

namespace App\Imports;

use App\Models\StaffDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class UsersImport implements OnEachRow, WithHeadingRow, SkipsEmptyRows
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        // 1. Cek Duplikasi Username
        $existingUser = User::where('username', $data['username'])->first();
        if ($existingUser) {
            return null; // Lewati jika user sudah ada
        }

        $defaultPassword = now()->format('d-m-Y');
        // Tentukan level (Default 2 jika kosong)
        $levelId = (empty($data['level_id']) || $data['level_id'] == 0) ? 2 : $data['level_id'];

        // 2. Jalankan Transaction (Wajib untuk multi-tabel)
        DB::transaction(function () use ($data, $defaultPassword, $levelId) {
            // A. Simpan ke tabel users (Header)
            $user = User::create([
                'username' => $data['username'],
                'password' => Hash::make($defaultPassword),
                'role'     => 'staff',
                'level_id' => $levelId,
                'created_by' => Auth::id() ?? 'sysadmin',
                'is_active'  => true,
            ]);

            // B. Simpan ke tabel staff_details (Detail)
            StaffDetail::create([
                'user_id'    => $user->id, // Mengambil ID yang baru dibuat
                'full_name'  => $data['nama_lengkap'],
                'nip'        => $data['nip'] ?? null,
                'jabatan_id' => $data['jabatan_id'] ?? null,
                'photo'      => 'default.jpg',
            ]);
        });
    }
}
