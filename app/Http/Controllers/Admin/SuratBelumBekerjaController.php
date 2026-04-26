<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ArrayRekapExport;
use App\Models\SuratBelumBekerja;
use App\Models\Pejabat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SuratBelumBekerjaController extends Controller
{
    public function index()
    {
        $list = SuratBelumBekerja::orderBy('created_at', 'desc')->get();

        return view('admin.surat_belum_bekerja.list', [
            'title' => 'Data Surat Keterangan Belum Bekerja',
            'list' => $list
        ]);
    }

    public function detail($id)
    {
        $surat = SuratBelumBekerja::find($id);

        if (!$surat) {
            return redirect()
                ->route('admin.belum_bekerja.list')
                ->with('error', 'Data tidak ditemukan');
        }

        // =========================
        // CEK BISA CETAK
        // =========================
        $bisaCetak = $surat->nomor_surat && $surat->status === 'Disetujui';

        // =========================
        // AMBIL PENANDATANGAN
        // =========================
        $signers = Pejabat::all();

        // default signer
        $defaultSignerId = null;

        if ($signers->isNotEmpty()) {

            $defaultSignerId = optional(
                $signers->firstWhere('jabatan_nama', 'Sekretaris Kelurahan')
            )->id;

            if (!$defaultSignerId) {
                $defaultSignerId = optional(
                    $signers->first(function ($s) {
                        return str_starts_with($s->jabatan_nama, 'Lurah');
                    })
                )->id;
            }
        }

        return view('admin.surat_belum_bekerja.detail', [
            'title' => 'Detail Surat Ket. Belum Bekerja',
            'surat' => $surat,
            'bisaCetak' => $bisaCetak,
            'signers' => $signers,
            'default_signer_id' => $defaultSignerId,
        ]);
    }

    public function edit($id)
    {
        $surat = SuratBelumBekerja::find($id);

        if (!$surat) {
            return redirect()
                ->route('admin.belum-bekerja.index')
                ->with('error', 'Data tidak ditemukan');
        }

        $isSuperadmin = auth()->user()->id_level == 1;

        return view('admin.surat_belum_bekerja.edit', [
            'title' => 'Edit Surat Ket. Belum Bekerja',
            'surat' => $surat,
            'can_full_edit' => $isSuperadmin
        ]);
    }

    public function update(Request $request, $id)
    {
        $surat = SuratBelumBekerja::find($id);

        if (!$surat) {
            return redirect()
                ->route('admin.belum-bekerja.index')
                ->with('error', 'Data tidak ditemukan');
        }

        $isSuperadmin = auth()->user()->id_level == 1;

        // =========================
        // VALIDASI
        // =========================
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

            return redirect()
                ->route('admin.belum-bekerja.detail', $id)
                ->with('success', 'Status berhasil diperbarui');
        }

        // =========================
        // VALIDASI SUPERADMIN
        // =========================
        $request->validate([
            'nama_pemohon' => 'required|string',
            'nik' => 'required|numeric',
            'status' => 'required|in:Pending,Disetujui,Ditolak',
        ]);

        // =========================
        // HANDLE FILE LAMA
        // =========================
        $existingFiles = [];

        if (!empty($surat->dokumen_pendukung)) {
            $dec = json_decode($surat->dokumen_pendukung, true);
            $existingFiles = is_array($dec) ? $dec : [$surat->dokumen_pendukung];
        }

        // =========================
        // UPLOAD FILE BARU
        // =========================
        $newFiles = [];

        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $file) {

                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('uploads/pendukung'), $filename);

                $newFiles[] = $filename;
            }
        }

        // gabung file lama + baru
        $allFiles = array_merge($existingFiles, $newFiles);

        // =========================
        // UPDATE DATA
        // =========================
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

        return redirect()
            ->route('admin.belum-bekerja.detail', $id)
            ->with('success', 'Data berhasil diperbarui');
    }

    public function cetak(Request $request, $id)
    {
        $surat = SuratBelumBekerja::find($id);

        if (!$surat) {
            return redirect()
                ->route('admin.belum-bekerja.index')
                ->with('error', 'Data tidak ditemukan');
        }

        if (empty($surat->nomor_surat)) {
            return redirect()
                ->route('admin.belum-bekerja.edit', $id)
                ->with('error', 'Nomor surat belum diisi');
        }

        if ($surat->status !== 'Disetujui') {
            return redirect()
                ->route('admin.belum-bekerja.edit', $id)
                ->with('error', 'Status harus Disetujui');
        }

        $ttdId = $request->get('ttd');

        $ttd = null;

        if ($ttdId) {
            $ttd = Pejabat::find($ttdId);
        }

        if (!$ttd) {
            $ttd = Pejabat::first();
        }

        $namaTtd = $ttd->nama ?? '...............................';
        $jabatanTtd = $ttd->jabatan_nama ?? 'Lurah';

        $data = [
            'surat' => $surat,
            'ttd' => $ttd,
            'nama_ttd' => $namaTtd,
            'jabatan_ttd' => $jabatanTtd,
            'tanggal_ttd' => now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('admin.surat_belum_bekerja.cetak', $data)
            ->setPaper('A4', 'portrait');

        $filename = 'surat-belum-bekerja-' . $surat->nik . '.pdf';

        return $pdf->stream($filename);
    }

    public function export(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('Y-m'));
        $periode = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();

        $data = SuratBelumBekerja::whereBetween('created_at', [
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
            new ArrayRekapExport($headings, $rows, 'Rekap Belum Bekerja'),
            'rekap-belum-bekerja-' . $bulan . '.xlsx'
        );
    }

    public function destroy($id)
    {
        $surat = SuratBelumBekerja::find($id);

        if (!$surat) {
            return redirect()
                ->route('admin.belum-bekerja.index')
                ->with('error', 'Data tidak ditemukan');
        }

        if (auth()->user()->id_level != 1) {
            return redirect()
                ->route('admin.belum-bekerja.index')
                ->with('error', 'Akses ditolak! Hanya superadmin.');
        }

        if (!empty($surat->dokumen_pendukung)) {

            $files = json_decode($surat->dokumen_pendukung, true);
            $files = is_array($files) ? $files : [$surat->dokumen_pendukung];

            foreach ($files as $file) {
                $path = public_path('uploads/pendukung/' . $file);

                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        }

        $surat->delete();

        return redirect()
            ->route('admin.belum-bekerja.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
