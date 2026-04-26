<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ArrayRekapExport;
use App\Models\SuratPenghasilan;
use App\Models\Pejabat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SuratPenghasilanController extends Controller
{
    public function index()
    {
        $list = SuratPenghasilan::latest()->get();

        return view('admin.surat_penghasilan.list', [
            'title' => 'Data Surat Keterangan Penghasilan',
            'list' => $list
        ]);
    }

    public function detail($id)
    {
        $surat = SuratPenghasilan::find($id);

        if (!$surat) {
            return redirect()->route('admin.penghasilan.index')
                ->with('error', 'Data tidak ditemukan');
        }

        $bisaCetak = $surat->nomor_surat && $surat->status === 'Disetujui';

        $signers = Pejabat::all();

        $defaultSignerId = optional(
            $signers->firstWhere('jabatan_nama', 'Sekretaris Kelurahan')
        )->id;

        if (!$defaultSignerId) {
            $defaultSignerId = optional(
                $signers->first(fn($s) => str_starts_with($s->jabatan_nama, 'Lurah'))
            )->id;
        }

        return view('admin.surat_penghasilan.detail', compact(
            'surat',
            'bisaCetak',
            'signers',
            'defaultSignerId'
        ));
    }

    public function edit($id)
    {
        $surat = SuratPenghasilan::find($id);

        if (!$surat) {
            return redirect()->route('admin.penghasilan.index')
                ->with('error', 'Data tidak ditemukan');
        }

        $isSuperadmin = auth()->user()->id_level == 1;

        return view('admin.surat_penghasilan.edit', [
            'title' => 'Edit Surat Penghasilan',
            'surat' => $surat,
            'can_full_edit' => $isSuperadmin
        ]);
    }

    public function update(Request $request, $id)
    {
        $surat = SuratPenghasilan::find($id);

        if (!$surat) {
            return redirect()->route('admin.penghasilan.index')
                ->with('error', 'Data tidak ditemukan');
        }

        $isSuperadmin = auth()->user()->id_level == 1;

        if (!$isSuperadmin) {
            $request->validate([
                'status' => 'required|in:Pending,Disetujui,Ditolak',
                'nomor_surat' => 'nullable|string|max:100',
            ]);

            $surat->update([
                'nomor_surat' => $request->nomor_surat,
                'status' => $request->status,
                'id_user' => auth()->id(),
            ]);

            return redirect()->route('admin.penghasilan.detail', $id)
                ->with('success', 'Status diperbarui');
        }

        // SUPERADMIN
        $request->validate([
            'nama_pemohon' => 'required',
            'nik' => 'required|numeric',
            'status' => 'required',
        ]);

        // handle file
        $existingFiles = [];

        if ($surat->dokumen_pendukung) {
            $existingFiles = json_decode($surat->dokumen_pendukung, true) ?? [];
        }

        $newFiles = [];

        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $file) {

                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('uploads/pendukung'), $filename);

                $newFiles[] = $filename;
            }
        }

        $allFiles = array_merge($existingFiles, $newFiles);

        $surat->update([
            'nomor_surat_rt' => $request->nomor_surat_rt,
            'tanggal_surat_rt' => $request->tanggal_surat_rt,
            'nomor_surat' => $request->nomor_surat,
            'status' => $request->status,
            'telepon_pemohon' => $request->telepon_pemohon,
            'nama_pemohon' => $request->nama_pemohon,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'warganegara' => $request->warganegara,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'keperluan' => $request->keperluan,
            'dokumen_pendukung' => !empty($allFiles) ? json_encode($allFiles) : null,
        ]);

        return redirect()->route('admin.penghasilan.detail', $id)
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $surat = SuratPenghasilan::find($id);

        if (!$surat) {
            return redirect()->route('admin.penghasilan.index')
                ->with('error', 'Data tidak ditemukan');
        }

        if (auth()->user()->id_level != 1) {
            return redirect()->route('admin.penghasilan.index')
                ->with('error', 'Akses ditolak');
        }

        if ($surat->dokumen_pendukung) {
            $files = json_decode($surat->dokumen_pendukung, true) ?? [];

            foreach ($files as $file) {
                $path = public_path('uploads/pendukung/' . $file);

                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $surat->delete();

        return redirect()->route('admin.penghasilan.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function cetak(Request $request, $id)
    {
        $surat = SuratPenghasilan::find($id);

        if (!$surat) {
            return redirect()->route('admin.penghasilan.index');
        }

        if (!$surat->nomor_surat || $surat->status !== 'Disetujui') {
            return redirect()->route('admin.penghasilan.edit', $id)
                ->with('error', 'Surat belum siap dicetak');
        }

        $ttd = Pejabat::find($request->ttd) ?? Pejabat::first();

        $data = [
            'surat' => $surat,
            'ttd' => $ttd,
            'tanggal_ttd' => now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('admin.surat_penghasilan.cetak', $data);

        return $pdf->stream('surat-penghasilan.pdf');
    }

    public function export(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('Y-m'));
        $periode = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();

        $data = SuratPenghasilan::whereBetween('created_at', [
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
            'Alamat',
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
                $row->alamat,
                $row->keperluan,
                (string) $row->telepon_pemohon,
                $row->status,
            ];
        })->all();

        return Excel::download(
            new ArrayRekapExport($headings, $rows, 'Rekap Penghasilan'),
            'rekap-penghasilan-' . $bulan . '.xlsx'
        );
    }
}
