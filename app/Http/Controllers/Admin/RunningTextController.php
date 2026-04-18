<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RunningText;

class RunningTextController extends Controller
{
    public function index()
    {
        // Proteksi hak akses: Hanya level 1 (Superadmin) yang boleh masuk
        if (Auth::user()->id_level != 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        // Ambil data atau buat default jika belum ada di database (Sihir Laravel!)
        $top = RunningText::firstOrCreate(
            ['position' => 'top'],
            [
                'content' => '📢 Selamat Datang di Website Resmi Kelurahan Kademangan | Layanan publik mudah, cepat, dan transparan!',
                'direction' => 'left',
                'speed' => 6,
                'is_active' => 1,
            ]
        );

        $bottom = RunningText::firstOrCreate(
            ['position' => 'bottom'],
            [
                'content' => '💬 Hubungi kami melalui media sosial resmi Kelurahan Kademangan | Ikuti update kegiatan terbaru setiap minggu!',
                'direction' => 'right',
                'speed' => 5,
                'is_active' => 1,
            ]
        );

        return view('admin.runningtext', [
            'title' => 'Running Text',
            'top' => $top,
            'bottom' => $bottom
        ]);
    }

    public function update(Request $request)
    {
        if (Auth::user()->id_level != 1) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'top_content' => 'required|max:255',
            'top_direction' => 'required|in:left,right',
            'top_speed' => 'required|integer|min:1|max:10',
            
            'bottom_content' => 'required|max:255',
            'bottom_direction' => 'required|in:left,right',
            'bottom_speed' => 'required|integer|min:1|max:10',
        ]);

        // Update Top
        RunningText::updateOrCreate(
            ['position' => 'top'],
            [
                'content' => $request->top_content,
                'direction' => $request->top_direction,
                'speed' => $request->top_speed,
                'is_active' => $request->has('top_is_active') ? 1 : 1, // Default aktif jika checkbox tidak ada di form
            ]
        );

        // Update Bottom
        RunningText::updateOrCreate(
            ['position' => 'bottom'],
            [
                'content' => $request->bottom_content,
                'direction' => $request->bottom_direction,
                'speed' => $request->bottom_speed,
                'is_active' => $request->has('bottom_is_active') ? 1 : 1,
            ]
        );

        return redirect()->route('admin.settings.runningtext')->with('success', 'Pengaturan running text berhasil disimpan.');
    }
}