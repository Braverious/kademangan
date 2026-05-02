<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\CitizenDetail;
use App\Models\Level;
use App\Models\RefJabatan;
use App\Models\StaffDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) {
            return $guard;
        }

        $title = "Manajemen Staff";

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => route('admin.settings.staff.index')],
        ];

        $user_list = User::with(['staffDetail', 'staffDetail.relasiJabatan', 'creator'])
            ->whereIn('level_id', [1, 2])
            ->get();
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
            ['label' => 'Manajemen Staff', 'url' => route('admin.settings.staff.index')],
            ['label' => 'Tambah Staff', 'url' => null],
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
            ['label' => 'Manajemen Staff', 'url' => route('admin.settings.staff.index')],
            ['label' => 'Edit Staff', 'url' => null],
        ];
        return view('admin.users.edit', [
            'title' => 'Edit Staff',
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
            'username'     => 'required|string|max:50|unique:users,username',
            'password'     => 'required|min:6',
            // 'role'         => 'required|in:staff,citizen',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel users
            $user = User::create([
                'username'   => $request->username,
                'password'   => Hash::make($request->password),
                'role'       => 'staff',
                'level_id'   => $request->level_id,
                'created_by' => User::setCreator(),
                'is_active'  => true,
            ]);

            // 2. Simpan ke detail staff
            StaffDetail::create([
                'user_id'    => $user->id,
                'full_name'  => $request->nama_lengkap,
                'nip'        => $request->nip,
                'jabatan_id' => $request->jabatan_id,
            ]);

            DB::commit();
            return redirect()->route('admin.settings.staff.index')->with('success', 'Staff berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $level_id = ($id == 1) ? 1 : $request->level_id;

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nip'          => 'nullable|string|max:25',
            'jabatan_id'   => 'nullable|integer',
            'username'     => 'required|string|max:50|unique:users,username,' . $id . ',id',
            'password'     => 'nullable|min:6',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Tabel Users (Header)
            $user->update([
                'username' => $request->username,
                'level_id' => $level_id,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);

            // 2. Update Tabel StaffDetail (Detail)
            $user->staffDetail()->update([
                'full_name'  => $request->nama_lengkap,
                'nip'        => $request->nip,
                'jabatan_id' => $request->jabatan_id,
            ]);

            DB::commit();
            return redirect()->route('admin.settings.staff.index')->with('success', 'Data Staff berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);
        $defaultPass = now()->format('d-m-Y');
        try {
            Excel::import(new UsersImport, $request->file('file_excel'));
            return redirect()->back()->with('success', "Data Staff berhasil diimport! Password default akun baru adalah: $defaultPass");
        } catch (\Exception $e) {
            $message = "Gagal import! <br><br> <strong>Detail Error:</strong> <br> <code>" . $e->getMessage() . "</code>";

            return redirect()->back()->with('error', $message);
        }
    }

    public function destroy($id)
    {
        // 1. BLOKIR MUTLAK: Jika yang dihapus adalah ID 1 (Kelurahan Kademangan)
        if ($id == 1) {
            return redirect()->route('admin.settings.staff.index')->with('success', 'Staff berhasil dihapus.');
        }

        // 2. BLOKIR DIRI SENDIRI: Mencegah admin menghapus akunnya sendiri yang sedang dipakai
        if (Auth::id() == $id) {
            return redirect()->route('admin.settings.staff.index')->with('error', 'Anda tidak bisa menghapus akun yang sedang Anda gunakan saat ini!');
        }

        // Jika lolos dari 2 blokir di atas, baru eksekusi hapus
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.settings.staff.index')->with('success', 'Staff berhasil dihapus.');
    }

    private function ensureSuperadmin()
    {
        if (Auth::user()->level_id != 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak!');
        }

        return null;
    }
}
