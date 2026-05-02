<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CitizenDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) return $guard;

        $title = "Manajemen Warga";
        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => route('admin.settings.citizens.index')],
        ];

        $query = User::with(['citizenDetail', 'creator'])
            ->where('level_id', 3);
            
        // 1. Pencarian NIK atau Nama
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('username', 'LIKE', "%$q%")
                    ->orWhereHas('citizenDetail', function ($cd) use ($q) {
                        $cd->where('full_name', 'LIKE', "%$q%");
                    });
            });
        }

        // 2. Filter RT (Otomatis pad ke 3 digit jika angka)
        if ($request->filled('rt')) {
            $rt = str_pad($request->rt, 3, '0', STR_PAD_LEFT);
            $query->whereHas('citizenDetail', fn($cd) => $cd->where('rt', $rt));
        }

        // 3. Filter RW (Otomatis pad ke 3 digit jika angka)
        if ($request->filled('rw')) {
            $rw = str_pad($request->rw, 3, '0', STR_PAD_LEFT);
            $query->whereHas('citizenDetail', fn($cd) => $cd->where('rw', $rw));
        }

        $query = User::with(['citizenDetail', 'creator'])->where('role', 'citizen');
        $user_list = $query->latest()->simplePaginate(15)->appends($request->query());

        return view('admin.warga.index', compact('title', 'user_list', 'breadcrumbs', 'query'));
    }

    public function create()
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) return $guard;

        $title = "Tambah Warga";
        $breadcrumbs = [
            ['label' => 'Manajemen Warga', 'url' => route('admin.settings.citizens.index')],
            ['label' => $title, 'url' => null],
        ];

        return view('admin.warga.create', compact('title', 'breadcrumbs'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) return $guard;

        $user = User::findOrFail($id);

        if ($user->is_active) {
            // Proses Blokir
            $request->validate([
                'reason' => 'required|string|min:5'
            ]);

            $user->update([
                'is_active' => false,
                'inactive_reason' => $request->reason
            ]);

            return redirect()->back()->with('success', 'Akun warga berhasil dinonaktifkan.');
        } else {
            // Proses Aktifkan Kembali
            $user->update([
                'is_active' => true,
                'inactive_reason' => null
            ]);

            return redirect()->back()->with('success', 'Akun warga berhasil diaktifkan kembali.');
        }
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nik'           => 'required|numeric|digits:16|unique:users,username',
            'full_name'     => 'required|string|max:150',
            'password'      => 'required|min:6',
            'birth_place'   => 'required|string|max:100',
            'birth_date'    => 'required|date',
            'nationality'   => 'required|string|max:50',
            'rt'            => 'required|string|max:3',
            'rw'            => 'required|string|max:3',
            'no_kk'         => 'nullable|numeric|digits:16',
            'address'       => 'nullable|string|min:5|max:255',
            'religion'      => 'nullable|in:Islam,Kristen,Katolik,Hindu,Budha,Khonghucu',
            'marital_status' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        ]);

        DB::beginTransaction();
        try {
            // 2. Simpan ke tabel USERS (Header)
            $user = User::create([
                'username'   => $request->nik,
                'password'   => Hash::make($request->password),
                'role'       => 'citizen',
                'level_id'   => 3,
                'is_active'  => true,
                'created_by' => User::setCreator(),
            ]);

            // 3. Simpan ke tabel CITIZEN_DETAILS (Detail)
            CitizenDetail::create([
                'user_id'           => $user->id,
                'nik'               => $request->nik,
                'full_name'         => $request->full_name,
                'birth_place'       => $request->birth_place,
                'birth_date'        => $request->birth_date,
                'religion'          => $request->religion,
                'marital_status'    => $request->marital_status,
                'occupation'        => $request->occupation,
                'nationality'       => $request->nationality,
                'ktp_expiry'        => $request->ktp_expiry ?? 'Seumur Hidup',
                'no_kk'             => $request->no_kk,
                'family_head_name'  => $request->family_head_name,
                'address'           => $request->address,
                'rt'                => $request->rt,
                'rw'                => $request->rw,
                'village'           => $request->village,
                'district'          => $request->district,
                'city'              => $request->city,
            ]);

            DB::commit();
            return redirect()->route('admin.settings.citizens.index')->with('success', 'Data warga berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            // Log error jika diperlukan: \Log::error($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) return $guard;

        $user = User::with('citizenDetail')->findOrFail($id);

        $title = "Edit Data Warga";
        $breadcrumbs = [
            ['label' => 'Manajemen Warga', 'url' => route('admin.settings.citizens.index')],
            ['label' => $title, 'url' => null],
        ];

        return view('admin.warga.edit', compact('title', 'user', 'breadcrumbs'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // 1. Validasi (NIK unik kecuali untuk user ini sendiri)
        $request->validate([
            'nik'           => 'required|numeric|digits:16|unique:users,username,' . $id,
            'full_name'     => 'required|string|max:150',
            'password'      => 'nullable|min:6', // Password opsional saat edit
            'birth_place'   => 'required|string|max:100',
            'birth_date'    => 'required|date',
            'nationality'   => 'required|string|max:50',
            'rt'            => 'required|string|max:3',
            'rw'            => 'required|string|max:3',
        ]);

        DB::beginTransaction();
        try {
            // 2. Update Tabel USERS (Header)
            $user->update([
                'username' => $request->nik,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);

            // 3. Update Tabel CITIZEN_DETAILS (Detail)
            $user->citizenDetail()->update([
                'nik'               => $request->nik,
                'full_name'         => $request->full_name,
                'birth_place'       => $request->birth_place,
                'birth_date'        => $request->birth_date,
                'religion'          => $request->religion,
                'marital_status'    => $request->marital_status,
                'occupation'        => $request->occupation,
                'nationality'       => $request->nationality,
                'ktp_expiry'        => $request->ktp_expiry,
                'no_kk'             => $request->no_kk,
                'family_head_name'  => $request->family_head_name,
                'address'           => $request->address,
                'rt'                => $request->rt,
                'rw'                => $request->rw,
                'village'           => $request->village,
                'district'          => $request->district,
                'city'              => $request->city,
            ]);

            DB::commit();
            return redirect()->route('admin.settings.citizens.index')->with('success', 'Data warga berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $guard = $this->ensureSuperadmin();
        if ($guard) return $guard;

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // 1. Hapus detail warga terlebih dahulu
            // Kita gunakan delete() pada relasi agar lebih aman
            if ($user->citizenDetail) {
                $user->citizenDetail()->delete();
            }

            // 2. Hapus akun user
            $user->delete();

            DB::commit();
            return redirect()->route('admin.settings.citizens.index')
                ->with('success', 'Data warga dan akun aksesnya berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    private function ensureSuperadmin()
    {
        if (Auth::user()->level_id != 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak!');
        }
        return null;
    }
}
