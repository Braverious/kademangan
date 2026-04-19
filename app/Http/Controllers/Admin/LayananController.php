<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $rows = Layanan::orderBy('urut')->orderByDesc('id')->get();

        return view('admin.layanan.layanan', [
            'title' => 'Layanan',
            'rows' => $rows
        ]);
    }

    public function create()
    {
        return view('admin.layanan.tambah', [
            'title' => 'Tambah Layanan'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|min:3|max:120',
            'deskripsi' => 'required|min:8',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambar = $request->file('gambar')->store('layanan', 'public');

        Layanan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'urut' => $request->urut ?? 0,
            'aktif' => $request->aktif ?? 1,
        ]);

        return redirect()->route('admin.layanan')->with('success', 'Berhasil ditambah');
    }

    public function edit($id)
    {
        $row = Layanan::findOrFail($id);

        return view('admin.layanan.edit', [
            'title' => 'Edit Layanan',
            'row' => $row
        ]);
    }

    public function update(Request $request, $id)
    {
        $row = Layanan::findOrFail($id);

        $data = $request->only(['judul', 'deskripsi', 'urut', 'aktif']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('layanan', 'public');
        }

        $row->update($data);

        return redirect()->route('admin.layanan')->with('success', 'Berhasil diupdate');
    }

    public function delete($id)
    {
        $row = Layanan::findOrFail($id);
        $row->delete();

        return redirect()->route('admin.layanan')->with('success', 'Berhasil dihapus');
    }
}
