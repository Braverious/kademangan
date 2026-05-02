<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ArrayRekapExport;
use App\Models\SuratPenghasilan;
use App\Models\Pejabat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

class SuratPenghasilanController extends Controller
{
    public function index()
    {
        $title = 'Data Surat Keterangan Penghasilan';
        $list = SuratPenghasilan::latest()->get();
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Surat Keterangan', 'url' => '#'],
            ['label' => 'Penghasilan', 'url' => route('admin.penghasilan.index')],
        ];

        return view(
            'admin.surat_penghasilan.list', compact('title', 'list', 'breadcrumbs')
        );
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

        $isSuperadmin = auth()->user()->level_id == 1;

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

        $isSuperadmin = auth()->user()->level_id == 1;

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

        if (auth()->user()->level_id != 1) {
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

    public function exportExcel(Request $request)
    {
        // --- 1. Parameter Bulan ---
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

        // --- 2. Ambil Data ---
        $startDate = Carbon::parse($bulanParam . '-01')->startOfDay();
        $endDate   = Carbon::parse($bulanParam . '-01')->endOfMonth()->endOfDay();

        $rows = SuratPenghasilan::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'ASC')
            ->get();

        // --- 3. Mapping Petugas ---
        $petugasMap = [];
        $idsUser = $rows->pluck('user_id')->filter()->unique()->toArray();
        if (!empty($idsUser)) {
            $users = DB::table('users')->whereIn('id', $idsUser)->get();
            foreach ($users as $u) {
                $petugasMap[$u->id] = $u->name ?? $u->nama_lengkap ?? $u->username ?? ('User #' . $u->id);
            }
        }

        $namaTtd    = '................................';
        $jabatanTtd = 'Lurah Kademangan';

        // --- 4. Spreadsheet Setup ---
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Penghasilan');

        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

        // Page Setup: F4 Landscape
        $pageSetup = $sheet->getPageSetup();
        $pageSetup->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $pageSetup->setPaperSize(PageSetup::PAPERSIZE_FOLIO);
        $pageSetup->setFitToWidth(1);
        $pageSetup->setFitToHeight(0);

        $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);

        // Lebar Kolom A-P
        $columnWidths = [
            'A' => 6,
            'B' => 14,
            'C' => 18,
            'D' => 22,
            'E' => 18,
            'F' => 14,
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 12,
            'K' => 18,
            'L' => 26,
            'M' => 22,
            'N' => 16,
            'O' => 12,
            'P' => 18
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

        $sheet->mergeCells('B1:P1');
        $sheet->mergeCells('B2:P2');
        $sheet->mergeCells('B3:P3');
        $sheet->mergeCells('B4:P4');
        $sheet->mergeCells('B5:P5');

        $sheet->setCellValue('B1', 'PEMERINTAH KOTA TANGERANG SELATAN');
        $sheet->setCellValue('B2', 'KECAMATAN SETU');
        $sheet->setCellValue('B3', 'KELURAHAN KADEMANGAN');
        $sheet->setCellValue('B4', 'Jl. Masjid Jami Al-Latif No.1 Kec. Setu - Tangerang Selatan - Banten 15313');
        $sheet->setCellValue('B5', 'WA: 083125243200   •   Email: kel.kademangan@gmail.com   •   IG: @kelurahan.kademangan   •   Website: http://kademangan.tangerangselatankota.go.id');

        $sheet->getStyle('B1:B3')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('B1:P5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $sheet->getStyle('A5:P5')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);

        // ========== Judul Rekap ==========
        $sheet->mergeCells('A7:P7');
        $sheet->mergeCells('A8:P8');
        $sheet->setCellValue('A7', 'REKAPITULASI SURAT KETERANGAN PENGHASILAN');
        $sheet->setCellValue('A8', 'Periode : ' . $namaBulanIndo . ' ' . $tahun);

        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A7:A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ========== Header Tabel ==========
        $headerRow = 10;
        $headers = ['No', 'Tanggal Pengajuan', 'Nomor Surat', 'Nama Pemohon', 'NIK', 'Tempat Lahir', 'Tgl Lahir', 'Jenis Kelamin', 'Warganegara', 'Agama', 'Pekerjaan', 'Alamat', 'Keperluan', 'No. Telepon', 'Status', 'Petugas'];

        foreach ($headers as $key => $title) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1) . $headerRow;
            $sheet->setCellValue($cell, $title);
        }

        $sheet->getStyle('A' . $headerRow . ':P' . $headerRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1147A7']]
        ]);

        // ========== Isi Data ==========
        $rowIndex = $headerRow + 1;
        $no = 1;

        foreach ($rows as $r) {
            $sheet->setCellValue('A' . $rowIndex, $no++);
            $sheet->setCellValue('B' . $rowIndex, Carbon::parse($r->created_at)->format('d-m-Y'));
            $sheet->setCellValue('C' . $rowIndex, $r->nomor_surat);
            $sheet->setCellValue('D' . $rowIndex, $r->nama_pemohon);
            $sheet->setCellValueExplicit('E' . $rowIndex, (string)$r->nik, DataType::TYPE_STRING);
            $sheet->setCellValue('F' . $rowIndex, $r->tempat_lahir);
            $sheet->setCellValue('G' . $rowIndex, $r->tanggal_lahir ? Carbon::parse($r->tanggal_lahir)->format('d-m-Y') : '-');
            $sheet->setCellValue('H' . $rowIndex, $r->jenis_kelamin);
            $sheet->setCellValue('I' . $rowIndex, $r->warganegara);
            $sheet->setCellValue('J' . $rowIndex, $r->agama);
            $sheet->setCellValue('K' . $rowIndex, $r->pekerjaan);
            $sheet->setCellValue('L' . $rowIndex, $r->alamat);
            $sheet->setCellValue('M' . $rowIndex, $r->keperluan);
            $sheet->setCellValueExplicit('N' . $rowIndex, (string)$r->telepon_pemohon, DataType::TYPE_STRING);
            $sheet->setCellValue('O' . $rowIndex, $r->status);
            $sheet->setCellValue('P' . $rowIndex, $petugasMap[$r->user_id] ?? '-');

            $rowIndex++;
        }

        $lastDataRow = max($headerRow + 1, $rowIndex - 1);
        $sheet->getStyle('A' . $headerRow . ':P' . $lastDataRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A' . ($headerRow + 1) . ':P' . $lastDataRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);

        // ========== Tanda Tangan ==========
        $signRow = $lastDataRow + 3;
        $sheet->mergeCells('L' . $signRow . ':P' . $signRow);
        $sheet->mergeCells('L' . ($signRow + 1) . ':P' . ($signRow + 1));
        $sheet->mergeCells('L' . ($signRow + 4) . ':P' . ($signRow + 4));

        $sheet->setCellValue('L' . $signRow, 'Kademangan, ' . date('d-m-Y'));
        $sheet->setCellValue('L' . ($signRow + 1), $jabatanTtd);
        $sheet->setCellValue('L' . ($signRow + 4), strtoupper($namaTtd));

        $sheet->getStyle('L' . $signRow . ':P' . ($signRow + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L' . ($signRow + 4) . ':P' . ($signRow + 4))->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);

        // ========== Download ==========
        $filename = 'Rekap_Penghasilan_' . $bulanParam . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate',
            'Pragma' => 'public'
        ]);
    }
}
