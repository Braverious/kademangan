<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ArrayRekapExport;
use App\Models\SuratSktm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SuratSktmController extends Controller
{
    public function index()
    {
        $title = 'Data Surat SKTM';
        $list = SuratSktm::latest()->get();
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Surat Keterangan', 'url' => '#'],
            ['label' => 'SKTM', 'url' => route('admin.sktm.index')],
        ];

        return view('admin.sktm.list', compact('title', 'list', 'breadcrumbs'));
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

    public function exportExcel(Request $request)
    {
        // --- Ambil parameter bulan (YYYY-MM) ---
        $bulanParam = $request->input('bulan');
        if (!$bulanParam || !preg_match('/^\d{4}-\d{2}$/', $bulanParam)) {
            $bulanParam = date('Y-m'); // default: bulan ini
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

        // --- Query Data ---
        $startDate = \Carbon\Carbon::parse($bulanParam . '-01')->startOfDay();
        $endDate   = \Carbon\Carbon::parse($bulanParam . '-01')->endOfMonth()->endOfDay();

        $rows = \App\Models\SuratSktm::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'ASC')
            ->get();

        // --- Mapping Petugas ---
        $petugasMap = [];
        $idsUser = $rows->pluck('id_user')->filter()->unique()->toArray();

        if (!empty($idsUser)) {
            $users = \Illuminate\Support\Facades\DB::table('user')->whereIn('id_user', $idsUser)->get();
            foreach ($users as $u) {
                $label = $u->name ?? $u->nama_lengkap ?? $u->username ?? ('User #' . $u->id_user);
                $petugasMap[$u->id_user] = $label;
            }
        }

        // --- Penandatangan ---
        $namaTtd    = '................................';
        $jabatanTtd = 'Lurah Kademangan';

        // --- Setup PhpSpreadsheet ---
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap SKTM');

        // Default font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

        // Page setup: F4 (Folio)
        $pageSetup = $sheet->getPageSetup();
        $pageSetup->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $pageSetup->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $pageSetup->setFitToWidth(1);
        $pageSetup->setFitToHeight(0);

        // Margin
        $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);

        // Lebar kolom standar
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(14);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(16);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(24);
        $sheet->getColumnDimension('N')->setWidth(14);
        $sheet->getColumnDimension('O')->setWidth(14);
        $sheet->getColumnDimension('P')->setWidth(22);
        $sheet->getColumnDimension('Q')->setWidth(14);
        $sheet->getColumnDimension('R')->setWidth(12);
        $sheet->getColumnDimension('S')->setWidth(18);

        // ========== KOP SURAT ==========
        $sheet->mergeCells('A1:A5');

        // PENTING: Lebar & Tinggi sel Kop Surat diterapkan wajib (tanpa syarat)
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(16);
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);

        // Load Logo menggunakan public_path() Laravel
        $logoPath = public_path('assets/img/logo_tangsel.png');

        if (file_exists($logoPath)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Logo Tangsel');
            $drawing->setPath($logoPath);
            $drawing->setHeight(120);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(30);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        $sheet->mergeCells('B1:S1');
        $sheet->mergeCells('B2:S2');
        $sheet->mergeCells('B3:S3');
        $sheet->mergeCells('B4:S4');
        $sheet->mergeCells('B5:S5');

        $sheet->setCellValue('B1', 'PEMERINTAH KOTA TANGERANG SELATAN');
        $sheet->setCellValue('B2', 'KECAMATAN SETU');
        $sheet->setCellValue('B3', 'KELURAHAN KADEMANGAN');
        $sheet->setCellValue('B4', 'Jl. Masjid Jami Al-Latif No.1 Kec. Setu - Tangerang Selatan - Banten 15313');
        $sheet->setCellValue('B5', 'WA: 083125243200   •   Email: kel.kademangan@gmail.com   •   IG: @kelurahan.kademangan   •   Website: http://kademangan.tangerangselatankota.go.id');

        $sheet->getStyle('B1:B3')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('B4:B5')->getFont()->setSize(10);
        $sheet->getRowDimension(4)->setRowHeight(18);
        $sheet->getRowDimension(5)->setRowHeight(24);

        $sheet->getStyle('B1:S5')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle('A5:S5')->getBorders()->getBottom()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        // ========== Judul Rekap ==========
        $sheet->mergeCells('A7:S7');
        $sheet->mergeCells('A8:S8');
        $sheet->setCellValue('A7', 'REKAPITULASI SURAT KETERANGAN TIDAK MAMPU (SKTM)');
        $sheet->setCellValue('A8', 'Periode : ' . $namaBulanIndo . ' ' . $tahun);

        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A8')->getFont()->setSize(11);
        $sheet->getStyle('A7:A8')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // ========== Header Tabel ==========
        $headerRow = 10;
        $sheet->setCellValue('A' . $headerRow, 'No');
        $sheet->setCellValue('B' . $headerRow, 'Tanggal Pengajuan');
        $sheet->setCellValue('C' . $headerRow, 'Nomor Surat');
        $sheet->setCellValue('D' . $headerRow, 'Nama Pemohon');
        $sheet->setCellValue('E' . $headerRow, 'NIK');
        $sheet->setCellValue('F' . $headerRow, 'Tempat Lahir');
        $sheet->setCellValue('G' . $headerRow, 'Tgl Lahir');
        $sheet->setCellValue('H' . $headerRow, 'Jenis Kelamin');
        $sheet->setCellValue('I' . $headerRow, 'Warganegara');
        $sheet->setCellValue('J' . $headerRow, 'Agama');
        $sheet->setCellValue('K' . $headerRow, 'Pekerjaan');
        $sheet->setCellValue('L' . $headerRow, 'Nama Ibu');
        $sheet->setCellValue('M' . $headerRow, 'Alamat');
        $sheet->setCellValue('N' . $headerRow, 'ID DTKS');
        $sheet->setCellValue('O' . $headerRow, 'Penghasilan Bulanan');
        $sheet->setCellValue('P' . $headerRow, 'Keperluan');
        $sheet->setCellValue('Q' . $headerRow, 'No. Telepon');
        $sheet->setCellValue('R' . $headerRow, 'Status');
        $sheet->setCellValue('S' . $headerRow, 'Petugas');

        $sheet->getStyle('A' . $headerRow . ':S' . $headerRow)
            ->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A' . $headerRow . ':S' . $headerRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
        $sheet->getStyle('A' . $headerRow . ':S' . $headerRow)
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('1147A7');

        // ========== Isi Data ==========
        $rowIndex = $headerRow + 1;
        $no = 1;

        foreach ($rows as $r) {
            $sheet->setCellValue('A' . $rowIndex, $no++);
            $sheet->setCellValue('B' . $rowIndex, \Carbon\Carbon::parse($r->created_at)->format('d-m-Y'));
            $sheet->setCellValue('C' . $rowIndex, $r->nomor_surat);
            $sheet->setCellValue('D' . $rowIndex, $r->nama_pemohon);

            $sheet->setCellValueExplicit('E' . $rowIndex, (string)$r->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            $sheet->setCellValue('F' . $rowIndex, $r->tempat_lahir);
            $sheet->setCellValue('G' . $rowIndex, \Carbon\Carbon::parse($r->tanggal_lahir)->format('d-m-Y'));
            $sheet->setCellValue('H' . $rowIndex, $r->jenis_kelamin);
            $sheet->setCellValue('I' . $rowIndex, $r->warganegara);
            $sheet->setCellValue('J' . $rowIndex, $r->agama);
            $sheet->setCellValue('K' . $rowIndex, $r->pekerjaan);
            $sheet->setCellValue('L' . $rowIndex, $r->nama_orang_tua);
            $sheet->setCellValue('M' . $rowIndex, $r->alamat);

            $sheet->setCellValueExplicit('N' . $rowIndex, (string)($r->id_dtks ?? ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('O' . $rowIndex, (string)$r->penghasilan_bulanan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

            $sheet->setCellValue('P' . $rowIndex, $r->keperluan);
            $sheet->setCellValueExplicit('Q' . $rowIndex, (string)$r->telepon_pemohon, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('R' . $rowIndex, $r->status);

            $petugasNama = $petugasMap[$r->id_user] ?? '';
            $sheet->setCellValue('S' . $rowIndex, $petugasNama);

            $rowIndex++;
        }

        $lastDataRow = max($headerRow + 1, $rowIndex - 1);

        // Border & Align
        $sheet->getStyle('A' . $headerRow . ':S' . $lastDataRow)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A' . ($headerRow + 1) . ':S' . $lastDataRow)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
        $sheet->getStyle('M' . ($headerRow + 1) . ':P' . $lastDataRow)
            ->getAlignment()->setWrapText(true);

        // ========== Tanda Tangan ==========
        $signRow = $lastDataRow + 3;
        $sheet->mergeCells('N' . $signRow . ':S' . $signRow);
        $sheet->mergeCells('N' . ($signRow + 1) . ':S' . ($signRow + 1));
        $sheet->mergeCells('N' . ($signRow + 4) . ':S' . ($signRow + 4));

        $sheet->setCellValue('N' . $signRow, 'Kademangan, ' . date('d-m-Y'));
        $sheet->setCellValue('N' . ($signRow + 1), $jabatanTtd);
        $sheet->setCellValue('N' . ($signRow + 4), strtoupper($namaTtd));

        $sheet->getStyle('N' . $signRow . ':S' . ($signRow + 4))
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('N' . ($signRow + 4) . ':S' . ($signRow + 4))
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // ========== Output Download Laravel ==========
        $filename = 'Rekap_SKTM_' . $bulanParam . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate',
            'Pragma' => 'public'
        ]);
    }
}
