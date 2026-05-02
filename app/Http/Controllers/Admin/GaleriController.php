<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth'); // proteksi login
    // }

    // LIST
    public function index()
    {
        $title = "Manajemen Galeri";
        $breadcrumbs = [
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['url' => '#', 'label' => 'Manajemen Galeri']
        ];
        $galeri_list = Galeri::with('user')
            ->latest('tgl_upload')
            ->paginate(10);

        return view('admin.galeri.galeri', compact('title', 'galeri_list', 'breadcrumbs'));
    }

    // PAGE: CREATE
    public function create()
    {
        $breadcrumbs = [
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['url' => route('admin.galeri.index'), 'label' => 'Manajemen Galeri'],
            ['url' => '#', 'label' => 'Tambah Foto']
        ];
        return view('admin.galeri.tambah', [
            'title' => 'Tambah Foto Galeri',
            'breadcrumbs' => $breadcrumbs
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
            'user_id' => auth()->id(),
            'tgl_upload' => now()
        ]);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $breadcrumbs = [
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['url' => route('admin.galeri.index'), 'label' => 'Manajemen Galeri'],
            ['url' => '#', 'label' => 'Edit Foto']
        ];

        $item = Galeri::findOrFail($id);

        return view('admin.galeri.edit', [
            'title' => 'Edit Foto Galeri',
            'item' => $item,
            'breadcrumbs' => $breadcrumbs
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

        $data['user_id'] = auth()->id();
        $data['tgl_upload'] = now();
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
