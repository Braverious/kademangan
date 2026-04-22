<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratSktm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratSktmController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Surat Keterangan Tidak Mampu (SKTM)',
            'list'  => SuratSktm::latest()->get()
        ];

        return view('admin.sktm.list', $data);
    }

    public function detail($id)
    {
        $surat = SuratSktm::findOrFail($id);

        // ambil penandatangan
        // $signers = Pejabat::all();
        $signers = User::all();
        $default = $signers->first()?->id;

        // logika bisa cetak
        $bisaCetak = true;
        $pesanError = [];

        if (empty($surat->nomor_surat)) {
            $bisaCetak = false;
        }

        if ($surat->status !== 'Disetujui') {
            $bisaCetak = false;
        }

        return view('admin.sktm.detail', [
            'title' => 'Detail SKTM',
            'surat' => $surat,
            'signers' => $signers,
            'default_signer_id' => $default,
            'bisaCetak' => $bisaCetak,
            'pesanError' => $pesanError
        ]);
    }

    public function edit($id)
    {
        $surat = SuratSktm::findOrFail($id);

        return view('admin.sktm.edit', [
            'title' => 'Edit SKTM',
            'surat' => $surat
        ]);
    }

    public function update(Request $request, $id)
    {
        $surat = SuratSktm::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:Pending,Disetujui,Ditolak',
            'nomor_surat' => 'nullable|string',
        ]);

        $data['id_user'] = Auth::id();

        $surat->update($data);

        return redirect()
            ->route('admin.sktm.detail', $id)
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat = SuratSktm::findOrFail($id);
        $surat->delete();

        return redirect()->route('admin.sktm.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
