<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LoginLogController extends Controller
{
    public function index(Request $request)
    {
        $title = "Riwayat Login";
        $breadcrumbs = [
            ['label' => 'Pengaturan', 'url' => null],
            ['label' => $title, 'url' => null],
        ];

        $query = LoginLog::with('user.citizenDetail', 'user.staffDetail')->latest();

        // 1. Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 2. Filter Perangkat
        if ($request->filled('device')) {
            $query->where('device', $request->device);
        }

        // 3. Filter Username/NIK
        if ($request->filled('q')) {
            $query->where('username', 'LIKE', '%' . $request->q . '%');
        }

        // Eksekusi Export CSV
        if ($request->export == 'csv') {
            return $this->exportCsv($query->get());
        }

        // Eksekusi Export PDF
        if ($request->export == 'pdf') {
            return $this->exportPdf($query->get());
        }

        // Pagination untuk tampilan web (appends digunakan agar filter tetap jalan saat pindah halaman)
        $logs = $query->paginate(20)->appends($request->query());

        return view('admin.login_logs.index', compact('title', 'breadcrumbs', 'logs'));
    }

    private function exportCsv($logs)
    {
        $fileName = 'riwayat_login_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Waktu', 'Username/NIK', 'Nama User', 'Status', 'IP Address', 'Lokasi', 'Perangkat', 'Browser'];

        $callback = function () use ($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                $name = $log->user ? ($log->user->citizenDetail->full_name ?? ($log->user->staffDetail->full_name ?? 'Admin')) : 'Tidak Ditemukan';

                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->username,
                    $name,
                    $log->status,
                    $log->ip_address,
                    $log->location,
                    $log->device,
                    $log->browser
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportPdf($logs)
    {
        $pdf = Pdf::loadView('admin.login_logs.pdf', compact('logs'))->setPaper('a4', 'landscape');
        return $pdf->download('riwayat_login_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
