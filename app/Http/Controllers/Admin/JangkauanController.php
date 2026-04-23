<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jangkauan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // WAJIB DI-IMPORT untuk hapus file

class JangkauanController extends Controller
{
    public function index()
    {
        $jangkauan = Jangkauan::first();
        $title = 'Jangkauan Layanan';
        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => route('admin.settings.jangkauan.index')],
        ];
        return view('admin.jangkauan.jangkauan', [
            'title' => $title,
            'jangkauan' => $jangkauan,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function update(Request $request)
    {
        $jangkauan = Jangkauan::first();

        if (!$jangkauan) {
            $jangkauan = new Jangkauan();
        }

        $jangkauan->jumlah_kk = $request->jumlah_kk;
        $jangkauan->jumlah_penduduk = $request->jumlah_penduduk;
        $jangkauan->jumlah_rw = $request->jumlah_rw;
        $jangkauan->jumlah_rt = $request->jumlah_rt;

        // ================= UPLOAD IKON KK =================
        if ($request->hasFile('icon_kk')) {
            // Hapus gambar lama jika ada di storage
            if ($jangkauan->icon_kk) {
                Storage::disk('public')->delete($jangkauan->icon_kk);
            }
            // Simpan gambar baru. Fungsi store() otomatis mereturn path: 'icons/namafile.jpg'
            $jangkauan->icon_kk = $request->file('icon_kk')->store('icons', 'public');
        }

        // ================= UPLOAD IKON PENDUDUK =================
        if ($request->hasFile('icon_penduduk')) {
            if ($jangkauan->icon_penduduk) {
                Storage::disk('public')->delete($jangkauan->icon_penduduk);
            }
            $jangkauan->icon_penduduk = $request->file('icon_penduduk')->store('icons', 'public');
        }

        // ================= UPLOAD IKON RW =================
        if ($request->hasFile('icon_rw')) {
            if ($jangkauan->icon_rw) {
                Storage::disk('public')->delete($jangkauan->icon_rw);
            }
            $jangkauan->icon_rw = $request->file('icon_rw')->store('icons', 'public');
        }

        // ================= UPLOAD IKON RT =================
        if ($request->hasFile('icon_rt')) {
            if ($jangkauan->icon_rt) {
                Storage::disk('public')->delete($jangkauan->icon_rt);
            }
            $jangkauan->icon_rt = $request->file('icon_rt')->store('icons', 'public');
        }

        $jangkauan->save();

        return back()->with('success', 'Berhasil disimpan');
    }
}
