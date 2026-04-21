<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.berita.berita', [
            'title' => 'Manajemen Berita',
            'berita_list' => Berita::with('user')
                ->orderByDesc('tgl_publish')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('admin.berita.tambah', [
            'title' => 'Tambah Berita',
            'kategoriOptions' => $this->kategoriOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBerita($request, true);
        $slug = $this->generateUniqueSlug($validated['judul_berita']);

        $payload = [
            'judul_berita' => $validated['judul_berita'],
            'slug_berita' => $slug,
            'isi_berita' => $validated['isi_berita'],
            'kategori' => $validated['kategori'],
            'gambar' => '',
            'id_user' => Auth::id(),
            'tgl_publish' => now(),
        ];

        if ($request->hasFile('gambar')) {
            $payload['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($payload);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('admin.berita.edit', [
            'title' => 'Edit Berita',
            'berita' => Berita::findOrFail($id),
            'kategoriOptions' => $this->kategoriOptions(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $validated = $this->validateBerita($request, false);

        $payload = [
            'judul_berita' => $validated['judul_berita'],
            'slug_berita' => $this->generateUniqueSlug($validated['judul_berita'], $berita->id_berita),
            'isi_berita' => $validated['isi_berita'],
            'kategori' => $validated['kategori'],
        ];

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $payload['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($payload);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function uploadGambar(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $path = $request->file('upload')->store('berita', 'public');

        return response()->json([
            'url' => Storage::url($path),
        ]);
    }

    private function validateBerita(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'judul_berita' => 'required|string|max:255',
            'kategori' => 'required|in:Kegiatan,Pengumuman,Layanan,Umum',
            'isi_berita' => 'required|string',
            'gambar' => ($isCreate ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);
    }

    private function kategoriOptions(): array
    {
        return ['Kegiatan', 'Pengumuman', 'Layanan', 'Umum'];
    }

    private function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($judul);
        $slug = $baseSlug !== '' ? $baseSlug : Str::random(8);
        $counter = 1;

        while (
            Berita::where('slug_berita', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id_berita', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
