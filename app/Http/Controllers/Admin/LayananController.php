<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function index()
    {
        // Hapus orderBy('urut'), cukup urutkan dari yang terbaru (id terbesar)
        $rows = Layanan::orderByDesc('id')->get();

        return view('admin.layanan.layanan', [
            'title' => 'Manajemen Layanan',
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
            // urut dan aktif sudah dihapus dari sini
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

        // Hapus urut dan aktif dari request->only
        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            // Opsional: Hapus gambar lama dari storage sebelum ditimpa
            if ($row->gambar) {
                Storage::disk('public')->delete($row->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('layanan', 'public');
        }

        $row->update($data);

        return redirect()->route('admin.layanan')->with('success', 'Berhasil diupdate');
    }

    public function delete($id)
    {
        $row = Layanan::findOrFail($id);
        
        // Opsional: Hapus gambar fisiknya juga kalau datanya dihapus
        if ($row->gambar) {
            Storage::disk('public')->delete($row->gambar);
        }
        
        $row->delete();

        return redirect()->route('admin.layanan')->with('success', 'Berhasil dihapus');
    }
}