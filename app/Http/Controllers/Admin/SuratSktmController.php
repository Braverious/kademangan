<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ArrayRekapExport;
use App\Models\SuratSktm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SuratSktmController extends Controller
{
    public function index()
    {
        $title = 'Data Surat SKTM';
        $list = SuratSktm::latest()->get();

        return view('admin.sktm.list', compact('title', 'list'));
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

    public function export(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('Y-m'));
        $periode = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();

        $data = SuratSktm::whereBetween('created_at', [
            $periode->copy()->startOfMonth(),
            $periode->copy()->endOfMonth(),
        ])->orderBy('created_at')->get();

        $headings = [
            'No',
            'Tanggal Pengajuan',
            'Nomor Surat RT',
            'Tanggal Surat RT',
            'Nomor Surat Kelurahan',
            'Nama Pemohon',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Warga Negara',
            'Agama',
            'Pekerjaan',
            'Nama Orang Tua',
            'Alamat',
            'ID DTKS',
            'Penghasilan Bulanan',
            'Keperluan',
            'Telepon',
            'Status',
        ];

        $rows = $data->values()->map(function ($row, int $index) {
            return [
                $index + 1,
                optional($row->created_at)->format('d/m/Y H:i'),
                (string) $row->nomor_surat_rt,
                optional($row->tanggal_surat_rt)->format('d/m/Y'),
                (string) $row->nomor_surat,
                $row->nama_pemohon,
                (string) $row->nik,
                $row->tempat_lahir,
                optional($row->tanggal_lahir)->format('d/m/Y'),
                $row->jenis_kelamin,
                $row->warganegara,
                $row->agama,
                $row->pekerjaan,
                $row->nama_orang_tua,
                $row->alamat,
                (string) $row->id_dtks,
                $row->penghasilan_bulanan,
                $row->keperluan,
                (string) $row->telepon_pemohon,
                $row->status,
            ];
        })->all();

        return Excel::download(
            new ArrayRekapExport($headings, $rows, 'Rekap SKTM'),
            'rekap-sktm-' . $bulan . '.xlsx'
        );
    }
}
