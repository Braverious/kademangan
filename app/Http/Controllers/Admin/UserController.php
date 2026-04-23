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
        $guard = $this->ensureSuperadmin();
        if ($guard) {
            return $guard;
        }

        $title = "Manajemen User";

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => route('admin.settings.users.index')],
        ];

        $user_list = User::with(['level', 'relasiJabatan'])->get();
        $levels = Level::all();
        $jabatans = RefJabatan::where('is_active', 1)->orderBy('urut', 'ASC')->get();

        return view('admin.users.users', compact('title', 'user_list', 'levels', 'jabatans', 'breadcrumbs'));
    }

    public function create()
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) {
            return $guard;
        }

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => route('admin.settings.index')],
            ['label' => 'Manajemen User', 'url' => route('admin.settings.users.index')],
            ['label' => 'Tambah User', 'url' => null],
        ];

        return view('admin.users.create', [
            'title' => 'Tambah User',
            'levels' => Level::all(),
            'jabatans' => RefJabatan::where('is_active', 1)->orderBy('urut', 'ASC')->get(),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function edit($id)
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) {
            return $guard;
        }

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => route('admin.settings.index')],
            ['label' => 'Manajemen User', 'url' => route('admin.settings.users.index')],
            ['label' => 'Edit User', 'url' => null],
        ];
        return view('admin.users.edit', [
            'title' => 'Edit User',
            'user' => User::findOrFail($id),
            'levels' => Level::all(),
            'jabatans' => RefJabatan::where('is_active', 1)->orderBy('urut', 'ASC')->get(),
            'breadcrumbs' => $breadcrumbs,
        ]);
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

        return redirect()->route('admin.settings.users.index')->with('success', 'User baru berhasil ditambahkan.');
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

        return redirect()->route('admin.settings.users.index')->with('success', 'Data User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // 1. BLOKIR MUTLAK: Jika yang dihapus adalah ID 1 (Kelurahan Kademangan)
        if ($id == 1) {
            return redirect()->route('admin.settings.users.index')->with('error', 'Akses Ditolak! Akun Superadmin Master tidak boleh dihapus oleh siapapun.');
        }

        // 2. BLOKIR DIRI SENDIRI: Mencegah admin menghapus akunnya sendiri yang sedang dipakai
        if (Auth::id() == $id) {
            return redirect()->route('admin.settings.users.index')->with('error', 'Anda tidak bisa menghapus akun yang sedang Anda gunakan saat ini!');
        }

        // Jika lolos dari 2 blokir di atas, baru eksekusi hapus
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.settings.users.index')->with('success', 'User berhasil dihapus.');
    }

    private function ensureSuperadmin()
    {
        if (Auth::user()->id_level != 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak!');
        }

        return null;
    }
}
