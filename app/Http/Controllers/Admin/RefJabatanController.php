<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RefJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RefJabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorizeSuperadmin();

        return view('admin.jabatan.jabatan', [
            'title' => 'Manajemen Jabatan',
            'jabatans' => RefJabatan::withCount('users')
                ->orderBy('urut')
                ->orderBy('nama')
                ->get(),
        ]);
    }

    public function create()
    {
        $this->authorizeSuperadmin();

        return view('admin.jabatan.tambah', [
            'title' => 'Tambah Jabatan',
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeSuperadmin();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', Rule::unique('ref_jabatan', 'nama')],
            'urut' => ['required', 'integer', 'min:0', 'max:255', Rule::unique('ref_jabatan', 'urut')],
            'is_active' => ['nullable', 'boolean'],
        ]);

        RefJabatan::create([
            'nama' => $validated['nama'],
            'urut' => $validated['urut'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeSuperadmin();

        return view('admin.jabatan.edit', [
            'title' => 'Edit Jabatan',
            'jabatan' => RefJabatan::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeSuperadmin();

        $jabatan = RefJabatan::findOrFail($id);

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ref_jabatan', 'nama')->ignore($jabatan->id),
            ],
            'urut' => [
                'required',
                'integer',
                'min:0',
                'max:255',
                Rule::unique('ref_jabatan', 'urut')->ignore($jabatan->id),
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $jabatan->update([
            'nama' => $validated['nama'],
            'urut' => $validated['urut'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function toggle($id)
    {
        $this->authorizeSuperadmin();

        $jabatan = RefJabatan::findOrFail($id);
        $jabatan->is_active = !$jabatan->is_active;
        $jabatan->save();

        $status = $jabatan->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.jabatan.index')->with('success', "Jabatan berhasil {$status}.");
    }

    public function destroy($id)
    {
        $this->authorizeSuperadmin();

        $jabatan = RefJabatan::withCount('users')->findOrFail($id);

        if ($jabatan->users_count > 0) {
            return redirect()->route('admin.jabatan.index')
                ->with('error', 'Jabatan tidak bisa dihapus karena masih dipakai oleh user. Nonaktifkan saja jika ingin disembunyikan.');
        }

        $jabatan->delete();

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }

    private function authorizeSuperadmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->id_level == 1, 403);
    }
}
