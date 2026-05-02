<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile', [
            'title' => 'Profil Saya',
            // Gunakan eager loading agar lebih ringan
            'user' => User::with('staffDetail')->find(Auth::id())
        ]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $staff = $user->staffDetail; // Ambil relasi detail staff

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'password_baru' => 'nullable|min:6',
            'konfirmasi_password' => 'same:password_baru',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'konfirmasi_password.same' => 'Konfirmasi password baru tidak cocok!',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 5MB.'
        ]);

        DB::beginTransaction();
        try {
            // 1. Update data di tabel USERS
            $user->username = $request->username;

            if ($request->filled('password_baru')) {
                // Validasi password lama
                if (!Hash::check($request->password_lama, $user->password)) {
                    return back()->with('error', 'Password lama yang Anda masukkan salah!');
                }
                $user->password = Hash::make($request->password_baru);
            }
            $user->save();

            // 2. Update data di tabel STAFF_DETAILS
            $staff->full_name = $request->nama_lengkap;

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($staff->photo && $staff->photo !== 'default.jpg') {
                    $oldPath = public_path('uploads/profil/' . $staff->photo);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('foto');
                $filename = time() . '_' . $file->hashName();
                $file->move(public_path('uploads/profil'), $filename);

                $staff->photo = $filename; // Kolomnya sekarang 'photo'
            }
            $staff->save();

            DB::commit();
            return back()->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}