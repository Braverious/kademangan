<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ArrayRekapExport;
use App\Models\SuratBelumBekerja;
use App\Models\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SuratBelumBekerjaController extends Controller
{
    public function index()
    {
        $list = SuratBelumBekerja::orderBy('created_at', 'desc')->get();
        $title = 'Data Surat Keterangan Belum Bekerja';
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Surat Keterangan', 'url' => '#'],
            ['label' => 'Belum Bekerja', 'url' => route('admin.belum-bekerja.index')],
        ];

        return view('admin.surat_belum_bekerja.list', compact('title', 'list', 'breadcrumbs'));
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

        $isSuperadmin = auth()->user()->level_id == 1;

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

        $isSuperadmin = auth()->user()->level_id == 1;

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
                'user_id' => auth()->id(),
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

    public function exportExcel(Request $request)
    {
        // --- 1. Ambil parameter bulan (YYYY-MM) ---
        $bulanParam = $request->input('bulan');
        if (!$bulanParam || !preg_match('/^\d{4}-\d{2}$/', $bulanParam)) {
            $bulanParam = date('Y-m');
        }

        $tahun = substr($bulanParam, 0, 4);
        $bulan = substr($bulanParam, 5, 2);

        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
        $namaBulanIndo = $namaBulan[$bulan] ?? $bulanParam;

        // --- 2. Query Data ---
        $startDate = Carbon::parse($bulanParam . '-01')->startOfDay();
        $endDate   = Carbon::parse($bulanParam . '-01')->endOfMonth()->endOfDay();

        $rows = SuratBelumBekerja::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'ASC')
            ->get();

        // --- 3. Mapping Petugas (User) ---
        $petugasMap = [];
        $idsUser = $rows->pluck('user_id')->filter()->unique()->toArray();
        if (!empty($idsUser)) {
            $users = DB::table('users')->whereIn('id', $idsUser)->get();
            foreach ($users as $u) {
                $petugasMap[$u->id] = $u->name ?? $u->nama_lengkap ?? $u->username ?? ('User #' . $u->id);
            }
        }

        // --- 4. Penandatangan (Default) ---
        $namaTtd    = '................................';
        $jabatanTtd = 'Lurah Kademangan';

        // --- 5. Konfigurasi Spreadsheet ---
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Belum Bekerja');

        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

        // Page setup: F4 Landscape
        $pageSetup = $sheet->getPageSetup();
        $pageSetup->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $pageSetup->setPaperSize(PageSetup::PAPERSIZE_FOLIO);
        $pageSetup->setFitToWidth(1);
        $pageSetup->setFitToHeight(0);

        $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);

        // Lebar Kolom (A sampai R)
        $columnWidths = [
            'A' => 5,
            'B' => 14,
            'C' => 18,
            'D' => 16,
            'E' => 14,
            'F' => 20,
            'G' => 18,
            'H' => 16,
            'I' => 14,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 16,
            'N' => 24,
            'O' => 22,
            'P' => 16,
            'Q' => 12,
            'R' => 18
        ];
        foreach ($columnWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // ========== KOP SURAT ==========
        $sheet->mergeCells('A1:A5');
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(16);
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);

        $logoPath = public_path('assets/img/logo_tangsel.png');
        if (file_exists($logoPath)) {
            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setPath($logoPath);
            $drawing->setHeight(120);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(30);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        $sheet->mergeCells('B1:R1');
        $sheet->mergeCells('B2:R2');
        $sheet->mergeCells('B3:R3');
        $sheet->mergeCells('B4:R4');
        $sheet->mergeCells('B5:R5');

        $sheet->setCellValue('B1', 'PEMERINTAH KOTA TANGERANG SELATAN');
        $sheet->setCellValue('B2', 'KECAMATAN SETU');
        $sheet->setCellValue('B3', 'KELURAHAN KADEMANGAN');
        $sheet->setCellValue('B4', 'Jl. Masjid Jami Al-Latif No.1 Kec. Setu - Tangerang Selatan - Banten 15313');
        $sheet->setCellValue('B5', 'WA: 083125243200   •   Email: kel.kademangan@gmail.com   •   IG: @kelurahan.kademangan   •   Website: http://kademangan.tangerangselatankota.go.id');

        $sheet->getStyle('B1:B3')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('B1:R5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $sheet->getStyle('A5:R5')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);

        // ========== JUDUL REKAP ==========
        $sheet->mergeCells('A7:R7');
        $sheet->mergeCells('A8:R8');
        $sheet->setCellValue('A7', 'REKAPITULASI SURAT KETERANGAN BELUM BEKERJA');
        $sheet->setCellValue('A8', 'Periode : ' . $namaBulanIndo . ' ' . $tahun);
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A7:A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ========== HEADER TABEL ==========
        $headerRow = 10;
        $headers = ['No', 'Tanggal Pengajuan', 'Nomor Surat', 'Nomor Surat RT', 'Tgl Surat RT', 'Nama Pemohon', 'NIK', 'Tempat Lahir', 'Tgl Lahir', 'Jenis Kelamin', 'Warganegara', 'Agama', 'Pekerjaan', 'Alamat', 'Keperluan', 'No. Telepon', 'Status', 'Petugas'];

        foreach ($headers as $key => $title) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1) . $headerRow;
            $sheet->setCellValue($cell, $title);
        }

        $sheet->getStyle('A' . $headerRow . ':R' . $headerRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1147A7']]
        ]);

        // ========== ISI DATA ==========
        $rowIndex = $headerRow + 1;
        $no = 1;

        foreach ($rows as $r) {
            $sheet->setCellValue('A' . $rowIndex, $no++);
            $sheet->setCellValue('B' . $rowIndex, Carbon::parse($r->created_at)->format('d-m-Y'));
            $sheet->setCellValue('C' . $rowIndex, $r->nomor_surat);
            $sheet->setCellValue('D' . $rowIndex, $r->nomor_surat_rt);
            $sheet->setCellValue('E' . $rowIndex, $r->tanggal_surat_rt ? Carbon::parse($r->tanggal_surat_rt)->format('d-m-Y') : '-');
            $sheet->setCellValue('F' . $rowIndex, $r->nama_pemohon);
            $sheet->setCellValueExplicit('G' . $rowIndex, (string)$r->nik, DataType::TYPE_STRING);
            $sheet->setCellValue('H' . $rowIndex, $r->tempat_lahir);
            $sheet->setCellValue('I' . $rowIndex, Carbon::parse($r->tanggal_lahir)->format('d-m-Y'));
            $sheet->setCellValue('J' . $rowIndex, $r->jenis_kelamin);
            $sheet->setCellValue('K' . $rowIndex, $r->warganegara);
            $sheet->setCellValue('L' . $rowIndex, $r->agama);
            $sheet->setCellValue('M' . $rowIndex, $r->pekerjaan);
            $sheet->setCellValue('N' . $rowIndex, $r->alamat);
            $sheet->setCellValue('O' . $rowIndex, $r->keperluan);
            $sheet->setCellValueExplicit('P' . $rowIndex, (string)$r->telepon_pemohon, DataType::TYPE_STRING);
            $sheet->setCellValue('Q' . $rowIndex, $r->status);
            $sheet->setCellValue('R' . $rowIndex, $petugasMap[$r->user_id] ?? '-');

            $rowIndex++;
        }

        $lastDataRow = max($headerRow + 1, $rowIndex - 1);
        $sheet->getStyle('A' . $headerRow . ':R' . $lastDataRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A' . ($headerRow + 1) . ':R' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);

        // ========== TANDA TANGAN ==========
        $signRow = $lastDataRow + 3;
        $sheet->mergeCells('N' . $signRow . ':R' . $signRow);
        $sheet->mergeCells('N' . ($signRow + 1) . ':R' . ($signRow + 1));
        $sheet->mergeCells('N' . ($signRow + 4) . ':R' . ($signRow + 4));

        $sheet->setCellValue('N' . $signRow, 'Kademangan, ' . date('d-m-Y'));
        $sheet->setCellValue('N' . ($signRow + 1), $jabatanTtd);
        $sheet->setCellValue('N' . ($signRow + 4), strtoupper($namaTtd));

        $sheet->getStyle('N' . $signRow . ':R' . ($signRow + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('N' . ($signRow + 4) . ':R' . ($signRow + 4))->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);

        // ========== DOWNLOAD RESPONSE ==========
        $filename = 'Rekap_Belum_Bekerja_' . $bulanParam . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate',
            'Pragma' => 'public'
        ]);
    }

    public function destroy($id)
    {
        $surat = SuratBelumBekerja::find($id);

        if (!$surat) {
            return redirect()
                ->route('admin.belum-bekerja.index')
                ->with('error', 'Data tidak ditemukan');
        }

        if (auth()->user()->level_id != 1) {
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
