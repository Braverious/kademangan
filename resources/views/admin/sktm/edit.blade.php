<x-admin.header :title="$title" />
<x-admin.sidebar />

@php
    $can_full = isset($can_full_edit) && $can_full_edit === true;
@endphp

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit SKTM</h4>

        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>

            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.sktm.index') }}">Data SKTM</a>
            </li>

            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>

            <li class="nav-item">
                <a>Edit Data</a>
            </li>
        </ul>
    </div>

    {{-- ALERT --}}
    @if (!$can_full)
        <div class="alert alert-info">
            Anda login sebagai <b>admin</b>. Anda hanya dapat mengubah <b>Status</b> dan <b>Nomor Surat</b>.
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">

            <div class="card">

                {{-- HEADER --}}
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">
                            Formulir Edit Data: {{ $surat->nama_pemohon }}
                        </h4>

                        <a href="{{ route('admin.sktm.detail', $surat->id) }}"
                            class="btn btn-secondary btn-round ml-auto">
                            Batal
                        </a>
                    </div>
                </div>

                {{-- FORM --}}
                <form action="{{ route('admin.sktm.update', $surat->id) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- ================= ADMINISTRASI ================= --}}
                        <h5>Administrasi Surat</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input type="text" name="nomor_surat" class="form-control"
                                        value="{{ $surat->nomor_surat }}"
                                        placeholder="Contoh: 400.12.3.1/123 - Pemerintahan">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Pengajuan</label>
                                    <select name="status" class="form-control">
                                        <option value="Pending" {{ $surat->status == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Disetujui" {{ $surat->status == 'Disetujui' ? 'selected' : '' }}>
                                            Disetujui</option>
                                        <option value="Ditolak" {{ $surat->status == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- ================= DATA PEMOHON ================= --}}
                        <h5 class="mb-3">Data Pemohon</h5>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pemohon</label>
                                    <input type="text" name="nama_pemohon" class="form-control"
                                        value="{{ $surat->nama_pemohon }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" class="form-control"
                                        value="{{ $surat->nik }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="telepon_pemohon" class="form-control"
                                        value="{{ $surat->telepon_pemohon }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ $surat->tempat_lahir }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ $surat->tanggal_lahir }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" {{ $can_full }} required>
                                        <option value="Laki-laki"
                                            {{ $surat->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ $surat->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>

                                    @if (!$can_full)
                                        <input type="hidden" name="jenis_kelamin" value="{{ $surat->jenis_kelamin }}">
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Warganegara</label>
                                    <input type="text" name="warganegara" class="form-control"
                                        value="{{ $surat->warganegara }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" name="agama" class="form-control"
                                        value="{{ $surat->agama }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control"
                                        value="{{ $surat->pekerjaan }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" {{ $can_full }} required>{{ $surat->alamat }}</textarea>
                                </div>
                            </div>

                        </div>

                        <hr class="my-3">

                        {{-- ================= DATA KETERANGAN ================= --}}
                        <h5 class="mb-3">Data Keterangan</h5>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Orang tua</label>
                                    <input type="text" name="nama_orang_tua" class="form-control"
                                        value="{{ $surat->nama_orang_tua }}" {{ $can_full }} required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ID DTKS (Opsional)</label>
                                    <input type="text" name="id_dtks" class="form-control"
                                        value="{{ $surat->id_dtks }}" {{ $can_full }}>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penghasilan Bulanan</label>
                                    <select name="penghasilan_bulanan" class="form-control" {{ $can_full }}
                                        required>

                                        <option value="Kurang dari Rp 1.000.000"
                                            {{ $surat->penghasilan_bulanan == 'Kurang dari Rp 1.000.000' ? 'selected' : '' }}>
                                            Kurang dari Rp 1.000.000</option>
                                        <option value="Rp 1.000.000 - Rp 2.500.000"
                                            {{ $surat->penghasilan_bulanan == 'Rp 1.000.000 - Rp 2.500.000' ? 'selected' : '' }}>
                                            Rp 1.000.000 - Rp 2.500.000</option>
                                        <option value="Rp 2.500.001 - Rp 4.000.000"
                                            {{ $surat->penghasilan_bulanan == 'Rp 2.500.001 - Rp 4.000.000' ? 'selected' : '' }}>
                                            Rp 2.500.001 - Rp 4.000.000</option>
                                        <option value="Lebih dari Rp 4.000.000"
                                            {{ $surat->penghasilan_bulanan == 'Lebih dari Rp 4.000.000' ? 'selected' : '' }}>
                                            Lebih dari Rp 4.000.000</option>
                                    </select>

                                    @if (!$can_full)
                                        <input type="hidden" name="penghasilan_bulanan"
                                            value="{{ $surat->penghasilan_bulanan }}">
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keperluan</label>
                                    <input type="text" name="keperluan" class="form-control"
                                        value="{{ $surat->keperluan }}" {{ $can_full }} required>
                                </div>
                            </div>

                        </div>

                        <hr>

                        {{-- ================= FILE ================= --}}
                        <h5>Dokumen Pendukung & Data Pengantar RT/RW</h5>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat RT/RW</label>
                                    <input type="text" name="nomor_surat_rt" class="form-control"
                                        value="{{ $surat->nomor_surat_rt }}" {{ $can_full }}>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Surat RT/RW</label>
                                    <input type="date" name="tanggal_surat_rt" class="form-control"
                                        value="{{ $surat->tanggal_surat_rt }}" {{ $can_full }}>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Unggah Dokumen Pendukung</label>

                                    <input type="file" name="dokumen_pendukung[]" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png" multiple {{ $can_full }}>

                                    @php
                                        $files = [];
                                        if (!empty($surat->dokumen_pendukung)) {
                                            $decoded = json_decode($surat->dokumen_pendukung, true);
                                            if (is_array($decoded)) {
                                                $files = $decoded;
                                            } elseif (is_string($surat->dokumen_pendukung)) {
                                                $files = [$surat->dokumen_pendukung];
                                            }
                                        }
                                    @endphp

                                    <div class="mt-2">
                                        <label>Lampiran Saat Ini:</label>

                                        @if ($files)
                                            <ul class="list-unstyled">
                                                @foreach ($files as $fn)
                                                    <li class="mb-1">
                                                        <i class="fa fa-paperclip"></i>
                                                        <a href="{{ asset('uploads/pendukung/' . $fn) }}"
                                                            target="_blank">
                                                            {{ $fn }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">Belum ada dokumen</span>
                                        @endif
                                    </div>

                                    <ul id="dokListAdmin" class="small mt-2 text-muted"></ul>
                                </div>
                            </div>

                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.querySelector('input[name="dokumen_pendukung[]"]');
        var list = document.getElementById('dokListAdmin');

        if (!input || !list) return;

        input.addEventListener('change', function() {
            list.innerHTML = '';
            Array.from(this.files).forEach(function(f) {
                var li = document.createElement('li');
                li.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                list.appendChild(li);
            });
        });
    });
</script>

<x-admin.footer />
