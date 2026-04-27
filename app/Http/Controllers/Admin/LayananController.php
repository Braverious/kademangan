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
        $title = 'Manajemen Layanan';

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => route('admin.settings.layanan.index')],
        ];

        $rows = Layanan::orderByDesc('id')->get();

        return view('admin.layanan.layanan', compact('title', 'breadcrumbs', 'rows'));
    }

    public function create()
    {
        $title = 'Tambah Layanan';

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => 'Manajemen Layanan', 'url' => route('admin.settings.layanan.index')],
            ['label' => $title, 'url' => null],
        ];

        $pelayananOptions = $this->pelayananOptions();

        return view('admin.layanan.tambah', compact('title', 'breadcrumbs', 'pelayananOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'min:3', 'max:120'],
            'deskripsi' => ['required', 'string', 'min:8'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'slug' => ['required', 'string', 'max:100', 'unique:layanan,slug'],
            'is_active' => ['required', 'boolean'],
        ]);

        $validated['gambar'] = $request->file('gambar')->store('layanan', 'public');

        Layanan::create($validated);

        return redirect()
            ->route('admin.settings.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $row = Layanan::findOrFail($id);

        $title = 'Edit Layanan';

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => 'Manajemen Layanan', 'url' => route('admin.settings.layanan.index')],
            ['label' => $title, 'url' => null],
        ];

        $pelayananOptions = $this->pelayananOptions();

        return view('admin.layanan.edit', compact('title', 'row', 'breadcrumbs', 'pelayananOptions'));
    }

    public function update(Request $request, $id)
    {
        $row = Layanan::findOrFail($id);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'min:3', 'max:120'],
            'deskripsi' => ['required', 'string', 'min:8'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'slug' => ['required', 'string', 'max:100', 'unique:layanan,slug,' . $row->id],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($row->gambar) {
                Storage::disk('public')->delete($row->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('layanan', 'public');
        }

        $row->update($validated);

        return redirect()
            ->route('admin.settings.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function toggle($id)
    {
        $row = Layanan::findOrFail($id);

        $row->update([
            'is_active' => !$row->is_active,
        ]);

        $message = $row->is_active
            ? 'Layanan berhasil diaktifkan.'
            : 'Layanan berhasil ditutup.';

        return redirect()
            ->route('admin.settings.layanan.index')
            ->with('success', $message);
    }

    public function destroy($id)
    {
        $row = Layanan::findOrFail($id);

        if ($row->gambar) {
            Storage::disk('public')->delete($row->gambar);
        }

        $row->delete();

        return redirect()
            ->route('admin.settings.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    private function pelayananOptions(): array
    {
        return [
            'tidak-mampu' => 'Surat Keterangan Tidak Mampu',
            'belum-bekerja' => 'Surat Keterangan Belum Bekerja',
            'domisili-yayasan' => 'Surat Domisili Yayasan',
            'belum-memiliki-rumah' => 'Surat Belum Memiliki Rumah',
            'kematian' => 'Surat Keterangan Kematian Dukcapil',
            'kematian-nondukcapil' => 'Surat Kematian Non Dukcapil',
            'suami-istri' => 'Surat Keterangan Suami Istri',
            'pengantar-nikah' => 'Surat Pengantar Nikah',
            'penghasilan' => 'Surat Keterangan Penghasilan',
        ];
    }
}