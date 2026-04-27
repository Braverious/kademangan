<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jangkauan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JangkauanController extends Controller
{
    public function index()
    {
        $title = 'Jangkauan Layanan';

        $jangkauan = Jangkauan::first();

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => route('admin.settings.jangkauan.index')],
        ];

        return view('admin.jangkauan.jangkauan', compact('title', 'jangkauan', 'breadcrumbs'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'jumlah_kk' => ['required', 'integer', 'min:0'],
            'jumlah_penduduk' => ['required', 'integer', 'min:0'],
            'jumlah_rw' => ['required', 'integer', 'min:0'],
            'jumlah_rt' => ['required', 'integer', 'min:0'],
            'icon_kk' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'icon_penduduk' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'icon_rw' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'icon_rt' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
        ]);

        $jangkauan = Jangkauan::first();

        if (!$jangkauan) {
            $jangkauan = new Jangkauan();
        }

        $jangkauan->jumlah_kk = $validated['jumlah_kk'];
        $jangkauan->jumlah_penduduk = $validated['jumlah_penduduk'];
        $jangkauan->jumlah_rw = $validated['jumlah_rw'];
        $jangkauan->jumlah_rt = $validated['jumlah_rt'];

        $fields = [
            'icon_kk',
            'icon_penduduk',
            'icon_rw',
            'icon_rt',
        ];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                if (!empty($jangkauan->{$field})) {
                    Storage::disk('public')->delete($jangkauan->{$field});
                }

                $jangkauan->{$field} = $request->file($field)->store('icons', 'public');
            }
        }

        $jangkauan->save();

        return back()->with('success', 'Jangkauan layanan berhasil diperbarui.');
    }
}
