<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coverage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // WAJIB DI-IMPORT untuk hapus file

class CoverageController extends Controller
{
    public function index()
    {
        $coverage = Coverage::first();

        return view('admin.coverage.coverage', [
            'title' => 'Jangkauan Layanan',
            'coverage' => $coverage
        ]);
    }

    public function update(Request $request)
    {
        $coverage = Coverage::first();

        if (!$coverage) {
            $coverage = new Coverage();
        }

        $coverage->jumlah_kk = $request->jumlah_kk;
        $coverage->jumlah_penduduk = $request->jumlah_penduduk;
        $coverage->jumlah_rw = $request->jumlah_rw;
        $coverage->jumlah_rt = $request->jumlah_rt;

        // ================= UPLOAD IKON KK =================
        if ($request->hasFile('icon_kk')) {
            // Hapus gambar lama jika ada di storage
            if ($coverage->icon_kk) {
                Storage::disk('public')->delete($coverage->icon_kk);
            }
            // Simpan gambar baru. Fungsi store() otomatis mereturn path: 'icons/namafile.jpg'
            $coverage->icon_kk = $request->file('icon_kk')->store('icons', 'public');
        }

        // ================= UPLOAD IKON PENDUDUK =================
        if ($request->hasFile('icon_penduduk')) {
            if ($coverage->icon_penduduk) {
                Storage::disk('public')->delete($coverage->icon_penduduk);
            }
            $coverage->icon_penduduk = $request->file('icon_penduduk')->store('icons', 'public');
        }

        // ================= UPLOAD IKON RW =================
        if ($request->hasFile('icon_rw')) {
            if ($coverage->icon_rw) {
                Storage::disk('public')->delete($coverage->icon_rw);
            }
            $coverage->icon_rw = $request->file('icon_rw')->store('icons', 'public');
        }

        // ================= UPLOAD IKON RT =================
        if ($request->hasFile('icon_rt')) {
            if ($coverage->icon_rt) {
                Storage::disk('public')->delete($coverage->icon_rt);
            }
            $coverage->icon_rt = $request->file('icon_rt')->store('icons', 'public');
        }

        $coverage->save();

        return back()->with('success', 'Berhasil disimpan');
    }
}