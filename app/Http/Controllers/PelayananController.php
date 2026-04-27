<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\SuratSktm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelayananController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pelayanan Kelurahan',
            'cards' => Layanan::orderByDesc('id')->get(),
        ];

        return view('pelayanan.index', compact('data'));
    }

    public function show($slug)
    {
        $layanan = Layanan::where('slug', $slug)->firstOrFail();

        if (!$layanan->is_active) {
            return redirect()
                ->route('pelayanan.index')
                ->with('error', 'Pelayanan sedang tutup.');
        }

        return match ($slug) {
            'tidak-mampu' => $this->tidakMampu($layanan),
            default => abort(404, 'Form pelayanan belum tersedia.'),
        };
    }

    public function tidakMampu(Layanan $layanan)
    {
        $data = [
            'title' => 'Formulir SKTM',
            'subtitle' => 'Lengkapi data berikut secara lengkap dan benar.',
            'layanan' => $layanan,
        ];

        return view('pelayanan.forms.sktm', compact('data'));
    }

    public function submitSktm(Request $request)
    {
        $layanan = Layanan::where('slug', 'tidak-mampu')->firstOrFail();

        if (!$layanan->is_active) {
            return redirect()
                ->route('pelayanan.index')
                ->with('error', 'Pelayanan sedang tutup.');
        }

        $validated = $request->validate([
            'nomor_surat_rt' => ['required', 'string', 'max:100'],
            'tanggal_surat_rt' => ['required', 'date'],

            'dokumen_pendukung' => ['required', 'array', 'min:1'],
            'dokumen_pendukung.*' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],

            'nama_pemohon' => ['required', 'string', 'max:150'],
            'telepon_pemohon' => ['required', 'numeric'],
            'nik' => ['required', 'digits:16'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'string', 'max:50'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'warganegara' => ['required', 'string', 'max:50'],
            'penghasilan_bulanan' => ['required', 'string', 'max:100'],
            'nama_orang_tua' => ['required', 'string', 'max:150'],
            'id_dtks' => ['nullable', 'string', 'max:100'],
            'keperluan' => ['required', 'string', 'max:255'],
            'agree' => ['required', 'accepted'],
        ], [
            'dokumen_pendukung.required' => 'Minimal 1 dokumen pendukung harus diunggah.',
            'dokumen_pendukung.*.mimes' => 'Dokumen pendukung harus berupa PDF, JPG, JPEG, atau PNG.',
            'dokumen_pendukung.*.max' => 'Ukuran setiap dokumen maksimal 2 MB.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit.',
            'agree.required' => 'Persetujuan wajib dicentang.',
            'agree.accepted' => 'Persetujuan wajib dicentang.',
        ]);

        $uploadedFiles = $this->uploadDokumenPendukung($request);

        SuratSktm::create([
            'nomor_surat_rt' => $validated['nomor_surat_rt'],
            'tanggal_surat_rt' => $validated['tanggal_surat_rt'],
            'dokumen_pendukung' => json_encode($uploadedFiles),

            'nama_pemohon' => $validated['nama_pemohon'],
            'telepon_pemohon' => $validated['telepon_pemohon'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'warganegara' => $validated['warganegara'],
            'agama' => $validated['agama'],
            'pekerjaan' => $validated['pekerjaan'],
            'nama_orang_tua' => $validated['nama_orang_tua'],
            'alamat' => $validated['alamat'],
            'id_dtks' => $validated['id_dtks'] ?? null,
            'penghasilan_bulanan' => $validated['penghasilan_bulanan'],
            'keperluan' => $validated['keperluan'],
        ]);

        return redirect()
            ->route('pelayanan.sukses')
            ->with('success', 'Pengajuan SKTM Anda telah berhasil dikirim.');
    }

    public function sukses()
    {
        if (!session('success')) {
            return redirect()->route('pelayanan.index');
        }

        $data = [
            'title' => 'Pengajuan Berhasil',
        ];

        return view('pelayanan.sukses', compact('data'));
    }

    private function uploadDokumenPendukung(Request $request): array
    {
        $uploadedFiles = [];

        foreach ($request->file('dokumen_pendukung', []) as $file) {
            $uploadedFiles[] = $file->store('pendukung', 'public');
        }

        return $uploadedFiles;
    }
}