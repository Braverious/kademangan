<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coverage;
use Illuminate\Http\Request;

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

        // Buat upload ikon
        if ($request->hasFile('icon_kk')) {
            $coverage->icon_kk = $request->file('icon_kk')->store('icons', 'public');
        }

        if ($request->hasFile('icon_penduduk')) {
            $coverage->icon_penduduk = $request->file('icon_penduduk')->store('icons', 'public');
        }

        if ($request->hasFile('icon_rw')) {
            $coverage->icon_rw = $request->file('icon_rw')->store('icons', 'public');
        }

        if ($request->hasFile('icon_rt')) {
            $coverage->icon_rt = $request->file('icon_rt')->store('icons', 'public');
        }

        $coverage->save();

        return back()->with('success', 'Berhasil disimpan');
    }
}
