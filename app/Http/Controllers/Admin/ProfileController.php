<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile', [
            'title' => 'Profil Saya',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username' => 'required|string|max:50',
            'password_baru' => 'nullable|min:6',
            'konfirmasi_password' => 'same:password_baru',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'konfirmasi_password.same' => 'Konfirmasi password baru tidak cocok!',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 5MB.'
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;

        // Jika user mengisi kolom password baru
        if ($request->filled('password_baru')) {

            // 1. Validasi tambahan: Wajib isi password lama, password baru harus beda
            $request->validate([
                'password_lama' => 'required',
                'password_baru' => 'required|min:6|different:password_lama',
                'konfirmasi_password' => 'required|same:password_baru',
            ], [
                'password_lama.required' => 'Password lama wajib diisi jika ingin mengubah password.',
                'password_baru.different' => 'Password baru tidak boleh sama dengan password saat ini!',
                'konfirmasi_password.same' => 'Konfirmasi password tidak cocok!'
            ]);

            // 2. Cek apakah ketikan 'password_lama' cocok dengan yang ada di database
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->with('error', 'Password lama yang Anda masukkan salah!');
            }

            // 3. Jika aman, baru ubah passwordnya
            $user->password = Hash::make($request->password_baru);
        }
        if ($request->hasFile('foto')) {
            if ($user->foto && $user->foto !== 'default.jpg') {
                $oldPath = public_path('uploads/profil/' . $user->foto);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->hashName();
            $file->move(public_path('uploads/profil'), $filename);

            $user->foto = $filename;
        }

        if ($user->save()) {
            return back()->with('success', 'Profil berhasil diperbarui.');
        }

        return back()->with('error', 'Gagal memperbarui profil.');
    }
}
