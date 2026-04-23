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
        // Mengambil semua data running text dan diubah menjadi koleksi dengan key 'position'
        $runningTexts = RunningText::all()->keyBy('position');

        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null], // url null jika tidak ingin bisa diklik
            ['label' => 'Running Text', 'url' => route('admin.settings.runningtext.index')],
        ];

        return view('admin.runningtext', [
            'title' => 'Running Text Settings',
            'top' => $runningTexts->get('top'),
            'bottom' => $runningTexts->get('bottom'),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'top_content' => 'required|max:255',
            'top_direction' => 'required|in:left,right',
            'top_speed' => 'required|integer|min:1|max:10',
            'bottom_content' => 'required|max:255',
            'bottom_direction' => 'required|in:left,right',
            'bottom_speed' => 'required|integer|min:1|max:10',
        ]);

        // Update Top - Menggunakan data dari request sepenuhnya
        RunningText::where('position', 'top')->update([
            'content' => $request->top_content,
            'direction' => $request->top_direction,
            'speed' => $request->top_speed,
            'is_active' => $request->has('top_is_active') ? 1 : 0, // Sekarang benar-benar dinamis
        ]);

        // Update Bottom
        RunningText::where('position', 'bottom')->update([
            'content' => $request->bottom_content,
            'direction' => $request->bottom_direction,
            'speed' => $request->bottom_speed,
            'is_active' => $request->has('bottom_is_active') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui langsung ke database.');
    }
}
