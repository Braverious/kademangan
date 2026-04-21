<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* ===================== LIST ===================== */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $pengumuman_list = Pengumuman::when($q, function ($query) use ($q) {
            $query->where('judul', 'like', "%{$q}%")
                  ->orWhere('isi', 'like', "%{$q}%");
        })->latest()->limit(500)->get();

        return view('admin.pengumuman.pengumuman', [
            'title' => 'Manajemen Pengumuman',
            'q' => $q,
            'pengumuman_list' => $pengumuman_list
        ]);
    }

    /* ===================== CREATE ===================== */
    public function create()
    {
        return view('admin.pengumuman.tambah', [
            'title' => 'Tambah Pengumuman'
        ]);
    }

    /* ===================== STORE ===================== */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|min:3|max:150',
            'isi' => 'required|min:5',
            'tipe' => 'nullable|in:info,peringatan,penting',
            'status' => 'nullable|in:draft,publish',
        ]);

        $payload = $this->payload($request);
        $payload['created_by'] = Auth::id(); // pakai id user

        Pengumuman::create($payload);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /* ===================== EDIT ===================== */
    public function edit($id)
    {
        $row = Pengumuman::findOrFail($id);

        return view('admin.pengumuman.edit', [
            'title' => 'Edit Pengumuman',
            'row' => $row
        ]);
    }

    /* ===================== UPDATE ===================== */
    public function update(Request $request, $id)
    {
        $row = Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|min:3|max:150',
            'isi' => 'required|min:5',
            'tipe' => 'nullable|in:info,peringatan,penting',
            'status' => 'nullable|in:draft,publish',
        ]);

        $row->update($this->payload($request));

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Perubahan berhasil disimpan.');
    }

    /* ===================== DELETE ===================== */
    public function destroy($id)
    {
        Pengumuman::findOrFail($id)->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman dihapus.');
    }

    /* ===================== HELPER ===================== */
    private function payload(Request $request)
    {
        return [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tipe' => $request->tipe ?? 'info',
            'status' => $request->status ?? 'publish',
            'mulai_tayang' => $this->normalize_dt($request->mulai_tayang),
            'berakhir_tayang' => $this->normalize_dt($request->berakhir_tayang),
        ];
    }

    private function normalize_dt($str)
    {
        if (!$str) return null;

        $str = str_replace('T', ' ', $str);

        if (preg_match('/^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/', $str)) {
            $str .= ':00';
        }

        return date('Y-m-d H:i:s', strtotime($str));
    }
}