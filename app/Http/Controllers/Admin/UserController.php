<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\Models\RefJabatan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->id_level != 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak!');
        }

        $title = "Manajemen User";
        
        // Load relasi level dan jabatan sekaligus pakai array
        $user_list = User::with(['level', 'relasiJabatan'])->get();
        
        $levels = Level::all(); 
        
        // Ambil data jabatan yang aktif, urutkan berdasarkan kolom 'urut'
        $jabatans = RefJabatan::where('is_active', 1)->orderBy('urut', 'ASC')->get(); 

        return view('admin.users', compact('title', 'user_list', 'levels', 'jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nip'          => 'nullable|string|max:25',
            'jabatan_id'   => 'nullable|integer', // Kembali jadi integer
            'id_level'     => 'required|integer',
            'username'     => 'required|string|max:50|unique:user,username',
            'password'     => 'required|min:6',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip'          => $request->nip,
            'jabatan_id'   => $request->jabatan_id,
            'id_level'     => $request->id_level,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $id_level = ($id == 1) ? 1 : $request->id_level;

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nip'          => 'nullable|string|max:25',
            'jabatan_id'   => 'nullable|integer', // Kembali jadi integer
            'username'     => 'required|string|max:50|unique:user,username,' . $id . ',id_user',
            'password'     => 'nullable|min:6',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->nip          = $request->nip;
        $user->jabatan_id   = $request->jabatan_id;
        $user->username     = $request->username;
        $user->id_level     = $id_level;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // 1. BLOKIR MUTLAK: Jika yang dihapus adalah ID 1 (Kelurahan Kademangan)
        if ($id == 1) {
            return redirect()->route('admin.users.index')->with('error', 'Akses Ditolak! Akun Superadmin Master tidak boleh dihapus oleh siapapun.');
        }

        // 2. BLOKIR DIRI SENDIRI: Mencegah admin menghapus akunnya sendiri yang sedang dipakai
        if (Auth::id() == $id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun yang sedang Anda gunakan saat ini!');
        }

        // Jika lolos dari 2 blokir di atas, baru eksekusi hapus
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}