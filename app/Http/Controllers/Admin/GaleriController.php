<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // proteksi login
    }

    // LIST
    public function index()
    {
        $data['title'] = "Manajemen Galeri";
        $data['galeri_list'] = Galeri::with('user')
            ->orderByDesc('tgl_upload')
            ->get();

        return view('admin.galeri.galeri', $data);
    }

    // PAGE: CREATE
    public function create()
    {
        return view('admin.galeri.tambah', [
            'title' => 'Tambah Foto Galeri'
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'judul_foto' => 'required',
            'foto' => 'required|image|max:5120'
        ]);

        $path = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'judul_foto' => $request->judul_foto,
            'foto' => $path,
            'id_user' => auth()->id(),
            'tgl_upload' => now()
        ]);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $item = Galeri::findOrFail($id);

        return view('admin.galeri.edit', [
            'title' => 'Edit Foto Galeri',
            'item' => $item,
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $item = Galeri::findOrFail($id);

        $request->validate([
            'judul_foto' => 'required',
            'foto' => 'nullable|image|max:5120'
        ]);

        $data = [
            'judul_foto' => $request->judul_foto
        ];

        if ($request->hasFile('foto')) {

            // hapus lama
            if ($item->foto && Storage::disk('public')->exists($item->foto)) {
                Storage::disk('public')->delete($item->foto);
            }

            $data['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil diperbarui');
    }

    // DELETE
    public function destroy($id)
    {
        $item = Galeri::findOrFail($id);

        if ($item->foto && Storage::disk('public')->exists($item->foto)) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil dihapus');
    }
}
